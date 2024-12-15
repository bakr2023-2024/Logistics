<!-- resources/views/emails/shipment/delivered.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shipment Has Been Delivered!</title>
</head>
<body>
    <h1>Dear {{ $customer->name }},</h1>

    <p>We are happy to inform you that your shipment with tracking number <strong>{{ $shipment->tracking_number }}</strong> has been successfully delivered to your address: <strong>{{ $customer->address }}</strong>.</p>

    <p>The cost of delivery was <strong>${{ $shipment->cost }}</strong>.</p>

    <p>Thank you for using our service! We hope to serve you again soon.</p>

    <p>To view more details about your shipment, click the link below:</p>
    <p><a href="{{ route('shipments.show', $shipment->id) }}">View Shipment Details</a></p>

    <p>Best regards,<br>
    The Shipment Team</p>
</body>
</html>
