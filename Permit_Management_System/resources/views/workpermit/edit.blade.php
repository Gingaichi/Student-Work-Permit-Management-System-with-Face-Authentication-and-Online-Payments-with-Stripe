<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Work Permit Application</title>
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

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .submit-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        .submit-btn:hover {
            background-color: #2980b9;
        }

        .file-upload {
            margin-bottom: 20px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        label {
            font-weight: bold;
        }

        .required {
            color: red;
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
                        <h1>Edit Your Work Permit Application</h1>
                        <form action="{{ route('workpermit.update', $workpermit->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $workpermit->phone) }}" required>
                                @error('phone')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="dob">Date of Birth</label>
                                <input type="date" id="dob" name="dob" value="{{ old('dob', $workpermit->dob) }}" required>
                                @error('dob')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nationality">Nationality</label>
                                <input type="text" id="nationality" name="nationality" value="{{ old('nationality', $workpermit->nationality) }}" required>
                                @error('nationality')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="passport_number">Passport Number</label>
                                <input type="text" id="passport_number" name="passport_number" value="{{ old('passport_number', $workpermit->passport_number) }}" required>
                                @error('passport_number')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="job_title">Job Title</label>
                                <input type="text" id="job_title" name="job_title" value="{{ old('job_title', $workpermit->job_title) }}" required>
                                @error('job_title')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="employer">Employer</label>
                                <input type="text" id="employer" name="employer" value="{{ old('employer', $workpermit->employer) }}" required>
                                @error('employer')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="workplace_address">Workplace Address</label>
                                <input type="text" id="workplace_address" name="workplace_address" value="{{ old('workplace_address', $workpermit->workplace_address) }}" required>
                                @error('workplace_address')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="employment_duration">Employment Duration (months)</label>
                                <input type="text" id="employment_duration" name="employment_duration" value="{{ old('employment_duration', $workpermit->employment_duration) }}" required>
                                @error('employment_duration')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Application Letter -->
                            <div class="file-upload">
                                <label for="app_letter">Application Letter <span class="required">*</span></label>
                                <label class="custom-file-upload">
                                    <input type="file" id="app_letter" name="app_letter">
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
                                    <input type="file" id="passport_photo" name="passport_photo">
                                    Choose File
                                </label>
                                <span id="passport_photo_name">.</span>
                                @error('passport_photo')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Employment Contract -->
                            <div class="file-upload">
                                <label for="employment_contract">Employment Contract <span class="required">*</span></label>
                                <label class="custom-file-upload">
                                    <input type="file" id="employment_contract" name="employment_contract">
                                    Choose File
                                </label>
                                <span id="employment_contract_name">.</span>
                                @error('employment_contract')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- CV -->
                            <div class="file-upload">
                                <label for="cv">Curriculum Vitae <span class="required">*</span></label>
                                <label class="custom-file-upload">
                                    <input type="file" id="cv" name="cv">
                                    Choose File
                                </label>
                                <span id="cv_name">.</span>
                                @error('cv')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Professional Clearance -->
                            <div class="file-upload">
                                <label for="professional_clearance">Professional Clearance <span class="required">*</span></label>
                                <label class="custom-file-upload">
                                    <input type="file" id="professional_clearance" name="professional_clearance">
                                    Choose File
                                </label>
                                <span id="professional_clearance_name">.</span>
                                @error('professional_clearance')
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
