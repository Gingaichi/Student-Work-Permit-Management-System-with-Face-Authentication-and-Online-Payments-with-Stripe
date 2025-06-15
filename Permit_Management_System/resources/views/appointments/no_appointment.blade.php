<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No Appointment Scheduled</title>
    <link rel="stylesheet" href="{{ url('CSS/dashboard.css') }}">
    <style>
        .message-container {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin: 20px;
        }

        .message-text {
            font-size: 1.2em;
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #0056b3;
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

        <div class="container">
            <div class="header">
                <h1 style="color: white;">Appointment Status</h1>
            </div>
            
            <div class="content">
                <div class="message-container">
                    <div class="message-text">
                        <p>You have not been scheduled for an appointment yet.</p>
                        <p>An appointment will be scheduled after your permit has been processed.</p>
                    </div>
                    <a href="{{ url('/applicantdashboard') }}" class="back-button">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>