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
        body {
            background-color: #f8f9fa;
        }

        .cart-header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .cart-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .cart-item img {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-actions {
            display: flex;
            gap: 5px;
        }

        .btn-action {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.875rem;
        }

        .btn-action:hover {
            background-color: #0056b3;
        }

        .total-price {
            font-size: 1.25rem;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
        <div class="d-flex w-100 px-3">

            <a href="{{ url('/products') }}" class="btn btn-info">Show All Products
            </a>
        </div>
        </div>
    </nav>
    <div class="container my-5">
        <div class="text-center mb-4">
            <div class="cart-header">
                <h1>Your Cart</h1>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div id="cart-list">
                    @include('carts.cart-items', ['carts' => $carts])
                </div>
                <p class="text-end total-price mt-4">Total Price: $<span id="total-price">{{ $totalPrice }}</span></p>
            </div>
        </div>
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
