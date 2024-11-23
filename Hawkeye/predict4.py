import math

import cv2
from sklearn.linear_model import RANSACRegressor, LinearRegression
from sklearn.pipeline import make_pipeline
from sklearn.preprocessing import PolynomialFeatures
from ultralytics import YOLO
import supervision as sv
import numpy as np
import random
import matplotlib.pyplot as plt
from scipy.optimize import least_squares, minimize
from scipy.integrate import solve_ivp
from scipy.interpolate import interp1d

# Constants for the physics model
g = 9.81  # Gravity (m/s^2)
ball_mass = 0.156  # Mass of cricket ball (kg)
ball_radius = 0.036  # Radius of cricket ball (approx. 36 mm)
restitution_coefficient = 0.6  # Coefficient of restitution for bounce


class BallTracker:
    def __init__(self, video_path, output_csv="ball_trajectory.csv"):
        self.bounce_frame = None
        self.video_path = video_path
        self.cap = cv2.VideoCapture(video_path)
        if not self.cap.isOpened():
            raise ValueError("Error opening video file.")

        # Read the first frame for calibration
        ret, self.frame = self.cap.read()
        if not ret:
            raise ValueError("Could not read the first frame from the video.")

        self.stumps_points = []
        self.world_points = []
        self.image_points = []
        self.P = None
        self.model = YOLO('runs/best.pt')  # Load the custom YOLOv8 model
        self.output_csv = output_csv
        self.ball_trajectory = []
        self.ball_positions = []
        self.release_height = 0.00
        self.release_width = 0.00
        self.release_depth = 2.2  # Known release depth (Z_0)

    def get_stumps_points(self, event, x, y, flags, param):
        if event == cv2.EVENT_LBUTTONDOWN:
            self.stumps_points.append((x, y))
            cv2.circle(self.frame, (x, y), 5, (0, 255, 0), -1)
            cv2.imshow("Select Stumps Points", self.frame)
            if len(self.stumps_points) == 12:
                cv2.destroyWindow("Select Stumps Points")
                self.image_points = np.array(self.stumps_points, dtype=np.float32)

    def set_stumps_points(self):
        cv2.imshow("Select Stumps Points", self.frame)
        cv2.setMouseCallback("Select Stumps Points", self.get_stumps_points)
        while True:
            key = cv2.waitKey(1) & 0xFF
            if key == ord('q'):
                break
            if len(self.stumps_points) == 12:
                break

    def calibrate_camera(self):
        # Using standard dimensions of the stumps
        self.world_points = np.array([
            [0, 1.0, 0], [0, 1.0, 0.71],  # Middle Stump (Bowler's End)
            [-0.11, 1.0, 0], [-0.11, 1.0, 0.71],  # Off Stump (Bowler's End)
            [0.11, 1.0, 0], [0.11, 1.0, 0.71],  # Leg Stump (Bowler's End)
            [0, 21.12, 0], [0, 21.12, 0.71],  # Middle Stump (Batter's End)
            [-0.11, 21.12, 0], [-0.11, 21.12, 0.71],  # Off Stump (Batter's End)
            [0.11, 21.12, 0], [0.11, 21.12, 0.71],  # Leg Stump (Batter's End)
        ], dtype=np.float32)

        self.P = self.compute_projection_matrix(self.world_points, self.image_points)
        print("Camera matrix P:\n", self.P)
        self.test_projection_matrix()

    def compute_projection_matrix(self, world_points, image_points):
        A = []
        for i in range(len(world_points)):
            X, Y, Z = world_points[i]
            x, y = image_points[i]
            A.append([-X, -Y, -Z, -1, 0, 0, 0, 0, x * X, x * Y, x * Z, x])
            A.append([0, 0, 0, 0, -X, -Y, -Z, -1, y * X, y * Y, y * Z, y])
        A = np.array(A)

        _, _, V = np.linalg.svd(A)
        P = V[-1].reshape(3, 4)  # Last row of V is the solution for P
        return P

    def test_projection_matrix(self):
        # Reproject world points using the computed projection matrix
        reprojected_points = []
        for i in range(len(self.world_points)):
            world_point = np.append(self.world_points[i], 1)  # Convert to homogeneous coordinates [X, Y, Z, 1]
            projected = self.P @ world_point  # Apply projection matrix
            projected /= projected[2]  # Normalize by the Z value (homogeneous coordinate)
            x_proj, y_proj = projected[0], projected[1]
            reprojected_points.append([x_proj, y_proj])

        # Compare reprojected points with original image points
        print("Original Image Points vs. Reprojected Points")
        for i in range(len(self.image_points)):
            print(f"Image Point: {self.image_points[i]} - Reprojected: {reprojected_points[i]}")

        # Visualize the reprojected points on the frame
        for pt in reprojected_points:
            x_proj, y_proj = int(pt[0]), int(pt[1])
            cv2.circle(self.frame, (x_proj, y_proj), 5, (0, 0, 255), -1)

        # Show the result with reprojected points
        cv2.imshow("Reprojected Stumps", self.frame)
        cv2.waitKey(0)
        cv2.destroyAllWindows()

    def project_to_image(self, world_point):
        world_point_homog = np.append(world_point, 1).reshape(4, 1)
        image_point_homog = np.dot(self.P, world_point_homog)
        image_point = image_point_homog[:2] / image_point_homog[2]  # De-homogenize
        return tuple(image_point.flatten().astype(int))

    def project_to_world(self, image_point):
        image_point_homog = np.array([image_point[0], image_point[1], 1], dtype=np.float32).reshape(3, 1)
        world_point_homog = np.dot(np.linalg.pinv(self.P), image_point_homog)
        world_point = world_point_homog[:3] / world_point_homog[3]  # De-homogenize
        return world_point.flatten()

    def reproject_stumps(self, frame):
        # Reproject the stumps and crease lines for visualization
        reprojected_image = frame.copy()

        # Draw and label the pitch length
        bowlers_end = self.project_to_image([0, 0, 0])
        batters_end = self.project_to_image([0, 20.12, 0])
        cv2.line(reprojected_image, bowlers_end, batters_end, (0, 255, 255), 2)

        mid_point = ((bowlers_end[0] + batters_end[0]) // 2, (bowlers_end[1] + batters_end[1]) // 2)
        cv2.putText(reprojected_image, "20.12m (22 yards)",
                    mid_point, cv2.FONT_HERSHEY_SIMPLEX, 0.7, (255, 255, 255), 2)

        # Draw bowler's crease (1.22 meters from stumps)
        crease_start = self.project_to_image([-1, 1.22, 0])
        crease_end = self.project_to_image([1, 1.22, 0])
        cv2.line(reprojected_image, crease_start, crease_end, (0, 0, 255), 3)  # Thick red line

        # Highlight the stumps with lines (virtual stumps)
        for i in range(0, 12, 2):
            bottom_point = self.project_to_image(self.world_points[i])
            top_point = self.project_to_image(self.world_points[i + 1])
            cv2.line(reprojected_image, bottom_point, top_point, (0, 255, 0), 2)

        return reprojected_image

    def process_frame(self, frame):
        results = self.model(frame)[0]
        detections = sv.Detections.from_ultralytics(results)
        box_annotator = sv.BoxAnnotator(thickness=2, text_thickness=2, text_scale=1)
        labels = [
            f"{self.model.names[class_id]} {confidence:0.2f}"
            for _, _, confidence, class_id, _ in detections
        ]
        detected_stumps_location = None

        for xyxy, _, confidence, class_id, _ in detections:
            if self.model.names[class_id] == "Stumps":
                if detected_stumps_location is None:
                    detected_stumps_location = xyxy

            if self.model.names[class_id] == "Cricket ball" and confidence > 0.6:
                x_min, y_min, x_max, y_max = xyxy[:4]
                center_x = (x_min + x_max) / 2.0
                center_y = (y_min + y_max) / 2.0
                self.ball_positions.append((int(center_x), int(center_y)))

        frame = box_annotator.annotate(scene=frame, detections=detections, labels=labels)
        return frame

    def custom_ransac_filter(self):
        x_coords, y_coords = zip(*self.ball_positions)
        X = np.array(x_coords).reshape(-1, 1)  # Reshape X to 2D
        y = np.array(y_coords)

        # Split data into pre-bounce and post-bounce based on the lowest point (bounce point)
        bounce_index = np.argmax(y)
        X_pre_bounce, y_pre_bounce = X[:bounce_index + 1], y[:bounce_index + 1]
        X_post_bounce, y_post_bounce = X[bounce_index:], y[bounce_index:]

        # Apply RANSAC for pre-bounce
        ransac_pre = RANSACRegressor(max_trials=200, stop_probability=0.99, min_samples=3)
        ransac_pre.fit(X_pre_bounce, y_pre_bounce)
        inliers_pre = ransac_pre.inlier_mask_

        # Apply RANSAC for post-bounce
        ransac_post = RANSACRegressor(max_trials=200, stop_probability=0.99, min_samples=2)
        ransac_post.fit(X_post_bounce, y_post_bounce)
        inliers_post = ransac_post.inlier_mask_

        # Extract inliers
        pre_bounce_inliers_X = X_pre_bounce[inliers_pre]
        pre_bounce_inliers_y = y_pre_bounce[inliers_pre]
        post_bounce_inliers_X = X_post_bounce[inliers_post]
        post_bounce_inliers_y = y_post_bounce[inliers_post]

        # Apply dual filtering with adjusted thresholds
        filtered_pre_X, filtered_pre_y = self.filter_based_on_xy(pre_bounce_inliers_X, pre_bounce_inliers_y, ransac_pre,
                                                                 max_x_deviation=150, max_y_deviation=200)
        filtered_post_X, filtered_post_y = self.filter_based_on_xy(post_bounce_inliers_X, post_bounce_inliers_y,
                                                                   ransac_post,
                                                                   max_x_deviation=25, max_y_deviation=50)

        # Check if there are enough points to fit a model for pre-bounce
        if filtered_pre_X.size > 0:
            # Fit the model for the pre-bounce segment (quadratic)
            quadratic_pre_bounce = make_pipeline(PolynomialFeatures(degree=2), LinearRegression())
            quadratic_pre_bounce.fit(filtered_pre_X, filtered_pre_y)
            line_X_pre_quad = np.arange(filtered_pre_X.min(), filtered_pre_X.max())[:, np.newaxis]
            line_y_quad_pre = quadratic_pre_bounce.predict(line_X_pre_quad)
        else:
            line_X_pre_quad, line_y_quad_pre = None, None

        # Check if there are enough points to fit a model for post-bounce
        if filtered_post_X.size > 0:
            # Fit the model for the post-bounce segment (linear)
            linear_post_bounce = make_pipeline(PolynomialFeatures(degree=2), LinearRegression())
            linear_post_bounce.fit(filtered_post_X, filtered_post_y)
            line_X_post_lin = np.arange(filtered_post_X.min(), filtered_post_X.max())[:, np.newaxis]
            line_y_linear_post = linear_post_bounce.predict(line_X_post_lin)
        else:
            line_X_post_lin, line_y_linear_post = None, None

        # Extract inliers from the filtered data
        pre_bounce_inliers = [(x, y) for x, y, inlier in zip(filtered_pre_X.flatten(), filtered_pre_y, inliers_pre) if
                              inlier]
        post_bounce_inliers = [(x, y) for x, y, inlier in zip(filtered_post_X.flatten(), filtered_post_y, inliers_post)
                               if inlier]

        # Plot the data points and fitted models
        plt.figure(figsize=(10, 6))
        plt.scatter(X, y, color='gray', alpha=0.5, label='Original Data')
        plt.scatter(filtered_pre_X, filtered_pre_y, color='blue', label='Filtered Pre-bounce Inliers')
        plt.scatter(filtered_post_X, filtered_post_y, color='green', label='Filtered Post-bounce Inliers')

        # Plot the fits if the arrays are not empty
        if line_X_pre_quad is not None and line_y_quad_pre is not None:
            plt.plot(line_X_pre_quad, line_y_quad_pre, color='blue', linewidth=2, linestyle='-',
                     label='Quadratic Fit (Pre-bounce)')
        if line_X_post_lin is not None and line_y_linear_post is not None:
            plt.plot(line_X_post_lin, line_y_linear_post, color='green', linewidth=2, linestyle='-',
                     label='Linear Fit (Post-bounce)')

        # Invert y-axis (to match typical ball trajectory plots)
        plt.gca().invert_yaxis()
        plt.xlabel('X (Pixel)')
        plt.ylabel('Y (Pixel)')
        plt.title('Final Implementation: Adjusted Filtering and Fitting')
        plt.legend()
        plt.grid(True)
        plt.show()

        return pre_bounce_inliers, post_bounce_inliers

    # Define a function for adaptive dual filtering based on x and y deviations
    def filter_based_on_xy(self, X_inliers, y_inliers, ransac_model, max_x_deviation, max_y_deviation):
        predicted_y = ransac_model.predict(X_inliers)
        filtered_X, filtered_y = [], []
        previous_x = X_inliers[0]  # Start with the first x-value
        for x_val, y_val, y_pred in zip(X_inliers, y_inliers, predicted_y):
            x_deviation = abs(x_val - previous_x)
            y_deviation = abs(y_val - y_pred)
            if x_deviation < max_x_deviation and y_deviation < max_y_deviation:
                filtered_X.append(x_val)
                filtered_y.append(y_val)
                previous_x = x_val  # Update the previous x-value to the current one
        return np.array(filtered_X), np.array(filtered_y)

    def calculate_release_position(self, post_ransac_ball_detections):
        # Extract the Y-coordinates of the middle stump's base and top (bowler's end)
        middle_stump_base_y = self.image_points[0][1]  # Y-coordinate of middle stump base
        middle_stump_top_y = self.image_points[1][1]  # Y-coordinate of middle stump top
        stump_world_height = 0.71

        # Calculate pixel height of the middle stump (Y-axis only)
        middle_stump_pixel_height = abs(middle_stump_top_y - middle_stump_base_y)
        pixel_to_meter_ratio_y = stump_world_height / middle_stump_pixel_height

        # Get the Y-coordinate of the release point (first point in post-RANSAC detections)
        release_pixel_y = post_ransac_ball_detections[0][1]
        release_height_in_pixels = middle_stump_top_y - release_pixel_y
        release_height_in_meters = release_height_in_pixels * pixel_to_meter_ratio_y
        total_release_height = stump_world_height + release_height_in_meters

        # Lateral (X-axis) width calculation using top of off-stump and leg-stump at the bowler's end
        off_stump_top_x = self.image_points[3][0]  # X-coordinate of off-stump top (left)
        leg_stump_top_x = self.image_points[5][0]  # X-coordinate of leg-stump top (right)
        stump_world_width = 0.22  # Distance between off-stump and leg-stump tops in meters

        # Calculate pixel width between off-stump and leg-stump tops (X-axis only)
        stump_pixel_width = abs(leg_stump_top_x - off_stump_top_x)
        pixel_to_meter_ratio_x = stump_world_width / stump_pixel_width

        # Get the X-coordinate of the release point (first point in post-RANSAC detections)
        release_pixel_x = post_ransac_ball_detections[0][0]
        release_width_in_pixels = release_pixel_x - off_stump_top_x
        release_width_in_meters = release_width_in_pixels * pixel_to_meter_ratio_x

        # Return both release height and lateral width in meters
        return round(total_release_height, 2), round(release_width_in_meters, 2)

    def test_release_projection(self, post_ransac_ball_detections):
        # Reproject world points using the computed projection matrix
        release_height, release_width = self.calculate_release_position(post_ransac_ball_detections)

        world_point = np.append([release_width, 2.2, release_height], 1)  # Convert to homogeneous coordinates [X, Y, Z, 1]
        projected = self.P @ world_point  # Apply projection matrix
        projected /= projected[2]  # Normalize by the Z value (homogeneous coordinate)
        x_proj, y_proj = projected[0], projected[1]
        x_proj, y_proj = int(x_proj), int(y_proj)

        # Visualize the reprojected points on the frame
        cv2.circle(self.frame, (x_proj, y_proj), 5, (0, 0, 255), -1)

        # Show the result with reprojected points
        cv2.imshow("Reprojected Stumps", self.frame)
        cv2.waitKey(0)
        cv2.destroyAllWindows()

    def simulate_trajectory(self, initial_velocities, t_values):
        """
        Simulates the 3D trajectory of the ball given initial velocities.
        Args:
            initial_velocities: [vx0, vy0, vz0] (initial velocity components)
            t_values: Time values over which to simulate

        Returns:
            Array of 3D trajectory points [X_t, Y_t, Z_t] for each time step.
        """

        initial_release_position = np.array([-0.5, self.release_depth, 2.2])  # Replace with actual release height and width values

        # Initial state includes known position and initial velocities
        state = np.concatenate([initial_release_position, initial_velocities])

        def equations_of_motion(t, state):
            x, y, z, vx, vy, vz = state
            a_z = -g  # Gravity affects only the Z-axis (downward)
            return [vx, vy, vz, 0, 0, a_z]

        def handle_bounce(state):
            x, y, z, vx, vy, vz = state
            if z <= ball_radius:
                z = ball_radius  # Ensure the ball doesn’t go below ground
                vz = -vz * restitution_coefficient  # Reverse and reduce z velocity
            return [x, y, z, vx, vy, vz]

        # Simulate the trajectory using solve_ivp
        trajectory = []
        for t in t_values:
            sol = solve_ivp(equations_of_motion, [t, t + (1/60)], state)
            state = sol.y[:, -1]
            state = handle_bounce(state)
            trajectory.append(state[:3])  # Only x, y, z needed for trajectory points

        return np.array(trajectory)

    def resample_trajectory(self, trajectory_3d, num_points):
        """
        Resample the 3D trajectory to match the number of detected points.
        """
        # Original number of simulated points
        num_simulated_points = len(trajectory_3d)

        # Create an interpolation function for the simulated trajectory
        f_interp = interp1d(np.linspace(0, 1, num_simulated_points), trajectory_3d, axis=0, kind='linear')

        # Generate resampled trajectory with the same number of points as detected 2D points
        resampled_trajectory = f_interp(np.linspace(0, 1, num_points))
        return resampled_trajectory

    def cost_function(self, velocity_params, detected_2d, t_values):
        """
        Cost function to minimize the difference between projected 3D trajectory and detected 2D points.
        Args:
            velocity_params: Initial velocities to be optimized (vx0, vy0, vz0)
            detected_2d: 2D detected points to fit the trajectory to
            t_values: Time values for the trajectory simulation

        Returns:
            Flattened error vector between projected and detected points.
        """
        # Simulate the 3D trajectory with the given velocity parameters
        trajectory_3d = self.simulate_trajectory(velocity_params, t_values)

        # Resample or align trajectory with number of detected points
        trajectory_3d_resampled = self.resample_trajectory(trajectory_3d, len(detected_2d))

        # Project the 3D points to 2D
        projected_2d = [self.project_to_image(point) for point in trajectory_3d_resampled]

        # Compute reprojection error between actual detected and projected points
        projected_2d = np.array(projected_2d)
        error = projected_2d - detected_2d  # Difference in 2D space
        error_flattened = np.sqrt(np.mean(error ** 2))

        return error_flattened  # Flatten the error for least-squares optimization

    def optimize_trajectory(self, detected_2d, t_values):
        """
        Optimize the initial velocity components to match the simulated trajectory with detected points.
        Args:
            detected_2d: Array of 2D detected positions from RANSAC-filtered detections.
            t_values: Time values for each detection.

        Returns:
            Optimized initial velocity parameters.
        """
        # Initial guess for velocities
        initial_velocity_guess = np.array([0.3, 20, 0])  # (vx0, vy0, vz0)

        # Bounds for the velocity components
        bounds = [(-1, 1), (15, 45), (-20, 5)]

        # Define the objective function for minimize (squared error)
        def objective(v_params):
            error = self.cost_function(v_params, detected_2d, t_values)
            return np.sum(error ** 2)  # Sum of squared errors for optimization

        # Run optimization with a different method
        result = minimize(objective, initial_velocity_guess, method='Powell', bounds=bounds, options={'maxiter': 20000})

        # Extract optimized velocities
        optimized_velocities = result.x
        print(
            f"Optimized Velocities: vx0={optimized_velocities[0]}, vy0={optimized_velocities[1]}, vz0={optimized_velocities[2]}")

        # Print optimization status and final cost
        print("Optimization successful:", result.success)
        print("Final cost:", result.fun)

        return optimized_velocities


    def visualize_trajectory(self, optimized_velocities, t_values, post_ransac_ball_detections):
        """
        Visualize the optimized trajectory on the frame.
        """
        # Generate the trajectory starting from the known initial release position
        trajectory_3d = self.simulate_trajectory(optimized_velocities, t_values)

        for point in trajectory_3d:
            projected_2d = self.project_to_image(point)
            cv2.circle(self.frame, projected_2d, 5, (0, 255, 255), -1)

        for detection in post_ransac_ball_detections:
            x, y = detection
            cv2.circle(self.frame, (x, y), 5, (0, 255, 0), -1)  # Draw each detection as a green dot

        cv2.imshow("Trajectory Projection on Frame", self.frame)
        cv2.waitKey(0)
        cv2.destroyAllWindows()

    def compute_t_values(self, max_time=2.0, fps=60):
        """
        Computes time values for simulating the trajectory up to a maximum time.
        Args:
            max_time: Maximum time duration for the simulation (e.g., 2 seconds).
            fps: Frame rate of the video in frames per second.

        Returns:
            Array of time values at intervals matching the frame rate.
        """
        num_steps = int(max_time * fps)  # Number of time steps based on max_time and fps
        return np.linspace(0, max_time, num_steps)


    def run(self):
        """Main method to calibrate camera, detect ball, and optimize the trajectory."""
        self.set_stumps_points()
        self.calibrate_camera()

        while self.cap.isOpened():
            success, frame = self.cap.read()
            if success:
                annotated_frame = self.process_frame(frame)
                cv2.imshow('Frame', annotated_frame)

                if cv2.waitKey(25) & 0xFF == ord('q'):
                    break
            else:
                break


        # # Get 2D ball detections from RANSAC
        pre_bounce_inliers, post_bounce_inliers = self.custom_ransac_filter()
        post_ransac_ball_detections = pre_bounce_inliers + post_bounce_inliers

        # Calculate release height
        self.release_height, self.release_width = self.calculate_release_position(post_ransac_ball_detections)
        print(f"Release height: {self.release_height}")
        print(f"Release Width: {self.release_width}")

        num_detections = len(post_ransac_ball_detections)

        # Compute t_values based on the number of detections and frame rate
        t_values = self.compute_t_values(num_detections)

        detected_2d = np.array(post_ransac_ball_detections)  # 2D detections from RANSAC

        optimized_params = self.optimize_trajectory(detected_2d, t_values)
        print(optimized_params)
        self.visualize_trajectory(optimized_params, t_values, post_ransac_ball_detections)


if __name__ == "__main__":
    tracker = BallTracker("spin.mp4")
    tracker.run()
