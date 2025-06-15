<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Application</title>
    <link rel="stylesheet" href="{{ url('CSS/dashboard.css') }}">
    <style>
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 300px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
        }

        .content {
            margin-left: 300px; /* Add margin equal to sidebar width */
            width: calc(100% - 300px); /* Adjust width to account for sidebar */
            padding: 20px;
        }

        .edit-box {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 0 auto;
        }

        /* Ensure form elements don't overflow */
        .edit-box form {
            width: 100%;
        }

        .edit-box form div {
            margin-bottom: 15px;
        }

        .edit-box form input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        /* Adjust card layout */
        .cards {
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .custom-file-upload {
            display: inline-block;
            padding: 8px 15px;
            cursor: pointer;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            margin-top: 5px;
        }

        .custom-file-upload input[type="file"] {
            display: none;
        }

        .file-upload span {
            margin-left: 10px;
            color: #555;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <h2>Dashboard</h2>
            <ul>
                <li><a href="{{ url('/applicantdashboard') }}">Home</a></li>
                
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </li>
            </ul>
        </aside>
        
        <main class="content">
            <div class="cards">
                <div class="card">
                    <div class="edit-box">
                        <h1>Edit Your Application</h1>
                        <form action="{{ route('application.update', $application->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $application->phone) }}" required>
                                @error('phone')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="dob">Date of Birth</label>
                                <input type="date" id="dob" name="dob" value="{{ old('dob', $application->dob) }}" required>
                                @error('dob')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="name">Full Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $application->name) }}" required>
                                @error('name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $application->email) }}" required>
                                @error('email')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nationality">Nationality</label>
                                <input type="text" id="nationality" name="nationality" value="{{ old('nationality', $application->nationality) }}" required>
                                @error('nationality')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="id_number">Passport Number</label>
                                <input type="text" id="id_number" name="id_number" value="{{ old('id_number', $application->id_number) }}" required>
                                @error('id_number')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="course">Course of Study</label>
                                <input type="text" id="course" name="course" value="{{ old('course', $application->course) }}" required>
                                @error('course')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="institution">Institution Name</label>
                                <input type="text" id="institution" name="institution" value="{{ old('institution', $application->institution) }}" required>
                                @error('institution')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="current_address">Current Place of Residence</label>
                                <input type="text" id="current_address" name="current_address" value="{{ old('current_address', $application->current_address) }}" required>
                                @error('current_address')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="duration">Duration of Stay</label>
                                <input type="text" id="duration" name="duration" value="{{ old('duration', $application->duration) }}" required>
                                @error('duration')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Approval Letter -->
                            <div class="file-upload">
                                <label for="app_letter">Approval Letter <span class="required">*</span></label>
                                <label class="custom-file-upload">
                                    <input type="file" id="app_letter" name="app_letter" required>
                                    Choose File
                                </label>
                                <span id="app_letter_name">.</span>
                                @error('app_letter')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Passport Photo -->
                            <div class="file-upload">
                                <label for="passport_photo">Passport Photo <span class="required">*</span></label>
                                <label class="custom-file-upload">
                                    <input type="file" id="passport_photo" name="passport_photo" required>
                                    Choose File
                                </label>
                                <span id="passport_photo_name">.</span>
                                @error('passport_photo')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Birth Certificate -->
                            <div class="file-upload">
                                <label for="birth_certificate">Birth Certificate <span class="required">*</span></label>
                                <label class="custom-file-upload">
                                    <input type="file" id="birth_certificate" name="birth_certificate" required>
                                    Choose File
                                </label>
                                <span id="birth_certificate_name">,</span>
                                @error('birth_certificate')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="submit-btn">Update Application</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- JavaScript to handle file name display -->
    <script>
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function () {
                const fileNameSpan = document.getElementById(this.id + '_name');
                fileNameSpan.textContent = this.files[0]?.name || 'No file selected';
            });
        });
    </script>
</body>
</html>
