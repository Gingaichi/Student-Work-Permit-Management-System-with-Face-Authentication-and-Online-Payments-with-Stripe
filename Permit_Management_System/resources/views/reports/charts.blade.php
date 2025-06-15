@extends('layouts.app')

@section('content')
<div class="nav-bar">
    <a href="{{ url('/officerdashboard') }}">
        <i class="fas fa-home"></i> Home
    </a>
</div>

<div class="container">
    <h2 class="page-title">Statistical Reports</h2>

    <div class="charts-container">
        <!-- Monthly Applications Chart -->
        <div class="chart-card">
            <div class="chart-wrapper">
                {!! $monthlyChart->container() !!}
            </div>
        </div>

        <!-- Status Distribution Chart -->
        <div class="chart-card">
            <div class="chart-wrapper">
                {!! $statusChart->container() !!}
            </div>
        </div>

        <!-- Institution Comparison Chart -->
        <div class="chart-card">
            <div class="chart-wrapper">
                {!! $institutionChart->container() !!}
            </div>
        </div>
    </div>
</div>

<!-- Charts Scripts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
{!! $monthlyChart->script() !!}
{!! $statusChart->script() !!}
{!! $institutionChart->script() !!}
@endsection

@section('styles')
<style>
.charts-container {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    padding: 1rem;
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

@media (min-width: 1200px) {
    .charts-container {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
@endsection



