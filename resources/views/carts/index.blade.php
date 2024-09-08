<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Add your styles here */
    </style>
</head>

<body>

    <div class="container">
        <h1 class="text-center my-5">Your Cart</h1>
        <div id="cart-list">
            @include('carts.cart-items', ['carts' => $carts])
        </div>
        <p class="text-end fw-bold fs-4">Total Price: $<span id="total-price">{{ $totalPrice }}</span></p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateCart(response) {
            $('#cart-list').html(response.html);
            $('#total-price').text(response.totalPrice);
        }

        function incrementQuantity(cartId) {
            fetch(`/cart/increment/${cartId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                })
                .then(response => response.json())
                .then(updateCart)
                .catch(error => console.error('Error:', error));
        }

        function decrementQuantity(cartId) {
            fetch(`/cart/decrement/${cartId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                })
                .then(response => response.json())
                .then(updateCart)
                .catch(error => console.error('Error:', error));
        }

        function removeFromCart(cartId) {
            fetch(`/cart/remove/${cartId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                })
                .then(response => response.json())
                .then(updateCart)
                .catch(error => console.error('Error:', error));
        }
    </script>

</body>

</html>
