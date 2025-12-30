<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // =====================
        // STATISTIK DASHBOARD
        // =====================
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_users' => User::count(),
        ];

        // =====================
        // PENGHASILAN
        // =====================
        $incomeWeek = Order::where('paid', true)
            ->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek(),
            ])
            ->sum('total_amount');

        $incomeMonth = Order::where('paid', true)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        $incomeYear = Order::where('paid', true)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        // =====================
        // ORDER TERBARU (CARD)
        // =====================
        $recentOrders = Order::with('orderItems.product', 'user')
            ->latest()
            ->take(5)
            ->get();

        // =====================
        // RIWAYAT ORDER MINGGU INI
        // =====================
        $weeklyOrders = Order::with('user')
            ->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek(),
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.modern-dashboard', compact(
            'stats',
            'recentOrders',
            'incomeWeek',
            'incomeMonth',
            'incomeYear',
            'weeklyOrders'
        ));
    }

    /**
     * Display a listing of products.
     */
    public function products()
    {
        $products = Product::orderBy('name')->paginate(15);
        return view('admin.products.modern-index', compact('products'));
    }

    /**
     * Display a listing of users.
     */
    public function users()
    {
        $users = User::orderBy('name')->paginate(15);
        return view('admin.users.modern-index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.modern-create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:customer,cashier,superadmin',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function editUser(User $user)
    {
        return view('admin.users.modern-edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:customer,cashier,superadmin',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    public function orders()
    {
        $orders = Order::with('orderItems.product', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.orders.modern-index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        $order->load('orderItems.product', 'user');
        return view('admin.orders.modern-show', compact('order'));
    }
}
