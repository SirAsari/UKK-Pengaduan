<x-app-layout>
    <div class="container mt-4">
        <h1 class="mb-4">Resolve Report</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Report Details</h5>
                <p><strong>Description:</strong> {{ $report->description }}</p>
                <p><strong>Type:</strong> {{ $report->type }}</p>
                <p><strong>Province:</strong> {{ $report->province }}</p>
                <p><strong>Status:</strong>
                    <span class="badge
                        @if($report->response->response_status == 'on_progress') bg-info
                        @elseif($report->response->response_status == 'done') bg-success
                        @elseif($report->response->response_status == 'reject') bg-danger
                        @endif">
                        {{ ucfirst($report->response->response_status) }}
                    </span>
                </p>
            </div>
        </div>

        <form action="{{ route('report.updateStatus', $report->id) }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="response_status" class="form-label">Update Response Status</label>
                <select name="response_status" id="response_status" class="form-control" required>
                    <option value="on_progress" {{ $report->response->response_status == 'on_progress' ? 'selected' : '' }}>On Progress</option>
                    <option value="done" {{ $report->response->response_status == 'done' ? 'selected' : '' }}>Done</option>
                    <option value="reject" {{ $report->response->response_status == 'reject' ? 'selected' : '' }}>Reject</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
    </div>
</x-app-layout>
