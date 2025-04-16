<x-app-layout>
    <div class="container mt-8">
        {{-- <h1 class="text-3xl font-bold mb-6">Head Staff Dashboard</h1> --}}

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <h3 class="text-xl font-semibold text-gray-700">Total Reports</h3>
                <p class="text-3xl font-bold text-gray-800">{{ $totalReports }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <h3 class="text-xl font-semibold text-gray-700">Responded Reports</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $respondedReports }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <h3 class="text-xl font-semibold text-gray-700">Unresponded Reports</h3>
                <p class="text-3xl font-bold text-red-600">{{ $unrespondedReports }}</p>
            </div>
        </div>

        <div class="card bg-white shadow-md rounded-lg overflow-hidden">
            <div class="card-body">
                {{-- <h5 class="card-title text-2xl font-semibold mb-4">Reports Overview</h5> --}}
                <div class="flex justify-center items-center" style="height: 300px;">
                    <canvas id="reportsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="card bg-white shadow-md rounded-lg overflow-hidden mt-8">
            <div class="card-body">
                <div class="flex justify-center items-center" style="height: 300px;">
                    <canvas id="provinceChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx1 = document.getElementById('reportsChart').getContext('2d');
            new Chart(ctx1, {
                type: 'pie',
                data: {
                    labels: ['Responded Reports', 'Unresponded Reports'],
                    datasets: [{
                        label: 'Reports Overview',
                        data: [{{ $respondedReports }}, {{ $unrespondedReports }}],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)'
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
                        legend: { position: 'top' },
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

            const ctx2 = document.getElementById('provinceChart').getContext('2d');
            new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($provinceData->keys()) !!},
                    datasets: [{
                        label: 'Reports by Province',
                        data: {!! json_encode($provinceData->values()) !!},
                        backgroundColor: [
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(201, 203, 207, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 159, 64, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(201, 203, 207, 1)',
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
                        legend: { position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.chart._metasets[0].total;
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
