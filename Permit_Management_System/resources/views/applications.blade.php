<!-- resources/views/applications/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Applications</title>
    <link rel="stylesheet" href="{{ url('CSS/apptable.css') }}">
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

    <main class="table">
        
    <section class="table__header">
    <h1>Student Applications</h1>

    <!-- Filtering Form -->
    <form method="GET" action="{{ route('applications.index') }}">
        <div class="filter-group">
            <div>
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="">All</option>
                    <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                </select>
            </div>

            <div>
                <label for="reference_number">Reference Number:</label>
                <input type="text" 
                       name="reference_number" 
                       id="reference_number" 
                       value="{{ request('reference_number') }}" 
                       placeholder="Search by reference number"/>
            </div>

            <div>
                <label for="id_number">Passport Number:</label>
                <input type="text" 
                       name="id_number" 
                       id="id_number" 
                       value="{{ request('id_number') }}" 
                       placeholder="Search by ID/passport number"/>
            </div>

            <div>
                <label for="firstname">First Name:</label>
                <input type="text" 
                       name="firstname" 
                       id="firstname" 
                       value="{{ request('firstname') }}" 
                       placeholder="Search by first name"/>
            </div>

            <div>
                <label for="surname">Surname:</label>
                <input type="text" 
                       name="surname" 
                       id="surname" 
                       value="{{ request('surname') }}" 
                       placeholder="Search by surname"/>
            </div>

            <div>
                <label for="institution">Institution:</label>
                <input type="text" 
                       name="institution" 
                       value="{{ request('institution') }}" 
                       placeholder="Search by institution"/>
            </div>

            <div>
                <label for="course">Course:</label>
                <input type="text" 
                       name="course" 
                       value="{{ request('course') }}" 
                       placeholder="Search by course"/>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       value="{{ request('email') }}" 
                       placeholder="Search by email"/>
            </div>

            <div class="button-group">
                <button type="submit">Filter</button>
                <button type="reset" onclick="window.location='{{ route('applications.index') }}'" class="reset-btn">Reset Filters</button>
            </div>
        </div>
    </form>
    
    <!--<h2>Applications List</h2> -->
        </section>
        <section class="table__body">
    @if($applications->isEmpty())
        <p>No applications found.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Institution</th>
                    <th>Course</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $application)
                    <tr>
                        <td>{{ $application->name }}</td>
                        <td>{{ $application->email }}</td>
                        <td>{{ $application->institution }}</td>
                        <td>{{ $application->course }}</td>
                        <td>{{ $application->status }}</td>
                        <td>
                            <a href="{{ route('applications.show', $application->id) }}">View Full Application</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</section>
</main>
</body>
</html>
