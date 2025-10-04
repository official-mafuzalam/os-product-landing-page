<x-app-layout>
    <x-slot name="main">
    <div class="container py-5">
        <div class="row">
            <!-- Product Info / Summary -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h3 class="card-title">{{ $product->name }}</h3>
                        <p class="card-text">{{ $product->short_description }}</p>
                        <h4 class="text-primary">৳ {{ number_format($product->price, 2) }}</h4>
                    </div>
                </div>
            </div>

            <!-- Checkout / Order Form -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Checkout</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('orders.place') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                    value="{{ old('name') }}">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required
                                    value="{{ old('email') }}">
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" required
                                    value="{{ old('phone') }}">
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                            </div>

                            {{-- maybe quantity, variants, etc --}}
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1"
                                    value="{{ old('quantity', 1) }}">
                            </div>

                            <button type="submit" class="btn btn-success w-100">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    </x-slot>
</x-app-layout>
