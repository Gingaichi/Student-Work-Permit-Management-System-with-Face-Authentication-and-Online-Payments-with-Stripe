@extends('layouts.appy')

@section('content')
<div class="nav-bar">
    <a href="{{ url('/officerdashboard') }}">
        <i class="fas fa-home"></i> Home
    </a>
    <a href="{{ url('/reports') }}">
        <i class="fas fa-chart-bar"></i> Back to Reports
    </a>
</div>

<div class="container">
    <h2 class="page-title">{{ $title }}</h2>

    <div class="chart-container">
        <div class="chart-card">
            <div class="chart-wrapper">
                {!! $chart->container() !!}
            </div>
        </div>
    </div>
</div>

<!-- Charts Scripts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
{!! $chart->script() !!}
@endsection

@section('styles')
<style>
.chart-container {
    margin: 2rem 0;
}

.chart-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 1rem;
}

.chart-wrapper {
    min-height: 400px;
}
</style>
@endsection