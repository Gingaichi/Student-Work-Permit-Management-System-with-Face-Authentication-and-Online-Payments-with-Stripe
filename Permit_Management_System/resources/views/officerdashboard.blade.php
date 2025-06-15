<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Immigration Officer Dashboard</title>
    <link rel="stylesheet" href="{{ url('CSS/dashboard.css') }}">
    <script>
        function toggleDropdown() {
            document.getElementById("applicationsDropdown").classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.dropdown-btn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #3a95b1;
            min-width: 200px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }
        .dropdown-content a {
            color: black;
            padding: 10px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {
            background-color: #ddd;
        }
        .show {
            display: block;
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
                <div class="nav">
                    <div class="search">
                        <input type="text" placeholder="Search..">
                        <button type ="submit"><img src="/assets/images/searchimg.jpg" alt="Search" width="20" height="20"></button>
                    </div>
                    <div class="user">
                        <a href="#" class="btnx">Add new</a>
                        <img src="/assets/images/not.png" alt="" >
                        <div class="img-case">
                        <img src="/assets/images/icon.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="cards">
                    <div class="card">
                        <div class="box">
                            <h1>{{ $totalStudentPermits }}</h1>
                            <h3>Student Permit Applications<h3>
                        </div>
                        <div class="icon-case">
                            <img src="/assets/images/person-svgrepo-com.png" alt="">
                        </div>
                    </div>
                    <div class="card">
                        <div class="box">
                            <h1>{{ $totalWorkPermits }}</h1>
                            <h3>Work Permit Applications<h3>
                        </div>
                        <div class="icon-case">
                            <img src="/assets/images/personal-mail-svgrepo-com.png" alt="">
                        </div>
                    </div>
                    <div class="card">
                        <div class="box">
                            <h1></h1>
                            <h3>Total pending applications<h3>
                        </div>
                        <div class="icon-case">
                            <img src="/assets/images/certificate-variant-with-image-svgrepo-com.png" alt="">
                        </div>
                    </div>
                    <div class="card">
                        <div class="box">
                            <h1></h1>
                            <h3>Total Approved Applications<h3>
                        </div>
                        <div class="icon-case">
                            <img src="/assets/images/person-svgrepo-com.png" alt="">
                        </div>
                    </div>
                </div>
                    <div class="content-2">
                        <div class="recent-applications">
                            <div class="title">
                                <h2>New Student Permit Applications</h2>
                                
                            </div>
                            <table>
                                <tr>
                                    <th>Name</th>
                                    <th>Institution</th>
                                    <th>Nationality</th>
                                    <th>Course</th>
                                </tr>
                                @foreach($recentPermits as $permit)
                                    <tr>
                                        <td>{{ $permit->user->name }}</td> <!-- Assuming a relationship exists -->
                                        <td>{{ $permit->institution }}</td>
                                        <td>{{ $permit->nationality }}</td>
                                        <td>{{ $permit->course }}</td>
                                        <td><a href="{{ route('applications.show', $permit->id) }}" class="btnx">View</a></td>
                                    </tr>
                                @endforeach
                            </table>
                            
                        </div>
                        <div class="new-applications">
                            <div class="title">
                                <h2>New Work Permit applications</h2>
                            </div>
                            <table>
                                <tr>
                                    <th>Name</th>
                                    <th>Employer</th>
                                </tr>
                                @foreach($recentworkPermits as $workpermit)
                                <tr>
                                    <td>{{ $workpermit->user->name }}</td> <!-- Assuming a relationship exists -->
                                    <td>{{ $workpermit->employer }}</td>
                                    <td><a href="{{ route('workpermit.show', $workpermit->id) }}" class="btnx">View</a></td>
                                </tr>
                            @endforeach
                            </table>
                        </div>
                    </div>
                
                    
            </div>
            
        </div>
        
        
        <!-- 
<main class="content">
    <h1>Welcome, Immigration Officer</h1>
    <p>Overview of recent applications:</p>
    
    <div class="status-card">
        <h3>New Applications: <span class="new">12</span></h3>
        <h3>Pending Reviews: <span class="pending">8</span></h3>
        <h3>Approved: <span class="approved">20</span></h3>
    </div>

    <div class="actions">
        <button class="btn">View Pending Applications</button>
        <button class="btn">Generate Reports</button>
    </div>
</main>
-->

    </div>
</body>
</html>
