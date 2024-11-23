# -*- coding: utf-8 -*-
"""
@author: shiv
"""

import rospy
import cv2
import numpy
from sensor_msgs.msg import Image
from geometry_msgs.msg import Twist
from cv_bridge import CvBridge
import actionlib 
from move_base_msgs.msg import MoveBaseAction, MoveBaseGoal, MoveBaseActionFeedback

class robot:
    def __init__(self):
        #initialise variables
        self.bridge = CvBridge()
        self.image_sub = rospy.Subscriber("/camera/rgb/image_raw", Image, self.callback)
        self.client = rospy.Subscriber("/move_base/feedback", MoveBaseActionFeedback, self.moveToNextWaypoint)    
        self.cmd_vel_pub = rospy.Publisher('/mobile_base/commands/velocity', Twist, queue_size=1)        
        self.twist = Twist()
        
        
        #variables to decide whether the colour has been found 
        self.redFound = False
        self.greenFound = False
        self.blueFound = False
        self.yellowFound = False
        
        #set waypoint coordinates, 5 points in total that the robot traverses through
        self.WP_1x = 1.500
        self.WP_1y = -4.430
        self.WP_1_Move = False
        self.WP_1_Reached = False
        
        self.WP_2x = 2.000
        self.WP_2y = 0.000
        self.WP_2_Move = False
        self.WP_2_Reached = False
        
        self.WP_3x = -0.499
        self.WP_3y = -1.399
        self.WP_3_Move = False
        self.WP_3_Reached = False
        
        self.WP_4x = 0.000
        self.WP_4y = 4.460
        self.WP_4_Move = False
        self.WP_4_Reached = False
        
        self.WP_5x = -4.399
        self.WP_5y = 1.530
        self.WP_5_Move = False
        self.WP_5_Reached = False
        
        #set position of the robot
        self.robot_posX = 0
        self.robot_posY = 0
        
    def callback(self, data):
        #read image from robot
        robot_cv_image = self.bridge.imgmsg_to_cv2(data, "bgr8")
        
        #convert image to hsv format
        robot_hsv_image = cv2.cvtColor(robot_cv_image, cv2.COLOR_BGR2HSV)       
        
        #declare image variables to perform operations on
        robot_hsv_thresh = cv2.inRange(robot_hsv_image, numpy.array((255, 255, 255)),numpy.array((255, 255, 205)))       
        robot_hsv_pixels = cv2.moments(robot_hsv_thresh)
        
        #declare each colour object variables
        redObject = robot_hsv_pixels
        greenObject = robot_hsv_pixels
        blueObject = robot_hsv_pixels
        yellowObject = robot_hsv_pixels 
        
        #check if each colour is in the image by using numpy colour thresholds
        if self.redFound == False: 
            red_thresh = cv2.inRange(robot_hsv_image,
                                     numpy.array((0, 200, 30)),
                                     numpy.array((5, 255, 150)))
            redObject = cv2.moments(red_thresh)
        elif self.yellowFound == False: 
            yellow_thresh = cv2.inRange(robot_hsv_image,
                                     numpy.array((30, 200, 30)),
                                     numpy.array((40, 255, 200)))
            yellowObject = cv2.moments(yellow_thresh)
        elif self.blueFound == False: 
            blue_thresh = cv2.inRange(robot_hsv_image,
                                     numpy.array((90, 200, 30)),
                                     numpy.array((120, 255, 230)))
            blueObject = cv2.moments(blue_thresh)
        elif self.greenFound == False:
            green_thresh = cv2.inRange(robot_hsv_image,
                                     numpy.array((60, 200, 30)),
                                     numpy.array((80, 255, 200)))
            greenObject = cv2.moments(green_thresh)
                
        #check if all objects are found
        if self.redFound == True and self.greenFound == True and self.blueFound == True and self.yellowFound:
            actionClient = actionlib.SimpleActionClient("/move_base", MoveBaseAction)
            actionClient.cancel_goal()            
            rospy.loginfo("All objects found!")
            rospy.signal_shutdown("All objects found!")
                     
      # Check to see which objects have not been found, and whether or not
      # a coloured object covers most of the screen so the robot doesn't crash
      # into obstacles.      
        
        if redObject['m00'] > 600000 and self.redFound == False: 
            robot_hsv_thresh = red_thresh
            self.redFound = self.moveToObject(robot_cv_image, robot_hsv_thresh)
        
        #  After the first object, check to see if the previous coloured object have
        #  been found. 
        elif yellowObject['m00'] > 600000 and self.yellowFound == False and self.redFound == True:
            robot_hsv_thresh = yellow_thresh
            self.yellowFound = self.moveToObject(robot_cv_image, robot_hsv_thresh)
        
        elif blueObject['m00'] > 600000 and self.blueFound == False and self.yellowFound == True:
            robot_hsv_thresh = blue_thresh
            self.blueFound = self.moveToObject(robot_cv_image, robot_hsv_thresh)
        
        elif greenObject['m00'] > 600000 and self.greenFound == False and self.blueFound == True:
            robot_hsv_thresh = green_thresh
            self.greenFound = self.moveToObject(robot_cv_image, robot_hsv_thresh)      
        else:
            
            #if no object is seen, the robot goes to the 5 waypoints in order
            if self.WP_1_Reached == False and self.WP_1_Move == False:
                self.moveToWaypoint(self.WP_1x, self.WP_1y, 1)            
            elif self.WP_2_Reached == False and self.WP_1_Reached == True and self.WP_2_Move == False:
                self.moveToWaypoint(self.WP_2x, self.WP_2y, 2)           
            elif self.WP_3_Reached == False and self.WP_2_Reached == True and self.WP_3_Move == False:
                self.moveToWaypoint(self.WP_3x, self.WP_3y, 3)           
            elif self.WP_4_Reached == False and self.WP_3_Reached == True and self.WP_4_Move == False:
                self.moveToWaypoint(self.WP_4x, self.WP_4y, 4)           
            elif self.WP_5_Reached == False and self.WP_4_Reached == True and self.WP_5_Move == False:
                self.moveToWaypoint(self.WP_5x, self.WP_5y, 5) 
        
        #show what the robot sees, and the threshold image          
        cv2.imshow("HSV Image Window", robot_hsv_thresh)
        cv2.waitKey(1)       
        cv2.imshow("Object Finder Image", robot_cv_image)  
        cv2.waitKey(2)
   
   #function to move the robot towards a coloured object            
    def moveToObject(self, robot_cv_image, robot_hsv_thresh):        
        h,w,d = robot_cv_image.shape
        search_top = h*0.5
        search_bot = h * 0.80
        stopDist = h * 0.80     
        
        #action client to cancel the current goal so that finding
        #object takes priority over the waypoints         
        actionClient = actionlib.SimpleActionClient("/move_base", MoveBaseAction)
        actionClient.cancel_goal()
        
        #if object is directly infront of the robot, output object found
        if robot_hsv_thresh[stopDist:h, 0:w].any():
            rospy.loginfo("Object found!")
            return True
            
        robot_hsv_thresh[0:search_top, 0:w] = 0
        robot_hsv_thresh[search_bot:h, 0:w] = 0
            
        M = cv2.moments(robot_hsv_thresh)
        # Check that object is in the threshold image   
        if M['m00'] > 0:
            # find the distance of the object from the centre of the screen
            # for course correction
            cx = int(M['m10']/M['m00'])
            cy = int(M['m01']/M['m00'])
            cv2.circle(robot_cv_image, (cx, cy), 20, (0,0,255), -1)
            #calculate error for correction
            err = cx - w/2
            #publish twist message to move the robot
            self.twist.linear.x = 0.7
            self.twist.angular.z = -float(err) / 100
            self.cmd_vel_pub.publish(self.twist)
          
        return False
    #function to move the robot through the waypoints    
    def moveToWaypoint(self, x, y, goalNum):
       
       #initialise action client to move the robot through the waypoints
       actionClient = actionlib.SimpleActionClient("/move_base", MoveBaseAction)

       #wait until it's available 
       while(not actionClient.wait_for_server(rospy.Duration.from_sec(5.0))):
           rospy.loginfo("Waiting for server to come online...")
       
       goal = MoveBaseGoal()
       goal.target_pose.header.frame_id = "map"
       goal.target_pose.header.stamp = rospy.Time.now()
       
       #goal positions
       goal.target_pose.pose.position.x = x
       goal.target_pose.pose.position.y = y
       goal.target_pose.pose.orientation.x = 0.0
       goal.target_pose.pose.orientation.y = 0.0
       goal.target_pose.pose.orientation.z = 0.0
       if goalNum == 5:
           goal.target_pose.pose.orientation.z = -0.5
       goal.target_pose.pose.orientation.w = 1.0
       
       actionClient.send_goal(goal)

       #change waypoint status to 'move' to stop the program from calling the same
        #same message on repeat
       if goalNum == 1:
           self.WP_1_Move = True
           print "Current waypoint: " + str(goalNum)
       elif goalNum == 2:
           self.WP_2_Move = True
           print "Current waypoint: " + str(goalNum)
       elif goalNum == 3:
           self.WP_3_Move = True
           print "Current waypoint: " + str(goalNum)
       elif goalNum == 4:
           self.WP_4_Move = True
           print "Current waypoint: " + str(goalNum)
       elif goalNum == 5:
           self.WP_5_Move = True
           print "Current waypoint: " + str(goalNum)
   
   #function to move to next waypoint once the robot has reached one waypoint     
    def moveToNextWaypoint(self, data):
        # find current robot position
        self.robot_posX = data.feedback.base_position.pose.position.x
        self.robot_posY = data.feedback.base_position.pose.position.y
        error = 0.5     
        
        # if the robot is in the error region specified, waypoint is reached
        if self.WP_1_Move == True and self.WP_1_Reached == False:
            if self.robot_posX >= (self.WP_1x - error) and self.robot_posX <= (self.WP_1x + error) and self.robot_posY >= (self.WP_1y - error) and self.robot_posY <= (self.WP_1y + error):
                self.WP_1_Reached = True
        
        elif self.WP_2_Move == True and self.WP_2_Reached == False:
            if self.robot_posX >= (self.WP_2x - error) and self.robot_posX <= (self.WP_2x + error) and self.robot_posY >= (self.WP_2y - error) and self.robot_posY <= (self.WP_2y + error):
                self.WP_2_Reached = True
        
        elif self.WP_3_Move == True and self.WP_3_Reached == False:
            if self.robot_posX >= (self.WP_3x - error) and self.robot_posX <= (self.WP_3x + error) and self.robot_posY >= (self.WP_3y - error) and self.robot_posY <= (self.WP_3y + error):
                self.WP_3_Reached = True
        
        elif self.WP_4_Move == True and self.WP_4_Reached == False:
            if self.robot_posX >= (self.WP_4x - error) and self.robot_posX <= (self.WP_4x + error) and self.robot_posY >= (self.WP_4y - error) and self.robot_posY <= (self.WP_4y + error):
                self.WP_4_Reached = True
       
        elif self.WP_5_Move == True and self.WP_5_Reached == False:
            if self.robot_posX >= (self.WP_5x - error) and self.robot_posX <= (self.WP_5x + error) and self.robot_posY >= (self.WP_5y - error) and self.robot_posY <= (self.WP_5y + error):
                self.WP_5_Reached = True
                
if __name__ == '__main__':
    cv2.startWindowThread()
    rospy.init_node("robot", anonymous=True)
    cv = robot()
        
                
            
            
            
            
            


                                        
            
        
        
        
        
