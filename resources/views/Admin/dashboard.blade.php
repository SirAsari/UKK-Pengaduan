{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h1>Reports</h1>
        <a href="{{ route('reports.create') }}" class="btn btn-primary mb-3">Create Report</a>

        <!-- Search form -->
        <form method="GET" action="{{ route('reports.index') }}">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="Search reports..." value="{{ request('search') }}">
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Province</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->id }}</td>
                        <td>{{ $report->description }}</td>
                        <td>{{ $report->type }}</td>
                        <td>{{ $report->province }}</td>
                        <td>{{ $report->statement }}</td>
                        <td>
                            <a href="{{ route('reports.show', $report->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('reports.destroy', $report->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="container mt-4">
            <h1 class="mb-4">Head Staff Dashboard</h1>

            <div class="mb-4">
                <!-- Button to redirect to the Reports page -->
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

        {{ $reports->links() }}
    </div>
</body>
</html> --}}
