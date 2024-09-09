<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        #message-container {
            text-align: center;
            display: flex;
            justify-content: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically within the container */
            top: 5px;
            /* Distance from the top of the screen */
            left: 50%;
            transform: translateX(-50%);
            /* Center horizontally */
            z-index: 1050;
            /* Ensure it appears above other content */
            position: fixed;
            /* Fix the position relative to the viewport */
            width: 100%;
            /* Ensure it takes full width */
        }

        .product-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            width: 300px;
            height: 500px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .product-image {
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-title {
            font-size: 1.8rem;
            margin: 10px 0;
            color: #333;
            flex-grow: 1;
        }

        .product-price {
            font-size: 1rem;
            margin: 2px 0;
            color: #28a745;
        }

        .product-desc {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 10px;
            flex-grow: 1;
            overflow: hidden;
        }

        .add-to-cart-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-top: auto;
        }

        .add-to-cart-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>


<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
        <div class="d-flex justify-content-between w-100 px-3">
            <a class="navbar-brand" href="#">Home</a>
            <div class="dropdown">
                <a href="{{ url('/cart') }}" class="btn btn-info">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge bg-danger">0</span>
                </a>
            </div>
        </div>
    </nav>
    {{-- Cart Added Message Herre --}}
    <!-- Add this to your HTML body -->
    <div id="message-container" class="position-fixed p-3" style="display: none;">
        <div id="message" class="alert alert-success" role="alert"></div>
    </div>

    </div>

    <div class="row product-list">
        @foreach ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}"
                        class="product-image img-fluid">
                    <h2 class="product-title">{{ $product->title }}</h2>
                    <p class="product-desc">{{ $product->short_des }}</p>
                    <p class="product-price">${{ $product->price }}</p>
                    <button class="add-to-cart-btn" onclick="addToCart({{ $product->id }})">Add to Cart</button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Bootstrap JS -->
    <script>
        function addToCart(productId) {
            fetch(`/cart/add/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    // Show a message for 0.80 seconds
                    const messageContainer = document.getElementById('message-container');
                    const messageElement = document.getElementById('message');

                    messageElement.textContent = data.message; // Set the message text
                    messageContainer.style.display = 'block'; // Show the message

                    // Hide the message after 0.80 seconds
                    setTimeout(() => {
                        messageContainer.style.display = 'none';
                    }, 1000); // 1000 milliseconds = 1 seconds
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
