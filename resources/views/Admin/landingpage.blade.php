<x-app-layout>
    <div class="container mt-4">
        <h1 class="mb-4">Head Staff Dashboard</h1>

        <div class="mb-4">
            <a href="{{ route('report.index') }}" class="btn btn-primary">Go to Reports</a>

            <!-- Button to redirect to Staff Management (visible only to HEAD_STAFF) -->
            @if(auth()->user()->role === 'HEAD_STAFF')
                <a href="{{ route('staff-management.index') }}" class="btn btn-secondary">Manage Staff</a>
            @endif
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Reports Overview</h5>
                <div style="width: 300px; height: 300px; margin: 0 auto;">
                    <canvas id="reportsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Chart.js from the CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('reportsChart').getContext('2d');
            const reportsChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Responded Reports', 'Unresponded Reports'],
                    datasets: [{
                        label: 'Reports Overview',
                        data: [{{ $respondedReports }}, {{ $unrespondedReports }}],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)', // Responded Reports
                            'rgba(255, 99, 132, 0.2)'  // Unresponded Reports
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 1,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = {{ $totalReports }};
                                    const percentage = ((value / total) * 100).toFixed(2);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
