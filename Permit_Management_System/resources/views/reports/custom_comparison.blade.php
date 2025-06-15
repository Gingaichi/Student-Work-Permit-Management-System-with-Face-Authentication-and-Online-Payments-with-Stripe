@extends('layouts.app')

@section('content')
    <h1>{{ $parameter1 }} vs {{ $parameter2 }} Comparison</h1>

    <div id="chart-container">
        {!! $chart->container() !!}
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js"></script>
    {!! $chart->script() !!}
@endsection
