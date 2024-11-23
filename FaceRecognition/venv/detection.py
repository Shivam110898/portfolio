from PIL import Image
from matplotlib import pyplot
from mtcnn import MTCNN
from numpy import asarray
from skimage import io


class MTCnnDetector:

    def __init__(self, image_path):
        self.detector = MTCNN()
        self.image = io.imread(image_path)

    def process_image(self):
        faces = self.detect_face()
        resized_face_list = []
        for f in faces:
            extracted_face = self.extract_face(f)
            resized_face = self.resize_img_to_face(extracted_face)
            resized_face_list.append(resized_face)
            self.save_face(resized_face)
            self.plot_face(resized_face)
        return resized_face_list

    def detect_face(self):
        return self.detector.detect_faces(self.image)

    def extract_face(self, face):
        x1, y1, width, height = face['box']
        x2, y2 = x1 + width, y1 + height
        return self.image[y1:y2, x1:x2]

    def resize_img_to_face(self, face):
        image = Image.fromarray(face)
        size = 224, 224
        image = image.resize(size)
        return asarray(image)

    def plot_face(self, face):
        pyplot.imshow(face)
        pyplot.show()

    def save_face(self, face):
        img = Image.fromarray(face)
        img.save("extractedfaces/face02.jpg")


if __name__ == '__main__':
    # Face detector
    face_detector = MTCnnDetector("shiv.jpeg")
    resized_faces = face_detector.process_image()
