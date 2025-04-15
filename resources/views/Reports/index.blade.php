<!-- filepath: c:\Users\PPLG\Documents\UKK_asari\Pengaduan\resources\views\Reports\index.blade.php -->
<x-app-layout>
    <div class="container mt-4">
        <h1 class="mb-4">Reports</h1>
        <a href="{{ route('report.create') }}" class="btn btn-primary mb-3">Create Report</a>

        <!-- Search form -->
        <form method="GET" action="{{ route('report.search') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search reports..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">Search</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
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
                    @forelse($reports as $report)
                        <tr>
                            <td>{{ $report->id }}</td>
                            <td>{{ $report->description }}</td>
                            <td>{{ $report->type }}</td>
                            <td>{{ $report->province }}</td>
                            <td>{{ $report->statement }}</td>
                            <td>
                                <a href="{{ route('report.show', $report->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('report.edit', $report->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('report.destroy', $report->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No reports found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $reports->links('pagination::bootstrap-4') }}
        </div>
    </div>
</x-app-layout>
