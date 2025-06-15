<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
</head>
<body>
    <h1>Payment Receipt</h1>
    <p>Permit Reference: {{ $receipt->payment_reference }}</p>
    <p>Amount Paid: {{ $receipt->amount }} {{ $receipt->currency }}</p>
    <p>Date: {{ $receipt->payment_date->toDayDateTimeString() }}</p>
    <p>Issued To: {{ $receipt->user->name }}</p>
</body>
</html>
