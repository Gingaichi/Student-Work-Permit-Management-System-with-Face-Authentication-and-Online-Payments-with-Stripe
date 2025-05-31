import cv2
import face_recognition
import dlib
import numpy as np
from imutils.video import VideoStream
from scipy.spatial import distance
import time

# EAR calculation
def eye_aspect_ratio(eye):
    A = distance.euclidean(eye[1], eye[5])
    B = distance.euclidean(eye[2], eye[4])
    C = distance.euclidean(eye[0], eye[3])
    return (A + B) / (2.0 * C)

# Constants
EAR_THRESHOLD = 0.2
BLINK_FRAMES_REQUIRED = 2
PROCESS_EVERY_N_FRAMES = 5

# Load known face
known_image = face_recognition.load_image_file("sichi.jpeg")
known_encoding = face_recognition.face_encodings(known_image)[0]
known_face_encodings = [known_encoding]
known_face_names = ["Sichi"]

# Dlib setup
predictor = dlib.shape_predictor("shape_predictor_68_face_landmarks.dat")
detector = dlib.get_frontal_face_detector()

# Eye landmark indices
LEFT_EYE = list(range(36, 42))
RIGHT_EYE = list(range(42, 48))

# Start threaded webcam stream
vs = VideoStream(src=0).start()
time.sleep(1.0)  # Let camera warm up

blink_counter = 0
liveness_confirmed = False
frame_count = 0

while True:
    frame = vs.read()
    if frame is None:
        continue

    small_frame = cv2.resize(frame, (0, 0), fx=0.25, fy=0.25)  # Faster processing
    rgb_small_frame = cv2.cvtColor(small_frame, cv2.COLOR_BGR2RGB)
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

    name = "Unknown"
    face_locations = []
    face_encodings = []

    if frame_count % PROCESS_EVERY_N_FRAMES == 0:
        face_locations = face_recognition.face_locations(rgb_small_frame)
        face_encodings = face_recognition.face_encodings(rgb_small_frame, face_locations)

    for i, (top, right, bottom, left) in enumerate(face_locations):
        # Scale back up face locations since the frame was scaled down
        top *= 4
        right *= 4
        bottom *= 4
        left *= 4

        face_encoding = face_encodings[i]
        matches = face_recognition.compare_faces(known_face_encodings, face_encoding)

        if True in matches:
            face_roi = dlib.rectangle(left, top, right, bottom)
            shape = predictor(gray, face_roi)
            shape_np = np.array([[p.x, p.y] for p in shape.parts()])

            left_eye = shape_np[LEFT_EYE]
            right_eye = shape_np[RIGHT_EYE]

            left_ear = eye_aspect_ratio(left_eye)
            right_ear = eye_aspect_ratio(right_eye)
            ear = (left_ear + right_ear) / 2.0

            if ear < EAR_THRESHOLD:
                blink_counter += 1
            else:
                if blink_counter >= BLINK_FRAMES_REQUIRED:
                    liveness_confirmed = True
                blink_counter = 0

            name = known_face_names[0] if liveness_confirmed else "Spoof Attempt"

        color = (0, 255, 0) if name != "Spoof Attempt" else (0, 0, 255)
        cv2.rectangle(frame, (left, top), (right, bottom), color, 2)
        cv2.putText(frame, name, (left, top - 10), cv2.FONT_HERSHEY_SIMPLEX, 0.9, (255, 255, 255), 2)

    frame_count += 1
    cv2.imshow("Optimized Video", frame)

    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

vs.stop()
cv2.destroyAllWindows()
