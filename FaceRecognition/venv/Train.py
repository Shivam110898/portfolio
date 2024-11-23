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


class Train:
    def __init__(self, x_train, y_train, x_test, y_test):
        self.y_test = y_test
        self.x_test = x_test
        self.y_train = y_train
        self.x_train = x_train

    def classifier(self):
        # Softmax regressor to classify images based on encoding
        classifier_model = Sequential()
        classifier_model.add(Dense(units=100, input_dim=self.x_train.shape[1], kernel_initializer='glorot_uniform'))
        classifier_model.add(BatchNormalization())
        classifier_model.add(Activation('tanh'))
        classifier_model.add(Dropout(0.3))
        classifier_model.add(Dense(units=10, kernel_initializer='glorot_uniform'))
        classifier_model.add(BatchNormalization())
        classifier_model.add(Activation('tanh'))
        classifier_model.add(Dropout(0.2))
        classifier_model.add(Dense(units=6, kernel_initializer='he_uniform'))
        classifier_model.add(Activation('softmax'))
        classifier_model.compile(loss=tf.keras.losses.SparseCategoricalCrossentropy(), optimizer='nadam',
                                 metrics=['accuracy'])

        classifier_model.fit(self.x_train, self.y_train, epochs=100, validation_data=(self.x_test, self.y_test))
        # Save model for later use
        tf.keras.models.save_model(classifier_model, 'face_classifier_model.h5')


if __name__ == "__main__":
    path = '/Users/Shiv/Desktop/Python/facerecog/venv'
    # Load saved data
    loaded_x_train = np.load('train_data.npy')
    loaded_y_train = np.load('train_labels.npy')
    loaded_x_test = np.load('test_data.npy')
    loaded_y_test = np.load('test_labels.npy')

    T = Train(loaded_x_train, loaded_y_train, loaded_x_test, loaded_y_test)
    T.classifier()
