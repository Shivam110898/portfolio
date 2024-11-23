# import the necessary packages
from imutils.video import VideoStream
import argparse
import imutils
import time
import cv2
import os
import numpy as np
from mtcnn import MTCNN
path = '/Users/Shiv/Desktop/Python/facerecog/venv'

# load OpenCV's Haar cascade for face detection from disk
detector = MTCNN()
# initialize the video stream, allow the camera sensor to warm up,
# and initialize the total number of example faces written to disk
# thus far
print("[INFO] starting video stream...")
vs = VideoStream(src=0).start()
# vs = VideoStream(usePiCamera=True).start()
time.sleep(2.0)
total = 0

# loop over the frames from the video stream
while True:
    # grab the frame from the threaded video stream, clone it, (just
    # in case we want to write it to disk), and then resize the frame
    # so we can apply face detection faster
    frame = vs.read()

    # create the detector, using default weights
    detector = MTCNN()
    # detect faces in the image
    results = detector.detect_faces(frame)
    # extract the bounding box from the first face
    x1, y1, width, height = results[0]['box']
    # bug fix
    x1, y1 = abs(x1), abs(y1)
    x2, y2 = x1 + width, y1 + height
    # extract the face
    face = results[y1:y2, x1:x2]
    # resize pixels to the model size
    image = Image.fromarray(face)
    image = image.resize((224, 224))


    # detect faces in the grayscale frame
    rects = detector.detect_faces(frame)
    # loop over the face detections and draw them on the frame
    for (x, y, w, h) in rects:
        cv2.rectangle(frame, (x, y), (x + w, y + h), (0, 255, 0), 2)
        # show the output frame
        cv2.imshow("Frame", frame)
        key = cv2.waitKey(1) & 0xFF

    # if the `k` key was pressed, write the *original* frame to disk
    # so we can later process it and use it for face recognition
    if key == ord("k"):
        img_path = path + '/Images_crop/' + file_name.split('/')[-1].split('.jpg')[0] + '/' + file_name.split('/')[-1]
        image.save(img_path)
        total += 1
    # if the `q` key was pressed, break from the loop
    elif key == ord("q"):
        break


# print the total faces saved and do a bit of cleanup
print("[INFO] {} face images stored".format(total))
print("[INFO] cleaning up...")
cv2.destroyAllWindows()
vs.stop()