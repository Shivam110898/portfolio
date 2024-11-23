# Imports
from fastapi import FastAPI, File, UploadFile, HTTPException
from fastapi.middleware.cors import CORSMiddleware

import uvicorn
from PIL import Image
from typing import List
from pydantic import BaseModel
import sys
from Predict import classify,read_imagefile

class Prediction(BaseModel):
    Name:str


# Define the FastAPI app
app = FastAPI()
origins = [
    "https://localhost:8000",
    "http://localhost",
    "http://localhost:8080",
]

app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)
# Define the main route
@app.get('/')
def root_route():
    return {'error': 'Use GET /prediction instead of the root route!'}


# Define the /prediction route
@app.post('/prediction/',response_model=Prediction)
async def prediction_route(file: UploadFile = File(...)):
    extension = file.filename.split(".")[-1] in ("jpg", "jpeg", "png")
    if not extension:
        return "Image must be jpg or png format!"
    img = read_imagefile(await file.read())
    prediction = classify(img)
    
    return {'Name':prediction}


if __name__ == '__main__':
    uvicorn.run(app, host='127.0.0.1', port=8000)