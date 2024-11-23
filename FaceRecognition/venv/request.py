import requests 
from Predict import classify,read_imagefile

img = "/Users/Shiv/Desktop/Python/facerecog/venv/Images_test/davidbeckham.jpg"
i = read_imagefile(img)
response = requests.post('http://127.0.0.1:8000/predict', json=i)
print(response.content)