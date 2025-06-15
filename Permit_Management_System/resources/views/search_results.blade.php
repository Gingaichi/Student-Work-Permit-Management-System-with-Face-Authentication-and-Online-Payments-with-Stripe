@extends('layouts.app')

@section('content')
    <h1>Search Results</h1>

    <form method="GET" action="{{ url('/officerdashboard/search-applications') }}">
        <input type="text" name="institution_name" placeholder="Enter institution name" required>
        <button type="submit">Search</button>
    </form>

    @if($applications->isEmpty())
        <p>No applications found for this institution.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Application ID</th>
                    <th>Applicant Name</th>
                    <th>Institution</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $application)
                    <tr>
                        <td>{{ $application->id }}</td>
                        <td>{{ $application->applicant_name }}</td>
                        <td>{{ $application->institution->name }}</td>
                        <td>{{ $application->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
