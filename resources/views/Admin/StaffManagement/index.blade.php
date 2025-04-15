<x-app-layout>
    <div class="container mt-4">
        <h1 class="mb-4">Manage Staff</h1>

        <form method="GET" action="{{ route('staff-management.index') }}" class="mb-4">
            <div class="input-group">
                <select name="role" class="form-select" onchange="this.form.submit()">
                    <option value="STAFF" {{ $roleFilter == 'STAFF' ? 'selected' : '' }}>STAFF</option>
                    <option value="GUEST" {{ $roleFilter == 'GUEST' ? 'selected' : '' }}>GUEST</option>
                    <option value="HEAD_STAFF" {{ $roleFilter == 'HEAD_STAFF' ? 'selected' : '' }}>HEAD STAFF</option>
                </select>
            </div>
        </form>

        <a href="{{ route('staff-management.create') }}" class="btn btn-primary mb-3">Create Staff</a>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Province</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->staffProvinces->first()->province ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('staff-management.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('staff-management.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
    </div>
</x-app-layout>
