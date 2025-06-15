<!-- resources/views/dashboard/appointment_details.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Details</title>
    <link rel="stylesheet" href="{{ url('CSS/dashboard.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <h2>Dashboard</h2>
            <ul>
                <li><a href="{{ url('/applicantdashboard') }}">Home</a></li>
                <li><form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="logout-btn">Logout</button></form></li>
            </ul>
        </aside>

        <div class="container">
            <div class="header">
                <h1 style="color: white;">Appointment Details</h1>

            </div>
            
            <div class="content">
                <div class="cards">
                    <div class="card">
                        <div class="box">
                    <h3>Appointment Date: {{ $slotDate }}</h3>
                    <p>Time: {{ $slotTime}}</p>
                    <p>Status: {{ $appointment->status }}</p>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
</body>
</html>
