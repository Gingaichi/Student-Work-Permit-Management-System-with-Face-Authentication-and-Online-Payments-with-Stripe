<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Update Confirmation</title>
    <link rel="stylesheet" href="{{ url('CSS/dashboard.css') }}">
    <style>
        .confirmation-container {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin: 20px auto;
            max-width: 600px;
        }
        
        .confirmation-message {
            font-size: 1.2em;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 5px;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .rejected {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .correction {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
        
        .btn-return {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
        
        .btn-return:hover {
            background-color: #0056b3;
        }
        
        .countdown {
            font-size: 0.9em;
            margin-top: 10px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <h2>Officer Dashboard</h2>
            <ul>
                <li class="dropdown">
                    <a href="#" class="dropdown-btn" onclick="toggleDropdown()">View Applications &#9662;</a>
                    <div id="applicationsDropdown" class="dropdown-content">
                        <a href="{{ route('applications.index') }}">Student Permit Applications</a>
                        <a href="{{ route('workpermits.index') }}">Work Permit Applications</a>
                    </div>
                </li>
                <li><a href="{{ url('/officerdashboard') }}">Home</a></li>
                <li><a href="{{ url('/reports') }}">Reports</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </li>
            </ul>
        </aside>

        <div class="container">
            <div class="header">
                <h1 style="color: white;">Status Update Confirmation</h1>
            </div>
            
            <div class="content">
                <div class="confirmation-container">
                    @if(session('status') == 'approved')
                        <div class="confirmation-message success">
                            <h2>Application Approved</h2>
                            <p>The application has been successfully approved.</p>
                            <p>An appointment has been scheduled for the applicant.</p>
                        </div>
                    @elseif(session('status') == 'rejected')
                        <div class="confirmation-message rejected">
                            <h2>Application Rejected</h2>
                            <p>The application has been rejected.</p>
                            <p>Reason: {{ session('reason') }}</p>
                        </div>
                    @elseif(session('status') == 'correction')
                        <div class="confirmation-message correction">
                            <h2>Correction Requested</h2>
                            <p>A request for missing documents has been sent to the applicant.</p>
                        </div>
                    @else
                        <div class="confirmation-message">
                            <h2>Status Updated</h2>
                            <p>The application status has been updated successfully.</p>
                        </div>
                    @endif
                    
                    <a href="{{ url('/officerdashboard') }}" class="btn-return">Return to Dashboard</a>
                    
                    <div class="countdown">
                        Redirecting to dashboard in <span id="countdown">5</span> seconds...
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function toggleDropdown() {
            document.getElementById("applicationsDropdown").classList.toggle("show");
        }
        
        // Countdown and redirect
        let seconds = 5;
        const countdownElement = document.getElementById('countdown');
        
        const interval = setInterval(function() {
            seconds--;
            countdownElement.textContent = seconds;
            
            if (seconds <= 0) {
                clearInterval(interval);
                window.location.href = "{{ url('/officerdashboard') }}";
            }
        }, 1000);
    </script>
</body>
</html>