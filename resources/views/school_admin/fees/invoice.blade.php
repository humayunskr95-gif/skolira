<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
</head>
<body>

<h2>School Fee Invoice</h2>

<p><b>Student:</b> {{ $fee->student->name }}</p>
<p><b>Class:</b> {{ $fee->class->name }}</p>
<p><b>Date:</b> {{ $fee->date }}</p>

<hr>

<p><b>Total Amount:</b> ₹ {{ $fee->amount }}</p>
<p><b>Paid:</b> ₹ {{ $fee->paid_amount }}</p>
<p><b>Due:</b> ₹ {{ $fee->due }}</p>

<hr>

<p><b>Status:</b> {{ ucfirst($fee->status) }}</p>

</body>
</html>