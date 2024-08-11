<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Paid</title>
</head>
<body>
    <h1>Thank you for your payment!</h1>
    <p>Your order with ID #{{ $order['id'] }} has been successfully paid.</p>
    <p>Order Total: {{ $order['attributes']['total_formatted'] }}</p>
    <p>We appreciate your business!</p>
</body>
</html>
