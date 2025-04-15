<x-app-layout>
    <div class="container mt-4">
        <h1 class="mb-4">Report Details</h1>

        <div class="card">
            <div class="card-header">
                <h5>Report ID: {{ $report->id }}</h5>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> {{ $report->description }}</p>
                <p><strong>Type:</strong> {{ $report->type }}</p>
                <p><strong>Province:</strong> {{ $report->province }}</p>
                <p><strong>Regency:</strong> {{ $report->regency }}</p>
                <p><strong>Subdistrict:</strong> {{ $report->subdistrict }}</p>
                <p><strong>Village:</strong> {{ $report->village }}</p>
                <p><strong>Voting:</strong> {{ $report->voting }}</p>
                <p><strong>Viewers:</strong> {{ $report->viewers }}</p>
                <p><strong>Status:</strong>
                    <span class="badge
                        @if($report->statement == 'pending') bg-warning
                        @elseif($report->statement == 'on_process') bg-info
                        @elseif($report->statement == 'done') bg-success
                        @elseif($report->statement == 'rejected') bg-danger
                        @endif">
                        {{ ucfirst($report->statement) }}
                    </span>
                </p>
                @if($report->image)
                    <p><strong>Image:</strong></p>
                    <img src="{{ asset('storage/' . $report->image) }}" alt="Report Image" class="img-fluid rounded">
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('report.index') }}" class="btn btn-secondary">Back to Reports</a>
            </div>
        </div>
    </div>
</x-app-layout>
