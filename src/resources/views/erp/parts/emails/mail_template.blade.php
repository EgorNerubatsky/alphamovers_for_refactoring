<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Mail View</title>
</head>
<body>
<p>Привіт, {{ $data['recipient_name'] }}!</p><br>
<h2>{{ $data['message'] }}</h2>
<br>
<p>З найкращими побажаннями,</p><br>
<p>{{ $data['sender_name'] }}</p>
</body>
</html>
