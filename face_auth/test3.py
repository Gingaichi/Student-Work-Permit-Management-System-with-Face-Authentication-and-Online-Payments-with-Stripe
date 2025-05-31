import cv2
import dlib
import numpy as np
import face_recognition
import os
import tkinter as tk
from tkinter import messagebox

# Load dlib's face detector and landmark predictor
detector = dlib.get_frontal_face_detector()
predictor = dlib.shape_predictor("shape_predictor_68_face_landmarks.dat")

# 3D model points (for head pose estimation)
model_points = np.array([
    (0.0, 0.0, 0.0),  # Nose tip
    (0.0, -330.0, -65.0),  # Chin
    (-225.0, 170.0, -135.0),  # Left eye left corner
    (225.0, 170.0, -135.0),  # Right eye right corner
    (-150.0, -150.0, -125.0),  # Left Mouth corner
    (150.0, -150.0, -125.0)  # Right mouth corner
], dtype=np.float64)

def show_success_popup():
    root = tk.Tk()
    root.withdraw()  # Hide the main window
    messagebox.showinfo("Success", "Verification Successful!")
    root.destroy()

def mouse_callback(event, x, y, flags, param):
    if event == cv2.EVENT_LBUTTONDOWN:
        # Check if click is within close button bounds
        h = param['frame_height']
        if x > param['frame_width'] and x < param['frame_width'] + 300 and y > h - 50 and y < h - 20:
            param['should_close'] = True

def verify_face(image_path):
    # Load the reference image
    image = face_recognition.load_image_file(image_path)
    known_encoding = face_recognition.face_encodings(image)[0]
    known_face_encodings = [known_encoding]
    known_face_names = ['Valid']

    # Start webcam feed
    cap = cv2.VideoCapture(0)
    ret, frame = cap.read()
    size = frame.shape
    focal_length = size[1]
    center = (size[1] / 2, size[0] / 2)
    camera_matrix = np.array([
        [focal_length, 0, center[0]],
        [0, focal_length, center[1]],
        [0, 0, 1]
    ], dtype=np.float64)
    dist_coeffs = np.zeros((4, 1))

    # Head pose tracking variables
    yaw_values = []
    yaw_threshold = 20
    liveness_confirmed = False
    verification_successful = False
    success_frames_counter = 0

    instructions = [
        "1. Please align your face with the camera.",
        "2. Keep your face steady for a moment.",
        "3. Move your head left and right as prompted.",
        "4. Face should match the uploaded image."
    ]

    # Create window and set mouse callback
    window_name = "Liveness Detection + Instructions"
    cv2.namedWindow(window_name)
    callback_params = {
        'frame_width': frame.shape[1],
        'frame_height': frame.shape[0],
        'should_close': False
    }
    cv2.setMouseCallback(window_name, mouse_callback, callback_params)

    while True:
        ret, frame = cap.read()
        if not ret:
            break

        rgb = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

        face_locations = face_recognition.face_locations(rgb)
        encodings = face_recognition.face_encodings(rgb, face_locations)
        dlib_faces = detector(gray)

        for (top, right, bottom, left), encoding in zip(face_locations, encodings):
            matches = face_recognition.compare_faces(known_face_encodings, encoding)
            name = "Unknown"

            if True in matches:
                for d in dlib_faces:
                    shape = predictor(gray, d)

                    image_points = np.array([
                        (shape.part(30).x, shape.part(30).y),
                        (shape.part(8).x, shape.part(8).y),
                        (shape.part(36).x, shape.part(36).y),
                        (shape.part(45).x, shape.part(45).y),
                        (shape.part(48).x, shape.part(48).y),
                        (shape.part(54).x, shape.part(54).y)
                    ], dtype=np.float64)

                    success, rotation_vector, _ = cv2.solvePnP(
                        model_points, image_points, camera_matrix, dist_coeffs
                    )

                    rmat, _ = cv2.Rodrigues(rotation_vector)
                    proj_matrix = np.hstack((rmat, np.zeros((3, 1))))
                    _, _, _, _, _, _, euler_angles = cv2.decomposeProjectionMatrix(proj_matrix)
                    yaw = euler_angles[1, 0]

                    yaw_values.append(yaw)
                    if len(yaw_values) > 10:
                        yaw_values.pop(0)

                    yaw_left = any(y < -yaw_threshold for y in yaw_values)
                    yaw_right = any(y > yaw_threshold for y in yaw_values)
                    yaw_center = any(abs(y) < 10 for y in yaw_values)

                    if yaw_left and yaw_right and yaw_center:
                        liveness_confirmed = True

                if liveness_confirmed:
                    name = known_face_names[matches.index(True)]
                    success_frames_counter += 1
                    if success_frames_counter >= 10:
                        verification_successful = True
                else:
                    name = "Spoof Attempt"
                    success_frames_counter = 0
            else:
                success_frames_counter = 0

            color = (0, 0, 255) if name == "Unknown" or name == "Spoof Attempt" else (0, 255, 0)
            cv2.rectangle(frame, (left, top), (right, bottom), color, 2)
            cv2.putText(frame, name, (left, top - 10),
                        cv2.FONT_HERSHEY_SIMPLEX, 0.7, (255, 255, 255), 2)

        # Combine webcam frame + instruction panel
        h, w, _ = frame.shape
        instruction_panel = np.ones((h, 300, 3), dtype=np.uint8) * 255

        # Add instructions
        for i, line in enumerate(instructions):
            y = 40 + i * 35
            cv2.putText(instruction_panel, line, (10, y), cv2.FONT_HERSHEY_SIMPLEX,
                        0.7, (0, 0, 0), 1, cv2.LINE_AA)

        # Add close button
        cv2.rectangle(instruction_panel, (10, h-50), (290, h-20), (200, 200, 200), -1)
        cv2.putText(instruction_panel, "Close Window", (85, h-30),
                    cv2.FONT_HERSHEY_SIMPLEX, 0.7, (0, 0, 0), 2)

        combined = np.hstack((frame, instruction_panel))
        cv2.imshow(window_name, combined)

        if verification_successful or callback_params['should_close'] or (cv2.waitKey(1) & 0xFF == ord('q')):
            break

    cap.release()
    cv2.destroyAllWindows()

    if verification_successful:
        show_success_popup()
        return True
    return False

if __name__ == "__main__":
    # Test with a sample image
    verify_face("uploads/uploaded_image.jpg")
