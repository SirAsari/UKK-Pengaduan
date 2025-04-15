<x-app-layout>
    <div class="container mt-4">
        <div class="container mb-5 mt-3">
            <h1 class="text-2xl font-bold mb-4">Yang sedang terjadi disekitar anda</h1>
            {{-- <p class="text-lg mb-6">Platform serba guna Anda untuk mengelola dan menyelesaikan pengaduan secara efisien.</p> --}}
            <a href="{{ route('user.report.create') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200">
                Buat Laporan
            </a>
        </div>
        <div class="row">
            @forelse($reports as $report)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($report->image)
                            <img src="{{ asset('storage/' . $report->image) }}" class="card-img-top" alt="Report Image" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No Image" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $report->description }}</h5>
                            <p class="card-text">
                                <strong>Type:</strong> {{ $report->type }}<br>
                                <strong>Province:</strong> {{ $report->province }}<br>
                                <strong>Status:</strong>
                                <span class="badge
                                    @if($report->statement == 'pending') bg-warning
                                    @elseif($report->statement == 'on_process') bg-info
                                    @elseif($report->statement == 'done') bg-success
                                    @elseif($report->statement == 'rejected') bg-danger
                                    @endif">
                                    {{ ucfirst($report->statement) }}
                                </span>
                            </p>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('user.report.show', $report->id) }}" class="btn btn-primary btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">No reports found.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-3">
            {{ $reports->links('pagination::bootstrap-4') }}
        </div>
    </div>
</x-app-layout>
