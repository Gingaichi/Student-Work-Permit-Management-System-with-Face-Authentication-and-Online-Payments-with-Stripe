<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Permit Application Form</title>
    <link rel="stylesheet" href="{{ url('CSS/studentpermitstyle.css') }}">
</head>
<body>
    <div class="form-container">
        <h1>Work Permit Application Form</h1>
        <h2>Welcome, {{ auth()->user()->name }}</h2>
        <form action="{{ route('submit-work-permit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="step step-1 active">
                <!-- Personal Information -->
                <label for="name">Full Name <span class="required">*</span></label>
                <input type="text" id="name" name="name" required placeholder="Enter your full name" value="{{ old('name') }}">
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="email">Email Address <span class="required">*</span></label>
                <input type="email" id="email" name="email" required placeholder="Enter your email address">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="phone">Phone Number <span class="required">*</span></label>
                <input type="tel" id="phone" name="phone" required placeholder="Enter your phone number">
                @error('phone')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="dob">Date of Birth <span class="required">*</span></label>
                <input type="date" id="dob" name="dob" required>
                @error('dob')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="nationality">Nationality <span class="required">*</span></label>
                <input type="text" id="nationality" name="nationality" required placeholder="Enter your nationality">
                @error('nationality')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="passport_number">Passport Number <span class="required">*</span></label>
                <input type="text" id="passport_number" name="passport_number" required placeholder="Enter your passport number">
                @error('passport_number')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="job_title">Job Title <span class="required">*</span></label>
                <input type="text" id="job_title" name="job_title" required placeholder="Enter your job title">
                @error('job_title')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="employer">Employer Name <span class="required">*</span></label>
                <input type="text" id="employer" name="employer" required placeholder="Enter your employer's name">
                @error('employer')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="workplace_address">Workplace Address <span class="required">*</span></label>
                <input type="text" id="workplace_address" name="workplace_address" required placeholder="Enter workplace address">
                @error('workplace_address')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="employment_duration">Duration of Employment(months) <span class="required">*</span></label>
                <input type="text" id="employment_duration" name="employment_duration" required placeholder="Enter duration of employment">
                @error('employment_duration')
                    <div class="error">{{ $message }}</div>
                @enderror

                <button type="button" class="next-btn">Next</button>
            </div>

            <div class="step step-2">
                <h2>Submit Documents</h2>

                <!-- Application Letter -->
                <div class="file-upload">
                    <label for="app_letter">Application Letter <span class="required">*</span></label>
                    <label class="custom-file-upload">
                        <input type="file" id="app_letter" name="app_letter" required>
                        Choose File
                    </label>
                    <span id="app_letter_name">No file chosen</span>
                    @error('app_letter')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Passport Photo -->
                <div class="file-upload">
                    <label for="passport_photo">Upload Passport Sized Photo (White background) <span class="required">*</span></label>
                    <label class="custom-file-upload">
                        <input type="file" id="passport_photo" name="passport_photo" required>
                        Choose File
                    </label>
                    <span id="passport_photo_name">No file chosen</span>
                    @error('passport_photo')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Employment Contract -->
                <div class="file-upload">
                    <label for="employment_contract">Employment Contract <span class="required">*</span></label>
                    <label class="custom-file-upload">
                        <input type="file" id="employment_contract" name="employment_contract" required>
                        Choose File
                    </label>
                    <span id="employment_contract_name">No file chosen</span>
                    @error('employment_contract')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- CV -->
                <div class="file-upload">
                    <label for="cv">Curriculum Vitae (CV) <span class="required">*</span></label>
                    <label class="custom-file-upload">
                        <input type="file" id="cv" name="cv" required>
                        Choose File
                    </label>
                    <span id="cv_name">No file chosen</span>
                    @error('cv')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Professional Clearance -->
                <div class="file-upload">
                    <label for="professional_clearance">Professional Body Clearance <span class="required">*</span></label>
                    <label class="custom-file-upload">
                        <input type="file" id="professional_clearance" name="professional_clearance" required>
                        Choose File
                    </label>
                    <span id="professional_clearance_name">No file chosen</span>
                    @error('professional_clearance')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div id="background-check-result" style="display: none;">
                    <p id="background-result-message"></p>
                </div>

                <div id="face-recognition-section" style="display: none;">
                    <button type="button" onclick="startFaceRecognition()">Start Face Recognition</button>
                    <p id="face-recognition-status"></p>
                </div>

                <button type="button" class="prev-btn">Previous</button>
                
                <form action="/checkout" method="POST">
                    @csrf
                    <button type="submit" class="submit-btn">Proceed to Payment</button>
                </form>
            </div>
        </form>
    </div>

    <script src="{{ url('JS/studentpermit.js') }}"></script>
    <script>
        let uploadedImage = null;

        // Handle passport photo upload and background check
        document.getElementById('passport_photo').addEventListener('change', function (e) {
            uploadedImage = e.target.files[0];
            const formData = new FormData();
            formData.append('image', uploadedImage);

            fetch("{{ url('/check-background') }}", {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(response => response.json())
            .then(data => {
                const resultMessage = document.getElementById('background-result-message');
                const resultBox = document.getElementById('background-check-result');

                if (data.message.includes('white background')) {
                    resultMessage.innerText = '✅ Passport photo is valid!';
                    resultMessage.style.color = 'green';
                } else {
                    resultMessage.innerText = '❌ Invalid background. Please use a white background.';
                    resultMessage.style.color = 'red';
                }

                resultBox.style.display = 'block';
                document.getElementById('face-recognition-section').style.display = 'block';
            })
            .catch(error => {
                console.error('Background check error:', error);
                alert('Error during background check.');
            });
        });

        // Start face recognition
        function startFaceRecognition() {
            if (!uploadedImage) {
                document.getElementById('face-recognition-status').innerText = '❌ No image uploaded.';
                return;
            }

            document.getElementById('face-recognition-status').innerText = 'Launching camera for face recognition...';

            const formData = new FormData();
            formData.append('image', uploadedImage);

            fetch('http://127.0.0.1:5001/start-camera', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                document.getElementById('face-recognition-status').innerText = '';
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('face-recognition-status').innerText = '';
            });
        }

        // Handle file name display for all file inputs
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                const fileName = this.files[0]?.name || 'No file chosen';
                const fileNameSpan = document.getElementById(this.id + '_name');
                if (fileNameSpan) {
                    fileNameSpan.textContent = fileName;
                }
            });
        });
    </script>
</body>
</html>
