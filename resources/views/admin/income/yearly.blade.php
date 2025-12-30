<x-modern-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent mb-2">
                    Yearly Income Breakdown
                </h1>
                <p class="text-gray-600">Income overview for the last 5 years</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-white text-gray-700 rounded-xl font-medium hover:bg-gray-50 border border-gray-200 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
            </a>
        </div>

        <!-- Summary Card -->
        <div class="bg-gradient-to-r from-[#7B542F] to-[#A0724B] rounded-2xl p-6 text-white mb-8">
            <div class="text-center">
                <h3 class="text-xl font-bold mb-2">Total Income (Last 5 Years)</h3>
                <p class="text-3xl font-bold">Rp {{ number_format(array_sum(array_column($yearlyData, 'income')), 0, ',', '.') }}</p>
                <p class="text-sm opacity-90 mt-2">{{ count($yearlyData) }} years • Average: Rp {{ number_format(array_sum(array_column($yearlyData, 'income')) / count($yearlyData), 0, ',', '.') }}/year</p>
            </div>
        </div>

        <!-- Yearly Breakdown -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
            @foreach($yearlyData as $year)
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-xl transition-all duration-300">
                <div class="text-center mb-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $year['year'] }}</h3>
                    <span class="px-3 py-1 bg-gradient-to-r from-[#7B542F] to-[#A0724B] text-white text-xs font-semibold rounded-full">
                        Year
                    </span>
                </div>

                <div class="text-center">
                    <p class="text-3xl font-bold bg-gradient-to-r from-[#7B542F] to-[#A0724B] bg-clip-text text-transparent mb-2">
                        {{ $year['formatted_income'] }}
                    </p>
                    <p class="text-sm text-gray-600">Total Income</p>
                </div>

                <!-- Growth Indicator -->
                @if($loop->index > 0)
                    @php
                        $previousIncome = $yearlyData[$loop->index - 1]['income'];
                        $growth = $previousIncome > 0 ? (($year['income'] - $previousIncome) / $previousIncome) * 100 : 0;
                    @endphp
                    <div class="mt-4 text-center">
                        <div class="flex items-center justify-center text-xs {{ $growth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <svg class="w-4 h-4 mr-1 {{ $growth >= 0 ? '' : 'rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            {{ abs(round($growth, 1)) }}% {{ $growth >= 0 ? 'increase' : 'decrease' }}
                        </div>
                    </div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Chart Section -->
        <div class="mt-8 bg-white rounded-2xl shadow-md p-6 border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Yearly Income Trend</h3>
            <div class="h-64">
                <canvas id="yearlyChart"></canvas>
            </div>
        </div>
    </div>
</x-admin-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('yearlyChart').getContext('2d');
    const yearlyData = @json($yearlyData);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: yearlyData.map(year => year.year),
            datasets: [{
                label: 'Income (Rp)',
                data: yearlyData.map(year => year.income),
                backgroundColor: [
                    'rgba(123, 84, 47, 0.8)',
                    'rgba(160, 114, 75, 0.8)',
                    'rgba(123, 84, 47, 0.7)',
                    'rgba(160, 114, 75, 0.7)',
                    'rgba(123, 84, 47, 0.6)',
                ],
                borderColor: [
                    'rgba(123, 84, 47, 1)',
                    'rgba(160, 114, 75, 1)',
                    'rgba(123, 84, 47, 1)',
                    'rgba(160, 114, 75, 1)',
                    'rgba(123, 84, 47, 1)',
                ],
                borderWidth: 1,
                borderRadius: 8,
                borderSkipped: false,
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
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
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