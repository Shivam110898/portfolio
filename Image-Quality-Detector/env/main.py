import tensorflow as tf 
import numpy as np 
from tensorflow.keras.preprocessing import image

glareCNN = tf.keras.models.load_model('env/model/glare/glare_detect.h5')

def infer(img_path,img_name):
    test_image1 = image.load_img(str(img_path)+str(img_name), target_size = (64,64)) #reading an image from the given path and scaling to 64x64
    test_image2 = image.img_to_array(test_image1) #convert PIL image to array
    test_image2 = np.expand_dims(test_image2, axis = 0) #expand image dimensions to make it compatible with CNN input
    result = glareCNN.predict(test_image2/255) #Values in the array scaled from [0,255] -> [0,1]
    return test_image1,result #returning image for viewing and the associated CNN output

def pred(score):
    pred_class = "" #defining variable to store predictions
    if score[0][0] <0.5: #CNN model refers to 0 as "glare" and 1 as "not glare", applying a threshold for both cases.
        pred_class = "Glare" #values less than 0.5
    else:
        pred_class = "Not Glare" #values greater than 0.5
    return pred_class

img_path = 'env/images/'
img = 'img2.png'

image_calc,result = infer(img_path,img)

classification = pred(result)

image_calc

print(result, classification)
