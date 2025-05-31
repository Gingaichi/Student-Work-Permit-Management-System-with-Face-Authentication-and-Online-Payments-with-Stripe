@extends('layouts.appy')

@section('content')
<div class="nav-bar">
    <a href="{{ url('/officerdashboard') }}">
        <i class="fas fa-home"></i> Home
    </a>
</div>


    <!-- Report Type Selector -->
    <div id="reportTypeSelector" class="report-type-selector">
        <h2 class="page-title">Select Report Type</h2>
        <div class="report-options">
            <button class="report-card" onclick="showStandardReports()">
                <i class="fas fa-file-alt"></i>
                <h3>Standard Reports</h3>
                <p>Generate filtered reports based on year, institution, course, and nationality</p>
            </button>
            <button class="report-card" onclick="showComparisonOptions()">
                <i class="fas fa-chart-bar"></i>
                <h3>Comparison Reports</h3>
                <p>Compare different metrics and analyze trends</p>
            </button>
        </div>
    </div>

    <!-- Standard Reports Form -->
    <div id="standardReportsForm" class="form-container" style="display: none;">
        <button onclick="goBackToSelector()" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Report Type Selection
        </button>

        <div class="form-header">
            <i class="fas fa-file-alt"></i>
            <h2>Generate Standard Report</h2>
        </div>

        <form action="{{ route('reports.generate') }}" method="GET">
            <div class="form-group">
                <label for="year">
                    <i class="far fa-calendar-alt"></i> Year
                </label>
                <input type="number" name="year" id="year" class="form-control"
                       placeholder="Enter year (e.g. 2024)" value="{{ request('year') }}">
            </div>

            <div class="form-group">
                <label for="institution">
                    <i class="fas fa-university"></i> Institution
                </label>
                <input type="text" name="institution" id="institution" class="form-control"
                       placeholder="Enter institution name" value="{{ request('institution') }}">
            </div>

            <div class="form-group">
                <label for="course">
                    <i class="fas fa-graduation-cap"></i> Course
                </label>
                <input type="text" name="course" id="course" class="form-control"
                       placeholder="Enter course name" value="{{ request('course') }}">
            </div>

            <div class="form-group">
                <label for="nationality">
                    <i class="fas fa-globe"></i> Nationality
                </label>
                <input type="text" name="nationality" id="nationality" class="form-control"
                       placeholder="Enter nationality" value="{{ request('nationality') }}">
            </div>

            <div class="btn-container">
                <button type="submit" class="btn-generate">
                    <i class="fas fa-file-export"></i> Generate Report
                </button>
            </div>
        </form>
    </div>

    <!-- Comparison Reports Options -->
    <div id="comparisonOptions" class="comparison-container" style="display: none;">
        <button onclick="goBackToSelector()" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Report Type Selection
        </button>

        <div class="form-header">
            <i class="fas fa-chart-bar"></i>
            <h2>Select Comparison Type</h2>
        </div>

        <div class="comparison-grid">
            <a href="{{ route('reports.compare', ['type' => 'universities']) }}" class="comparison-card">
                <i class="fas fa-university"></i>
                <h3>Universities Comparison</h3>
                <p>Compare applications from different universities</p>
            </a>

            <a href="{{ route('reports.compare', ['type' => 'permit_status']) }}" class="comparison-card">
                <i class="fas fa-check-circle"></i>
                <h3>Permit Status Analysis</h3>
                <p>Compare accepted vs rejected permits</p>
            </a>

            <a href="{{ route('reports.compare', ['type' => 'permit_types']) }}" class="comparison-card">
                <i class="fas fa-id-card"></i>
                <h3>Permit Types</h3>
                <p>Compare student vs work permits</p>
            </a>

            <a href="{{ route('reports.compare', ['type' => 'nationalities']) }}" class="comparison-card">
                <i class="fas fa-globe"></i>
                <h3>Top Nationalities</h3>
                <p>View top 5 nationalities of applicants</p>
            </a>

            <a href="{{ route('reports.compare', ['type' => 'rejection_reasons']) }}" class="comparison-card">
                <i class="fas fa-times-circle"></i>
                <h3>Rejection Reasons</h3>
                <p>Analyze common rejection reasons</p>
            </a>

        <!-- Custom Comparison Reports -->
        <a href="{{ route('reports.customComparisonForm') }}" class="comparison-card">
            <i class="fas fa-sliders-h"></i>
            <h3>Custom Comparison</h3>
            <p>Generate your own custom comparison report</p>
        </a>
    </div>
</div>

        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.report-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin: 2rem 0;
    
}

.report-card {
    background: white;
    color: black;
    border-radius: 10px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
    cursor: pointer;
    border: none;
    width: 100%;
    display: block;
}

.report-card:hover {
    transform: translateY(-5px);
}

.comparison-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}




.comparison-card {
    background: white;
    border-radius: 10px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
    text-decoration: none;
    color: inherit;
    display: block;
}

.comparison-card:hover {
    transform: translateY(-5px);
}

.comparison-card i {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: #4a90e2;
}

.form-container {
    background: white;
    border-radius: 10px;
    padding: 2rem;
    margin-top: 2rem;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-control {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.btn-generate, .btn-back {
    background: #4a90e2;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.2s;
    margin-bottom: 1rem;
}

.btn-generate:hover, .btn-back:hover {
    background: #357abd;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const standardForm = document.getElementById('standardReportsForm');
    const comparisonOptions = document.getElementById('comparisonOptions');
    const reportTypeSelector = document.getElementById('reportTypeSelector');

    window.showStandardReports = function() {
        reportTypeSelector.style.display = 'none';
        standardForm.style.display = 'block';
        comparisonOptions.style.display = 'none';
    };

    window.showComparisonOptions = function() {
        reportTypeSelector.style.display = 'none';
        standardForm.style.display = 'none';
        comparisonOptions.style.display = 'block';
    };

    window.goBackToSelector = function() {
        reportTypeSelector.style.display = 'block';
        standardForm.style.display = 'none';
        comparisonOptions.style.display = 'none';
    };
});
</script>
@endsection
