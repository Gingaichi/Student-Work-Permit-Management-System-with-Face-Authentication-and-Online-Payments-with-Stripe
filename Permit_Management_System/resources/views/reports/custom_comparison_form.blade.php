@extends('layouts.app')

@section('content')
    <h1>{{ $parameter1 ?? 'Parameter A' }} vs {{ $parameter2 ?? 'Parameter B' }} Comparison</h1>

    <form method="POST" action="{{ route('reports.compareCustom') }}">
        @csrf
        <label for="parameter1">Select Parameter A:</label>
        <select name="parameter1" id="parameter1">
            <option value="institution">Institution</option>
            <option value="course">Course</option>
            <option value="nationality">Nationality</option>
            <option value="status">Status</option>
        </select>

        <label for="parameter2">Select Parameter B:</label>
        <select name="parameter2" id="parameter2">
            <option value="institution">Institution</option>
            <option value="course">Course</option>
            <option value="nationality">Nationality</option>
            <option value="status">Status</option>
        </select>

        <button type="submit">Compare</button>
    </form>

    @if ($chart)
        <div id="chart-container">
            {!! $chart->container() !!}
        </div>

        @push('scripts')
            {!! $chart->script() !!}
        @endpush
    @endif
@endsection
