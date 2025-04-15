<!DOCTYPE html>
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

        {{ $reports->links() }} 
    </div>
</body>
</html>
