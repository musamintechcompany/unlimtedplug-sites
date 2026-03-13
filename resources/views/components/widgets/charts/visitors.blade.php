@can('view-analytics')
<div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6 mb-8">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-[#EDEDEC]">Visitor Analytics</h3>
        
        <select onchange="updateVisitorPeriod(this.value)" class="px-4 py-2 text-sm font-medium border border-gray-300 dark:border-[#3E3E3A] rounded-lg bg-white dark:bg-[#161615] text-gray-900 dark:text-[#EDEDEC] focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="7" selected>Last 7 Days</option>
            <option value="30">Last 30 Days</option>
            <option value="90">Last 3 Months</option>
        </select>
    </div>

    <div style="position: relative; height: 400px;">
        <canvas id="visitorChart"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
let visitorChart;
let currentVisitorPeriod = '7';

function initVisitorChart() {
    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
    const textColor = isDark ? '#A1A09A' : '#6b7280';
    const ctx = document.getElementById('visitorChart').getContext('2d');
    
    visitorChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Page Views',
                    data: [],
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#8b5cf6',
                    pointBorderColor: isDark ? '#161615' : '#fff',
                    pointBorderWidth: 2
                },
                {
                    label: 'Visitors',
                    data: [],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: isDark ? '#161615' : '#fff',
                    pointBorderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: textColor,
                        padding: 15,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: isDark ? 'rgba(22, 22, 21, 0.9)' : 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: { size: 13 },
                    bodyFont: { size: 12 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grace: '10%',
                    ticks: { color: textColor },
                    grid: { color: gridColor }
                },
                x: {
                    ticks: {
                        color: textColor,
                        maxRotation: 45,
                        minRotation: 45
                    },
                    grid: { color: gridColor }
                }
            },
            interaction: {
                intersect: false,
                mode: 'nearest'
            }
        }
    });
    
    loadVisitorChartData();
}

async function loadVisitorChartData() {
    try {
        const response = await fetch(`{{ route('admin.analytics.visitor-chart-data') }}?period=${currentVisitorPeriod}`);
        const data = await response.json();
        
        visitorChart.data.labels = data.labels;
        visitorChart.data.datasets[0].data = data.pageViews;
        visitorChart.data.datasets[1].data = data.visitors;
        visitorChart.update('active');
    } catch (error) {
        console.error('Error loading visitor chart data:', error);
    }
}

function updateVisitorPeriod(period) {
    currentVisitorPeriod = period;
    loadVisitorChartData();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initVisitorChart);
} else {
    initVisitorChart();
}
</script>
@endpush
@endcan
