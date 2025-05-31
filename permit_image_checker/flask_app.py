from flask import Flask, request, jsonify
import cv2
import numpy as np
import os
from flask_cors import CORS

app = Flask(__name__)

def is_white(pixel, threshold=220):
    return all(channel >= threshold for channel in pixel)

def check_white_background(image_path, border_size=10, white_threshold=0.80):
    image = cv2.imread(image_path)
    if image is None:
        return False

    height, width, _ = image.shape
    top = image[0:border_size, :]
    left = image[:, 0:border_size]
    right = image[:, -border_size:]

    border_pixels = []

    for region in [top, left, right]:
        for row in region:
            for pixel in row:
                border_pixels.append(pixel)

    white_pixels = sum(1 for pixel in border_pixels if is_white(pixel))
    ratio = white_pixels / len(border_pixels)

    if ratio >= white_threshold:
        return True
    else:
        return False

@app.route('/check-background', methods=['POST'])
def check_background():
    try:
        if 'file' not in request.files:
            return jsonify({'error': 'No file part'}), 400

        file = request.files['file']

        if file.filename == '':
            return jsonify({'error': 'No selected file'}), 400

        if file:
            # Save the uploaded image temporarily
            img_path = os.path.join('uploads', 'uploaded_image.jpg')
            os.makedirs('uploads', exist_ok=True)
            file.save(img_path)

            # Check if the image has a white background
            is_white_bg = check_white_background(img_path)

            if is_white_bg:
                return jsonify({'message': 'Image has a white background'}), 200
            else:
                return jsonify({'message': 'Image does not have a white'}), 200

    except Exception as e:
        return jsonify({'error': str(e)}), 500


if __name__ == '__main__':
    app.run(debug=False)
