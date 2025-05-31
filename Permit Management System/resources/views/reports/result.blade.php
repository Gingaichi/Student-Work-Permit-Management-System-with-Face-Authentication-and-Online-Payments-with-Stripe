@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('CSS/report.css') }}">
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
@endsection

@section('content')
<div class="nav-bar">
    <a href="{{ url('/officerdashboard') }}">
        <i class="fas fa-home"></i> Home
    </a>
</div>

<div class="container">
    <h2 class="page-title">Student Permit Report Results</h2>

    <div class="stats-card">
        <h3>Total Applications Found: {{ $total }}</h3>
    </div>

    @if($results->isEmpty())
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            No results found for the selected filters.
        </div>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Institution</th>
                        <th>Course</th>
                        <th>Status</th>
                        <th>Nationality</th>
                        <th>Date Applied</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $index => $application)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $application->name ?? 'N/A' }}</td>
                            <td>{{ $application->institution ?? 'N/A' }}</td>
                            <td>{{ $application->course ?? 'N/A' }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($application->status ?? 'pending') }}">
                                    {{ ucfirst($application->status ?? 'Pending') }}
                                </span>
                            </td>
                            <td>{{ $application->nationality ?? 'N/A' }}</td>
                            <td>{{ $application->created_at ? \Carbon\Carbon::parse($application->created_at)->format('Y-m-d') : 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="action-buttons">
        <a href="{{ url('/reports') }}" class="btn-generate">
            <i class="fas fa-arrow-left"></i> Back to Filter
        </a>
    </div>
</div>
@endsection
