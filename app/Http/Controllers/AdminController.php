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

    /**
     * Display income breakdown by weeks in specified month.
     */
    public function incomeWeekly(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $weeklyData = [];
        $startOfMonth = Carbon::create($year, $month, 1)->startOfWeek();
        $endOfMonth = Carbon::create($year, $month)->endOfMonth()->endOfWeek();

        $currentWeek = $startOfMonth->copy();

        while ($currentWeek->lte($endOfMonth)) {
            $weekStart = $currentWeek->copy();
            $weekEnd = $currentWeek->copy()->endOfWeek();

            $income = Order::where('paid', true)
                ->whereBetween('created_at', [$weekStart, $weekEnd])
                ->sum('total_amount');

            $weeklyData[] = [
                'week' => 'Week ' . $weekStart->weekOfMonth,
                'start_date' => $weekStart->format('d M'),
                'end_date' => $weekEnd->format('d M'),
                'income' => $income,
                'formatted_income' => 'Rp ' . number_format($income, 0, ',', '.'),
            ];

            $currentWeek->addWeek();
        }

        $totalMonth = array_sum(array_column($weeklyData, 'income'));

        return view('admin.income.weekly', compact('weeklyData', 'totalMonth', 'month', 'year'));
    }

    /**
     * Display income breakdown by months in specified year.
     */
    public function incomeMonthly(Request $request)
    {
        $year = $request->get('year', now()->year);

        $monthlyData = [];
        for ($month = 1; $month <= 12; $month++) {
            $income = Order::where('paid', true)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->sum('total_amount');

            $monthlyData[] = [
                'month' => Carbon::create($year, $month)->format('F'),
                'month_number' => $month,
                'income' => $income,
                'formatted_income' => 'Rp ' . number_format($income, 0, ',', '.'),
            ];
        }

        $totalYear = array_sum(array_column($monthlyData, 'income'));

        return view('admin.income.monthly', compact('monthlyData', 'totalYear', 'year'));
    }

    /**
     * Display income breakdown by years.
     */
    public function incomeYearly()
    {
        $currentYear = now()->year;
        $startYear = $currentYear - 4; // Show last 5 years

        $yearlyData = [];
        for ($year = $startYear; $year <= $currentYear; $year++) {
            $income = Order::where('paid', true)
                ->whereYear('created_at', $year)
                ->sum('total_amount');

            $yearlyData[] = [
                'year' => $year,
                'income' => $income,
                'formatted_income' => 'Rp ' . number_format($income, 0, ',', '.'),
            ];
        }

        return view('admin.income.yearly', compact('yearlyData'));
    }
}
