import numpy as np
from imageio import imread
import requests
import json
import sys
import os
import codecs

# generate labels = a list of chinese characters.
LABELS_PATH = os.path.join("./py/data", "labels.txt")
label_file = codecs.open(LABELS_PATH, "r", "UTF-8")
labels = [a.strip() for a in label_file.readlines()]
label_file.close()

# preprocess an input image
args_infile = 'img4.png'

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
url = f"https://{my_app_name}.herokuapp.com"
full_url = f"{url}/v1/models/{model_name}/versions/1:predict"

data = {"signature_name":"prediction",
        "instances":[{"images":image.tolist()}]}
data = json.dumps(data)

try:
    response = requests.post(full_url,data=data)
    response = response.json()
    highest_index = np.argmax(response['predictions'])
    print(labels[highest_index])
except:
    print(sys.exc_info()[0])