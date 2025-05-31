import cv2
import face_recognition

known_face_endodings = []
known_face_names = []

known_person1_image = face_recognition.load_image_file("sichi.jpeg")

known_person1_encoding = face_recognition.face_encodings(known_person1_image)[0]

known_face_endodings.append(known_person1_encoding)

known_face_names.append("Sichi")

#Initialise web cam
video_capture = cv2.VideoCapture(0)

while True:
    #Capture frame by frae
    ret, frame = video_capture.read()

    #Find all face locations in the current frame
    face_locations = face_recognition.face_locations(frame)
    face_encodings = face_recognition.face_encodings(frame, face_locations)

    #Loop through each face found in the frame
    for(top,right,bottom,left), face_encoding in zip(face_locations,face_encodings):
        #Check if the face matches any known faces
        matches = face_recognition.compare_faces(known_face_endodings, face_encoding)
        name="Unknown"

        if True in matches:
            first_match_index = matches.index(True)
            name = known_face_names[first_match_index]

        #Draw a box around the face and label
        cv2.rectangle(frame, (left,top), (right,bottom), (0,0,255),2)
        cv2.putText(frame, name, (left,top -10), cv2.FONT_HERSHEY_SIMPLEX, 0.9, (0,0,255),2)

    cv2.imshow("Video", frame)

    #Break the loop whhn q key is pressed
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

#Release the webcam and close OpenCv window
video_capture.release()
cv2.destroyAllWindows()
