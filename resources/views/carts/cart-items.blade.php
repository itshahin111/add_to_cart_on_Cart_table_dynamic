@foreach ($carts as $cart)
    <div class="cart-item">
        <img src="{{ asset('storage/' . $cart->product->image) }}" alt="{{ $cart->product->title }}">
        <div class="cart-details">
            <h2 class="cart-title">{{ $cart->product->title }}</h2>
            <p>Quantity: {{ $cart->quantity }}</p>
            <p class="cart-price">Price: ${{ $cart->product->price * $cart->quantity }}</p>
            <div class="quantity-controls">
                <button class="quantity-btn" onclick="incrementQuantity({{ $cart->id }})">+</button>
                <button class="quantity-btn" onclick="decrementQuantity({{ $cart->id }})">-</button>
                <button class="remove-btn" onclick="removeFromCart({{ $cart->id }})">Remove</button>
            </div>
        </div>
    </div>
@endforeach
