<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Permit Applications</title>
    <link rel="stylesheet" href="{{ url('CSS/apptable.css') }}">
</head>
<body>
    <main class="table"> 

        <section class="table__header">
    <h1>Work Permit Applications</h1>

    <!-- Filtering Form -->
    <form method="GET" action="{{ route('workpermits.index') }}">
        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="">All</option>
            <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
        </select>

        <label for="job_title">Job Title:</label>
        <input type="text" name="job_title" value="{{ request('job_title') }}" />

        <label for="employer">Employer:</label>
        <input type="text" name="employer" value="{{ request('employer') }}" />

        <button type="submit">Filter</button>
    </form>

    <h2>Work Permit Applications List</h2>
</section>
<section class="table__body">
    @if($workpermitapplications->isEmpty())
        <p>No applications found.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Job Title</th>
                    <th>Employer</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($workpermitapplications as $application)
                    <tr>
                        <td>{{ $application->name }}</td>
                        <td>{{ $application->email }}</td>
                        <td>{{ $application->job_title }}</td>
                        <td>{{ $application->employer }}</td>
                        <td>{{ $application->status }}</td>
                        <td>
                            <a href="{{ route('workpermit.show', $application->id) }}">View Full Application</a>
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
