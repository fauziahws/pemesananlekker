<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu.index')
                ->with('error', 'Keranjang kosong.');
        }

        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity'],
                ];
                $total += $product->price * $item['quantity'];
            }
        }

        return view('orders.modern-checkout', compact('cartItems', 'total'));
    }

    /**
     * Store a new order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'order_type' => 'required|in:dine_in,takeaway',
            'table_number' => 'required_if:order_type,dine_in|nullable|string|max:50',
            'payment_method' => 'required|in:cash,virtual_account',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu.index')
                ->with('error', 'Keranjang kosong.');
        }

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $orderItems = [];

            // Calculate total and prepare order items
            foreach ($cart as $id => $item) {
                $product = Product::find($id);
                if ($product && $product->is_available) {
                    $subtotal = $product->price * $item['quantity'];
                    $totalAmount += $subtotal;

                    $orderItems[] = [
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $product->price,
                        'total' => $subtotal,
                    ];
                }
            }

            // Generate virtual account number if payment method is virtual_account
            $virtualAccountNumber = null;
            if ($request->payment_method === 'virtual_account') {
                $virtualAccountNumber = $this->generateVirtualAccountNumber();
            }

            // Create order
            $order = Order::create([
                'order_code' => Order::generateOrderCode(),
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'order_type' => $request->order_type,
                'table_number' => $request->order_type === 'dine_in' ? $request->table_number : null,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'paid' => false,
                'payment_method' => $request->payment_method,
                'virtual_account_number' => $virtualAccountNumber,
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                $order->orderItems()->create($item);
            }

            DB::commit();

            // Clear cart
            session()->forget('cart');

            return redirect()->route('orders.receipt', $order)
                ->with('success', 'Pesanan berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the order receipt.
     */
    public function receipt(Order $order)
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Only allow viewing own orders unless admin/cashier
        if (!$user->isSuperAdmin() && !$user->isCashier()) {
            if ($order->user_id !== Auth::id()) {
                abort(403);
            }
        }

        $order->load('orderItems.product');

        return view('orders.modern-receipt', compact('order'));
    }

    /**
     * Display user's orders.
     */
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.modern-my-orders', compact('orders'));
    }

    /**
     * API endpoint to get products.
     */
    public function apiProducts()
    {
        $products = Product::where('is_available', true)->get();

        return response()->json([
            'success' => true,
            'data' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'image_url' => $product->image_url,
                    'is_available' => $product->is_available,
                ];
            }),
        ]);
    }

    /**
     * API endpoint to create order.
     */
    public function apiStore(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number' => 'required|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $orderItems = [];

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                if ($product && $product->is_available) {
                    $subtotal = $product->price * $item['quantity'];
                    $totalAmount += $subtotal;

                    $orderItems[] = [
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $product->price,
                        'total' => $subtotal,
                    ];
                }
            }

            $order = Order::create([
                'order_code' => Order::generateOrderCode(),
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'table_number' => $request->table_number,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'paid' => false,
            ]);

            foreach ($orderItems as $item) {
                $order->orderItems()->create($item);
            }

            DB::commit();

            $order->load('orderItems.product');

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat.',
                'data' => [
                    'order_code' => $order->order_code,
                    'total_amount' => $order->total_amount,
                    'status' => $order->status,
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Generate fake virtual account number for demo.
     */
    private function generateVirtualAccountNumber(): string
    {
        // Generate 16-digit virtual account number
        // Format: 8020 XXXX XXXX XXXX (8020 = Bank Code for demo)
        $randomDigits = str_pad(mt_rand(0, 999999999999), 12, '0', STR_PAD_LEFT);
        return '8020' . $randomDigits;
    }

    /**
     * Check payment status and mark as paid (for virtual account demo).
     */
    public function checkPaymentStatus(Order $order)
    {
        // For demo purposes, we just mark it as paid
        // In real app, this would check actual payment gateway API
        
        if ($order->payment_method === 'virtual_account' && !$order->paid) {
            $order->update(['paid' => true]);
            
            return redirect()->route('orders.receipt', $order)
                ->with('success', 'Pembayaran berhasil dikonfirmasi!');
        }

        return redirect()->route('orders.receipt', $order)
            ->with('info', 'Pesanan sudah dibayar atau metode pembayaran bukan virtual account.');
    }
}
