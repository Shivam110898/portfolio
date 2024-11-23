import numpy as np
import tensorflow as tf
from tensorflow import keras
from tensorflow.keras.models import Sequential, Model
from tensorflow.keras.layers import ZeroPadding2D, Convolution2D, MaxPooling2D
from tensorflow.keras.layers import Dense, Dropout, Softmax, Flatten, Activation, BatchNormalization
from tensorflow.keras.preprocessing.image import load_img, img_to_array
from tensorflow.keras.applications.imagenet_utils import preprocess_input
import tensorflow.keras.backend as K
import os
from Model import FaceModel
from PIL import Image
from mtcnn import MTCNN
from skimage import io
from detection import MTCnnDetector
import cv2
from io import BytesIO

def classify(img : Image.Image):
    classifier_model = tf.keras.models.load_model("face_classifier_model.h5")
    person_rep = {0: 'Virat Kohli', 1: 'David Beckham'}
    # convert to array
    pixels = np.asarray(img)
    # create the detector, using default weights
    detector = MTCNN()
    # detect faces in the image
    results = detector.detect_faces(pixels)
    # extract the bounding box from the first face
    x1, y1, width, height = results[0]['box']
    # bug fix
    x1, y1 = abs(x1), abs(y1)
    x2, y2 = x1 + width, y1 + height
    # extract the face
    face = pixels[y1:y2, x1:x2]
    # resize pixels to the model size
    image = Image.fromarray(face)
    img_crop = image

    # Get Embeddings
    size = 224, 224
    temp = img_crop.resize(size)
    crop_img = temp
    crop_img = img_to_array(crop_img)
    crop_img = np.expand_dims(crop_img, axis=0)
    crop_img = preprocess_input(crop_img)
    img_encode = FaceModel(crop_img)

    # Make Predictions
    embed = K.eval(img_encode)
    person = classifier_model.predict(embed)
    prediction = person_rep[np.argmax(person)]
    return prediction

def read_imagefile(file) -> Image.Image:
    image = Image.open(BytesIO(file))
    return image

