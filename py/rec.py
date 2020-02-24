#!/home/j01ozgrhka5w/chardpy/bin/python3
import numpy as np
from imageio import imread
import requests
import json
import sys
import os
import codecs
import base64

# generate labels = a list of chinese characters.
LABELS_PATH = os.path.join("../py/data", "labels.txt")
label_file = codecs.open(LABELS_PATH, "r", "UTF-8")
labels = [a.strip() for a in label_file.readlines()]
label_file.close()

# preprocess an input image
args_infile = '../php/character.png'

img_ = imread(args_infile).astype(np.float32)
image_ = img_[:,:,0]
#image_ = (img_[:,:,0] + img_[:,:,1] + img_[:,:,2])/3.
#print (imread(args_infile).shape)
#print (imread(args_infile))
#image = np.expand_dims(imread(args_infile)[:,:,3],2).astype(np.float32)
image = np.expand_dims(image_,2).astype(np.float32)
image /= 255.0

# setup the request
model_name = "anchor01"
my_app_name = 'chinese-recog'
url = "https://%s.herokuapp.com" % (my_app_name)
full_url = "%s/v1/models/%s/versions/1:predict" % (url,model_name)

data = {"signature_name":"prediction",
        "instances":[{"images":image.tolist()}]}
data = json.dumps(data)

try:
    response = requests.post(full_url,data=data)
    response = response.json()
    highest_index = np.argmax(response['predictions'])
    bestPred = labels[highest_index]
    
    encodedBytes = base64.b64encode(bestPred.encode("utf-8"))
    encodedStr = str(encodedBytes, "utf-8")
    
    returnCode = encodedStr
    print(returnCode)
except:
    print(sys.exc_info()[0])