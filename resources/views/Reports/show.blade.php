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
                <a href="{{ route('report.exportSingle', $report->id) }}" class="btn btn-success">Export to Excel</a>
            </div>

            @if(auth()->user()->role === 'STAFF')
    <form action="{{ route('report.updateStatus', $report->id) }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-3">
            <label for="statement" class="form-label">Update Report Status</label>
            <select name="statement" id="statement" class="form-control" required>
                <option value="on_process" {{ $report->statement == 'on_process' ? 'selected' : '' }}>On Process</option>
                <option value="done" {{ $report->statement == 'done' ? 'selected' : '' }}>Done</option>
                <option value="rejected" {{ $report->statement == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Status</button>
    </form>
@endif
        </div>
    </div>
</x-app-layout>
