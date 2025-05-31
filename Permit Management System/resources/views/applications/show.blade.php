<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Application - {{ $application->name }}</title>
    <link rel="stylesheet" href="{{ url('CSS/show.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .nav-bar {
            background-color: #2c3e50;
            padding: 15px 30px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .nav-bar a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .nav-bar a:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .nav-bar i {
            margin-right: 8px;
        }

        /* Add padding to body to account for fixed navbar */
        body {
            padding-top: 80px;
        }
    </style>
</head>
<body>
    <!-- Add nav-bar at the top -->
    <div class="nav-bar">
        <a href="{{ url('/officerdashboard') }}">
            <i class="fas fa-home"></i> Home
        </a>
    </div>

    <main class="pagecontent">
        <div class="pageheader">
            <h1>Full Application for {{ $application->name }}</h1>
        </div>
        <div class="pagedetails">
            <h2>Personal Details</h2>
            <p><strong>Email:</strong> {{ $application->email }}</p>
            <p><strong>Phone:</strong> {{ $application->phone }}</p>
            <p><strong>Date of Birth:</strong> {{ $application->dob }}</p>
            <p><strong>Nationality:</strong> {{ $application->nationality }}</p>
            <p><strong>Identification Number:</strong> {{ $application->id_number }}</p>

            <h2>Course Details</h2>
            <p><strong>Course:</strong> {{ $application->course }}</p>
            <p><strong>Institution:</strong> {{ $application->institution }}</p>
            <p><strong>Duration:</strong> {{ $application->duration }}</p>

            <h2>Documents</h2>
            <p><strong>Application Letter:</strong><a href="{{ route('image.show', ['filename' => basename($application->app_letter)]) }}" target="_blank">
                View Document
            </a>

        <p><strong>Passport Photo:</strong> <a href="{{ route('image.show', ['filename' => basename($application->passport_photo)]) }}" target="_blank">View Photo</a></p>
        <p><strong>Birth Certificate:</strong> <a href="{{ route('image.show', ['filename' => basename($application->birth_certificate)]) }}" target="_blank">View Document</a></p>

            <h2>Other Information</h2>
            <p><strong>Status:</strong> {{ $application->status }}</p>
            <p><strong>Reference Number:</strong> {{ $application->reference_number }}</p>
        </div>
            <script>
                function updateStatus(status, id) {
                    console.log("Updating status to " + status + " for student permit with ID " + id); // Debugging line
                    fetch(`/student-permits/${id}/update-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ status: status })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); // Log the response data to the console
                        alert("Status updated to " + status);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            </script>
            
        <button class="btn btn-success" onclick="updateStatus('approved', {{ $application->id }})">Accept</button>
        <button class="btn btn-danger" onclick="showRejectionForm()">Reject</button>
        <button class="btn btn-warning" onclick="updateStatus('correction', {{ $application->id }})">Request Missing Documents</button>

            <!-- Add the rejection form section -->
            <div id="rejection-reason-section" style="display: none; margin-top: 20px;">
                <label for="rejection-reason"><strong>Select Rejection Reason:</strong></label>
                <select id="rejection-reason">
                    <option value="">-- Select Reason --</option>
                    <option value="Incomplete Documents">Incomplete Documents</option>
                    <option value="Fake Admission Letter">Fake Admission Letter</option>
                    <option value="Mismatch in Personal Details">Mismatch in Personal Details</option>
                    <option value="Overstayed Previous Permit">Overstayed Previous Permit</option>
                    <option value="Forged Documents">Forged Documents</option>
                    <option value="Other">Other</option>
                </select>
                <br><br>
                <textarea id="other-reason" placeholder="Enter other reason..." style="display: none; width: 100%; height: 60px;"></textarea>
                <br>
                <button class="btn btn-danger" onclick="submitRejection({{ $application->id }})">Submit Rejection</button>
            </div>

            <!-- Add the necessary JavaScript -->
            <script>
                function showRejectionForm() {
                    document.getElementById('rejection-reason-section').style.display = 'block';
                }

                document.getElementById('rejection-reason')?.addEventListener('change', function () {
                    const otherTextarea = document.getElementById('other-reason');
                    otherTextarea.style.display = this.value === 'Other' ? 'block' : 'none';
                });

                function submitRejection(applicationId) {
                    const selectedReason = document.getElementById('rejection-reason').value;
                    const otherReason = document.getElementById('other-reason').value;

                    if (!selectedReason) {
                        alert('Please select a reason for rejection.');
                        return;
                    }

                    let reason = selectedReason === 'Other' ? otherReason : selectedReason;

                    if (!reason.trim()) {
                        alert('Please provide a rejection reason.');
                        return;
                    }

                    fetch(`/student-permits/${applicationId}/update-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status: 'rejected',
                            rejection_reason: reason
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert('Application rejected with reason: ' + reason);
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            </script>

            <!-- You can also add actions like "Approve", "Reject", or "Edit" here -->
            <a href="{{ route('applications.index') }}">Back to Applications List</a>
    </main>
</body>
</html>
