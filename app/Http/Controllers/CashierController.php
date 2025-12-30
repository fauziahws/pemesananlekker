<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    /**
     * Display a listing of pending orders.
     */
    public function index()
    {
        $orders = Order::with('orderItems.product', 'user')
            ->whereIn('status', ['pending', 'processing'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('cashier.orders.modern-index', compact('orders'));
    }

    /**
     * Display all orders.
     */
    public function allOrders()
    {
        $orders = Order::with('orderItems.product', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('cashier.orders.modern-all', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load('orderItems.product', 'user');

        return view('cashier.orders.modern-show', compact('order'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Mark order as paid.
     */
    public function markAsPaid(Order $order)
    {
        $order->update(['paid' => true]);

        return back()->with('success', 'Pesanan ditandai sudah dibayar.');
    }

    /**
     * Mark order as unpaid.
     */
    public function markAsUnpaid(Order $order)
    {
        $order->update(['paid' => false]);

        return back()->with('success', 'Pesanan ditandai belum dibayar.');
    }

    /**
     * Display the receipt for the order.
     */
    public function receipt(Order $order)
    {
        $order->load('orderItems.product', 'user');

        return view('cashier.orders.receipt', compact('order'));
    }
}
