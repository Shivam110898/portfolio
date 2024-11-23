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
import matplotlib.pyplot as plt

path = '/Users/Shiv/Desktop/Python/facerecog/venv'


def remove_hidden_file(filetoexlude):
    if '.DS_Store' in filetoexlude:
        filetoexlude.remove('.DS_Store')

    return filetoexlude


# Define VGG_FACE_MODEL architecture
model = Sequential()
model.add(ZeroPadding2D((1, 1), input_shape=(224, 224, 3)))
model.add(Convolution2D(64, (3, 3), activation='relu'))
model.add(ZeroPadding2D((1, 1)))
model.add(Convolution2D(64, (3, 3), activation='relu'))
model.add(MaxPooling2D((2, 2), strides=(2, 2)))
model.add(ZeroPadding2D((1, 1)))
model.add(Convolution2D(128, (3, 3), activation='relu'))
model.add(ZeroPadding2D((1, 1)))
model.add(Convolution2D(128, (3, 3), activation='relu'))
model.add(MaxPooling2D((2, 2), strides=(2, 2)))
model.add(ZeroPadding2D((1, 1)))
model.add(Convolution2D(256, (3, 3), activation='relu'))
model.add(ZeroPadding2D((1, 1)))
model.add(Convolution2D(256, (3, 3), activation='relu'))
model.add(ZeroPadding2D((1, 1)))
model.add(Convolution2D(256, (3, 3), activation='relu'))
model.add(MaxPooling2D((2, 2), strides=(2, 2)))
model.add(ZeroPadding2D((1, 1)))
model.add(Convolution2D(512, (3, 3), activation='relu'))
model.add(ZeroPadding2D((1, 1)))
model.add(Convolution2D(512, (3, 3), activation='relu'))
model.add(ZeroPadding2D((1, 1)))
model.add(Convolution2D(512, (3, 3), activation='relu'))
model.add(MaxPooling2D((2, 2), strides=(2, 2)))
model.add(ZeroPadding2D((1, 1)))
model.add(Convolution2D(512, (3, 3), activation='relu'))
model.add(ZeroPadding2D((1, 1)))
model.add(Convolution2D(512, (3, 3), activation='relu'))
model.add(ZeroPadding2D((1, 1)))
model.add(Convolution2D(512, (3, 3), activation='relu'))
model.add(MaxPooling2D((2, 2), strides=(2, 2)))
model.add(Convolution2D(4096, (7, 7), activation='relu'))
model.add(Dropout(0.5))
model.add(Convolution2D(4096, (1, 1), activation='relu'))
model.add(Dropout(0.5))
model.add(Convolution2D(2622, (1, 1)))
model.add(Flatten())
model.add(Activation('softmax'))
# Load VGG Face model weights
model.load_weights('vgg_face_weights.h5')

FaceModel = Model(inputs=model.layers[0].input, outputs=model.layers[-2].output)

# Prepare Training Data
x_train = []
y_train = []
person_folders = remove_hidden_file(os.listdir(path + '/Images_crop/'))
person_rep = dict()
for i, person in enumerate(person_folders):
    CroppedImages = os.listdir('Images_crop/' + person + '/')
    person_rep[i] = person
    for image_name in CroppedImages:
        img = load_img(path + '/Images_crop/' + person + '/' + image_name, target_size=(224, 224))
        img = img_to_array(img)
        img = np.expand_dims(img, axis=0)
        img = preprocess_input(img)
        img_encode = FaceModel(img)
        x_train.append(np.squeeze(K.eval(img_encode)).tolist())
        y_train.append(i)

x_train = np.array(x_train)
y_train = np.array(y_train)

# Prepare Test Data
x_test = []
y_test = []
person_folders = os.listdir(path + '/Test_Images_crop/')
for i, person in enumerate(person_folders):
    image_names = os.listdir('Test_Images_crop/' + person + '/')
    for image_name in image_names:
        img = load_img(path + '/Test_Images_crop/' + person + '/' + image_name, target_size=(224, 224))
        img = img_to_array(img)
        img = np.expand_dims(img, axis=0)
        img = preprocess_input(img)
        img_encode = FaceModel(img)
        x_test.append(np.squeeze(K.eval(img_encode)).tolist())
        y_test.append(i)

x_test = np.array(x_test)
y_test = np.array(y_test)

# Save test and train data for later use
np.save('train_data', x_train)
np.save('train_labels', y_train)
np.save('test_data', x_test)
np.save('test_labels', y_test)
