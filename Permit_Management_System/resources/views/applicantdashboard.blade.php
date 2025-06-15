<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Dashboard</title>
    <link rel="stylesheet" href="{{ url('CSS/applicantdashboard.css') }}">
</head>
<body>
    
    <div class="dashboard-container">
        <aside class="sidebar">
            <h1 style="color:white;">Welcome,<br> {{ auth()->user()->name }}</h1>
            <ul>
                <li><a href="{{ url('/applicantdashboard') }}">Home</a></li>
                @if($latestReceipt)
                    <li><a href="{{ route('user.receipts.download', $latestReceipt->id) }}">Download proof of payment</a></li>
                @else
                    <li><span style="color: grey;">No proof of payment yet</span></li>
                @endif

                <!-- Logout link -->
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </li>
            </ul>
        </aside>
        
        <!-- Modal for displaying notifications -->
        <div id="notificationModal" style="display:none;">
            <ul>
                @foreach($notifications as $notification)
                    <li>
                        <strong>{{ $notification->title }}</strong><br>
                        {{ $notification->message }}<br>
                        <small>{{ $notification->created_at->diffForHumans() }}</small>
                    </li>
                @endforeach
            </ul>
        </div>
        
        <div class="container">
            <div class="header">
                <div class="nav">
                    <div class="search">
                        <input type="text" placeholder="Search..">
                        <button type ="submit"><img src="/assets/images/searchimg.jpg" alt="Search" width="20" height="20"></button>
                    </div>
                    <div class="user">
                        
                        <a href="#" id="notificationBtn">
                            <span id="notificationCount" class="notification-badge">{{ count($notifications) }}</span>
                            <img src="/assets/images/not.png" alt="">
                        </a>
                        
                        <div class="img-case">
                        <img src="/assets/images/icon.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="cards">
                    <!-- Application Status Card -->
                    <div class="card">
                        <div class="box">
                            <h2>Application Status</h2>
                            <div class="status-info">
                                <p>Your latest application status:</p>
                                <h3>Status: 
                                    <span class="{{ strtolower($studentApplication ? $studentApplication->status : $workApplication->status) }}">
                                        {{ $studentApplication ? $studentApplication->status : ($workApplication ? $workApplication->status : 'No application found') }}
                                    </span>
                                </h3>
                                <p>Submitted on: 
                                    {{ 
                                        $studentApplication 
                                            ? $studentApplication->created_at->format('Y-m-d') 
                                            : ($workApplication 
                                                ? $workApplication->created_at->format('Y-m-d') 
                                                : 'Not available') 
                                    }}
                                </p>
                            </div>
                        </div>
                        <div class="icon-case">
                            <img src="/assets/images/personal-mail-svgrepo-com.png" alt="">
                        </div>
                    </div>

                    <!-- Appointment Card -->
                    <div class="card">
                        <div class="box">
                            <h2>Appointment Details</h2>
                            <div class="appointment-info">
                                <h3>View your appointment details</h3>
                                <a href="{{ route('appointments.show') }}" class="btn">View Details</a>
                            </div>
                        </div>
                        <div class="icon-case">
                            <img src="/assets/images/certificate-variant-with-image-svgrepo-com.png" alt="">
                        </div>
                    </div>

                    <!-- Edit Application Card -->
                    <div class="card">
                        <div class="box">
                            <h2>Edit Application</h2>
                            <div class="edit-info">
                                @if($applicationType == 'student')
                                    <a href="{{ route('application.edit', $application->id) }}" class="btn">Edit Student Permit Application</a>
                                @elseif($applicationType == 'work')
                                    <a href="{{ route('workpermit.edit', $workApplication->id) }}" class="btn">Edit Work Permit Application</a>
                                @endif
                            </div>
                        </div>
                        <div class="icon-case">
                            <img src="/assets/images/person-svgrepo-com.png" alt="">
                        </div>
                    </div>
                </div>

                <!-- Remove unused content-2 section -->
            </div>
        </div>

    </div>

    <script>
        // Handle the notifications button click to toggle the modal
        document.getElementById('notificationBtn').addEventListener('click', function() {
            var modal = document.getElementById('notificationModal');
            modal.style.display = modal.style.display === 'none' ? 'block' : 'none';
        });
    </script>
</body>
</html>
