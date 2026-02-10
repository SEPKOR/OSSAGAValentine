<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #{{ $order->id }} - OSSAGA Valentine</title>
    <link rel="icon" href="{{ asset('img/logo.svg') }}" type="image/svg+xml">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Order Details #{{ $order->id }}</h1>
            <a href="{{ route('admin.orders') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-mono">
                ← Back to Dashboard
            </a>
        </div>

        <!-- Order Info Card -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
            <div class="bg-pink-500 text-white px-6 py-4">
                <h2 class="text-xl font-bold">Order Information</h2>
                <p class="text-sm opacity-90">Placed on {{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>

            <div class="p-6 space-y-6">
                <!-- Sender Information -->
                <div class="border-b pb-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">📤 Sender Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Name</label>
                            <p class="text-gray-900">
                                @if($order->is_anonymous)
                                    <span class="text-red-500 italic">Anonymous</span> ({{ $order->sender_initial }})
                                @else
                                    {{ $order->sender_name }}
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Contact</label>
                            <p class="text-gray-900">{{ $order->sender_contact }}</p>
                        </div>
                    </div>
                </div>

                <!-- Recipient Information -->
                <div class="border-b pb-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">📥 Recipient Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Name</label>
                            <p class="text-gray-900">{{ $order->recipient_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Class/Address</label>
                            <p class="text-gray-900">{{ $order->recipient_class }}</p>
                        </div>
                        @if($order->recipient_contact)
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-600">Contact (Optional)</label>
                            <p class="text-gray-900">{{ $order->recipient_contact }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Bundle Information -->
                <div class="border-b pb-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">🎁 Bundle Selection</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Bundle Type</label>
                            <p class="text-gray-900">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-pink-100 text-pink-800">
                                    {{ ucfirst($order->bundle_type) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Total Price</label>
                            <p class="text-gray-900 font-bold text-lg">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Message Content -->
                @if($order->message_content)
                <div class="border-b pb-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">💌 Message Content</h3>
                    <div class="bg-pink-50 border-l-4 border-pink-500 p-4 rounded">
                        <p class="text-gray-800 whitespace-pre-wrap">{{ $order->message_content }}</p>
                    </div>
                </div>
                @endif

                <!-- Payment Information -->
                <div class="border-b pb-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">💳 Payment Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Payment Method</label>
                            <p class="text-gray-900">{{ ucfirst($order->payment_method) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Status</label>
                            <p>
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    @if($order->payment_proof_path)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Payment Proof</label>
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <img src="{{ Storage::url($order->payment_proof_path) }}" 
                                 alt="Payment Proof" 
                                 class="max-w-full h-auto rounded shadow-lg"
                                 style="max-height: 500px;">
                        </div>
                    </div>
                    @else
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Payment Proof</label>
                        <p class="text-gray-400 italic">No proof uploaded</p>
                    </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex gap-3">
                    @if($order->status !== 'completed')
                    <form action="{{ route('admin.orders.complete', $order) }}" method="POST" class="flex-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-mono"
                                onclick="return confirm('Mark this order as completed?')">
                            ✓ Mark as Completed
                        </button>
                    </form>
                    @endif

                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-mono"
                                onclick="return confirm('Are you sure you want to delete this order?')">
                            🗑 Delete Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
