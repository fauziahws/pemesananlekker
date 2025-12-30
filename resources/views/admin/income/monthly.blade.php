<x-modern-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent mb-2">
                    Monthly Income Breakdown
                </h1>
                <p class="text-gray-600">{{ $year }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Year Selector -->
                <form method="GET" class="flex items-center space-x-2">
                    <select name="year" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        @for($y = now()->year; $y >= now()->year - 4; $y--)
                            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="px-4 py-2 bg-[#7B542F] text-white rounded-lg text-sm hover:bg-[#5D3F22] transition">
                        View
                    </button>
                </form>
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-white text-gray-700 rounded-xl font-medium hover:bg-gray-50 border border-gray-200 transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Summary Card -->
        <div class="bg-gradient-to-r from-[#7B542F] to-[#A0724B] rounded-2xl p-6 text-white mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold mb-2">Total Yearly Income</h3>
                    <p class="text-3xl font-bold">Rp {{ number_format($totalYear, 0, ',', '.') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm opacity-90">Year: {{ $year }}</p>
                    <p class="text-sm opacity-90">12 months</p>
                </div>
            </div>
        </div>

        <!-- Monthly Breakdown -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($monthlyData as $month)
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">{{ $month['month'] }}</h3>
                    <span class="px-3 py-1 bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white text-xs font-semibold rounded-full">
                        {{ $month['month_number'] }}/{{ $year }}
                    </span>
                </div>

                <div class="text-center">
                    <p class="text-3xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent mb-2">
                        {{ $month['formatted_income'] }}
                    </p>
                    <p class="text-sm text-gray-600">Income</p>
                </div>

                <!-- Progress Bar -->
                <div class="mt-4">
                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                        <span>Progress</span>
                        <span>{{ $totalYear > 0 ? round(($month['income'] / $totalYear) * 100, 1) : 0 }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-[#7B542F] to-[#A0724B] h-2 rounded-full transition-all duration-500"
                             style="width: {{ $totalYear > 0 ? ($month['income'] / $totalYear) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Chart Section -->
        <div class="mt-8 bg-white rounded-2xl shadow-md p-6 border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Monthly Income Chart</h3>
            <div class="h-64">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>
</x-admin-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyData = @json($monthlyData);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: monthlyData.map(month => month.month.substring(0, 3)),
            datasets: [{
                label: 'Income (Rp)',
                data: monthlyData.map(month => month.income),
                backgroundColor: 'rgba(123, 84, 47, 0.1)',
                borderColor: 'rgba(123, 84, 47, 1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(123, 84, 47, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
});
</script>