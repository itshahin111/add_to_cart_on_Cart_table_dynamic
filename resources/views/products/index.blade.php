<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #product-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
            margin-top: 20px;
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            max-width: 300px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .product-image {
            max-height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-title {
            font-size: 1.5rem;
            margin: 15px 0;
            color: #333;
        }

        .product-price {
            font-size: 1.25rem;
            margin: 10px 0;
            color: #28a745;
        }

        .product-desc {
            font-size: 1rem;
            color: #555;
            margin-bottom: 15px;
        }

        .add-to-cart-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .add-to-cart-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="text-center my-5">Products</h1>
        <div id="product-list">
            @foreach ($products as $product)
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}"
                        class="product-image img-fluid">
                    <h2 class="product-title">{{ $product->title }}</h2>
                    <p class="product-desc">{{ $product->short_des }}</p>
                    <p class="product-price">${{ $product->price }}</p>
                    <button class="add-to-cart-btn" onclick="addToCart({{ $product->id }})">Add to Cart</button>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function addToCart(productId) {
            fetch(`/cart/add/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token for security
                    }
                })
                .then(response => response.json())
                .then(data => alert(data.message))
                .catch(error => console.error('Error:', error));
        }
    </script>

</body>

</html>
