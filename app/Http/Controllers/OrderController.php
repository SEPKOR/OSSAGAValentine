<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'isAnonymous' => 'nullable|boolean',
            'senderName' => 'nullable|string|max:255',
            'senderInitial' => 'nullable|string|max:10',
            'senderContact' => 'required|string|max:255',
            'recipientName' => 'required|string|max:255',
            'recipientClass' => 'required|string|max:255',
            'recipientContact' => 'nullable|string|max:255',
            'bundle' => 'required|string',
            'messageContent' => 'nullable|string',
            'paymentMethod' => 'required|string',
            'paymentProof' => 'nullable|image|max:2048', // Max 2MB
        ]);

        // Calculate Price (Simplified from frontend logic)
        $prices = [
            'cloud9' => 35000,
            'floral' => 30000,
            'petals' => 15000,
            'sugar'  => 10000,
        ];
        $totalPrice = $prices[$request->bundle] ?? 0;

        // Handle File Upload
        $proofPath = null;
        if ($request->hasFile('paymentProof')) {
            $proofPath = $request->file('paymentProof')->store('payment_proofs', 'public');
        }

        Order::create([
            'is_anonymous' => $request->boolean('isAnonymous'),
            'sender_name' => $request->senderName,
            'sender_initial' => $request->senderInitial,
            'sender_contact' => $request->senderContact,
            'recipient_name' => $request->recipientName,
            'recipient_class' => $request->recipientClass,
            'recipient_contact' => $request->recipientContact,
            'bundle_type' => $request->bundle,
            'message_content' => $request->messageContent,
            'total_price' => $totalPrice,
            'payment_method' => $request->paymentMethod,
            'payment_proof_path' => $proofPath,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Order submitted successfully!'], 201);
    }

    /**
     * Display a listing of orders (Admin).
     */
    public function index()
    {
        $orders = Order::latest()->get();
        return view('admin.index', compact('orders'));
    }

    /**
     * Display the specified order details.
     */
    public function show(Order $order)
    {
        return view('admin.show', compact('order'));
    }

    /**
     * Mark the specified order as completed.
     */
    public function complete(Order $order)
    {
        $order->update(['status' => 'completed']);
        return redirect()->route('admin.orders')->with('success', 'Order marked as completed!');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order)
    {
        // Delete payment proof if exists
        if ($order->payment_proof_path) {
            Storage::disk('public')->delete($order->payment_proof_path);
        }

        $order->delete();
        return redirect()->route('admin.orders')->with('success', 'Order deleted successfully!');
    }
}
