from vpython import *
import numpy as np

# Constants
g = 9.81  # gravitational acceleration (m/s^2)
ball_mass = 0.156  # Mass of a cricket ball (in kg)
ball_radius = 0.036  # Radius of a cricket ball (in meters)

# Time parameters
t = 0
dt = 0.03  # Time step (seconds)

# Coefficient of restitution for bounce (how much speed remains after bounce)
restitution_coefficient = 0.6  # Typically around 0.5 to 0.7 for a cricket ball

# Scene Setup for Bowler's Perspective
scene = canvas(title="Cricket Ball Trajectory with Wickets", width=800, height=600, center=vector(11, 0.75, 0))
scene.camera.pos = vector(-10, 1, 0)  # Position the camera behind the bowler (looking down the pitch)
scene.camera.axis = vector(22, 0, 0)  # Make the camera look down the pitch toward the batsman
scene.range = 15  # Adjust zoom to see the entire pitch

# Create the ground (pitch)
ground = box(pos=vector(11, -ball_radius, 0), size=vector(22, 0.01, 3), color=color.green)

# Create the cricket ball
ball = sphere(pos=vector(1.2, 1.5, -0.7), radius=ball_radius, color=color.red, make_trail=True)

# Initial conditions for downward release
initial_velocity = vector(30, -1, 0)  # m/s (v_x = 30, v_y = -5, v_z = 0)
ball.velocity = initial_velocity  # Initial velocity

# Wicket dimensions and positions
wicket_height = 0.71  # Height of the stumps (in meters)
wicket_diameter = 0.02  # Diameter of the stumps

# Draw the stumps at the bowler's end
stump1_bowler = cylinder(pos=vector(0, 0, -0.11), axis=vector(0, wicket_height, 0), radius=wicket_diameter/2, color=color.white)
stump2_bowler = cylinder(pos=vector(0, 0, 0), axis=vector(0, wicket_height, 0), radius=wicket_diameter/2, color=color.white)
stump3_bowler = cylinder(pos=vector(0, 0, 0.11), axis=vector(0, wicket_height, 0), radius=wicket_diameter/2, color=color.white)

# Draw the stumps at the batsman's end
stump1_batsman = cylinder(pos=vector(22, 0, -0.11), axis=vector(0, wicket_height, 0), radius=wicket_diameter/2, color=color.white)
stump2_batsman = cylinder(pos=vector(22, 0, 0), axis=vector(0, wicket_height, 0), radius=wicket_diameter/2, color=color.white)
stump3_batsman = cylinder(pos=vector(22, 0, 0.11), axis=vector(0, wicket_height, 0), radius=wicket_diameter/2, color=color.white)

# Function to compute the force due to gravity
def gravitational_force():
    return vector(0, -ball_mass * g, 0)

# Handle the bounce: reverse the Y velocity and reduce it by restitution_coefficient
def handle_bounce():
    if ball.pos.y <= ball_radius:  # When the ball hits the ground (Y=0)
        ball.velocity.y = -ball.velocity.y * restitution_coefficient  # Reverse and reduce Y velocity
        ball.pos.y = ball_radius  # Reset position to avoid sinking into the ground
        # Add some deviation (lateral or swing effect) after the bounce based on detections (simulated)
        ball.velocity.x = ball.velocity.x * 0.95  # Simulate slight slowing in horizontal direction
        ball.velocity.z = 1  # Simulate deviation along the z-axis for swing or spin

# Simulate the ball trajectory
while ball.pos.x < 22:  # Simulate until the ball reaches the batsman's end (22 yards)
    rate(100)  # Control simulation speed

    # Compute forces
    F_gravity = gravitational_force()

    # Update velocity and position using Newton's second law: F = ma
    ball.velocity = ball.velocity + (F_gravity / ball_mass) * dt
    ball.pos = ball.pos + ball.velocity * dt

    # Handle bounce if the ball hits the ground
    handle_bounce()

    # Update time
    t += dt
