<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoreOrder;
use App\Models\User;

class OrderController extends Controller
{
    public function index()
    {
        $orders = StoreOrder::where('user_id', auth()->id())
            ->with(['store', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(StoreOrder $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['store', 'items.product']);
        return view('orders.show', compact('order'));
    }

    public function markAsReceived(StoreOrder $order)
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }

        if ($order->status !== StoreOrder::STATUS_SHIPPED) {
            return response()->json(['success' => false, 'message' => 'Order must be shipped first']);
        }

        $order->markAsCompleted();

        return response()->json([
            'success' => true,
            'message' => 'Order marked as received. Payment has been released to the seller.'
        ]);
    }

    // Store owner methods
    public function storeOrders()
    {
        $user = auth()->user();
        if (!$user->store) {
            abort(404, 'Store not found');
        }

        $orders = StoreOrder::where('store_id', $user->store->id)
            ->with(['customer', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('stores.orders.index', compact('orders'));
    }

    public function storeOrderShow(StoreOrder $order)
    {
        $user = auth()->user();
        if (!$user->store || $order->store_id !== $user->store->id) {
            abort(403);
        }

        $order->load(['customer', 'items.product']);
        return view('stores.orders.show', compact('order'));
    }

    public function markAsShipped(Request $request, StoreOrder $order)
    {
        $user = auth()->user();
        if (!$user->store || $order->store_id !== $user->store->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }

        if ($order->status !== StoreOrder::STATUS_CONFIRMED && $order->status !== StoreOrder::STATUS_PROCESSING) {
            return response()->json(['success' => false, 'message' => 'Invalid order status']);
        }

        $order->markAsShipped();

        return response()->json([
            'success' => true,
            'message' => 'Order marked as shipped'
        ]);
    }

    public function updateStatus(Request $request, StoreOrder $order)
    {
        $user = auth()->user();
        if (!$user->store || $order->store_id !== $user->store->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }

        $validated = $request->validate([
            'status' => 'required|in:processing,shipped'
        ]);

        $order->update(['status' => $validated['status']]);

        if ($validated['status'] === StoreOrder::STATUS_SHIPPED) {
            $order->update(['shipped_at' => now()]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order status updated'
        ]);
    }
}