@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Permit Application Successful</h1>
    <p>Your permit application was successfully submitted. Your permit reference number is: <strong>{{ $reference_number }}</strong></p>
    
    @if($latestReceipt)
        <p>Download your payment receipt: 
            <a href="{{ route('user.receipts.download', $latestReceipt->id) }}" class="btn btn-primary">
                Download Receipt
            </a>
        </p>
    @endif

    <a href="{{ url('/applicantdashboard') }}" class="btn btn-secondary">Proceed to your user Dashboard</a>
    <a href="{{ url('/landinga') }}" class="btn btn-secondary">Return home</a>
</div>

<style>
.container {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    text-align: center;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    margin: 10px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn:hover {
    opacity: 0.9;
}
</style>
@endsection
