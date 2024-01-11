<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h2>PRODUCT TEST</h2>
    <h2>Price: $20</h2>

    <form action="{{ route('paypal') }}" method="post">
        @csrf
        <input type="hidden" name="price" value="20" />
        <button type="submit">Pay with paypal</button>
    </form>
</body>
</html>