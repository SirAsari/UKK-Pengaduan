<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 pt-10">
        <h1 class="text-2xl font-bold mb-6">Manage User</h1>

        <form method="GET" action="{{ route('staff-management.index') }}" class="mb-6">
            <select name="role" onchange="this.form.submit()"
                class="w-full md:w-1/4 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="STAFF" {{ $roleFilter == 'STAFF' ? 'selected' : '' }}>STAFF</option>
                <option value="GUEST" {{ $roleFilter == 'GUEST' ? 'selected' : '' }}>GUEST</option>
                <option value="HEAD_STAFF" {{ $roleFilter == 'HEAD_STAFF' ? 'selected' : '' }}>HEAD STAFF</option>
            </select>
        </form>

        <a href="{{ route('staff-management.create') }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded mb-4">
            + Create Staff
        </a>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 shadow-sm rounded-lg">
                <thead class="bg-gray-800 text-left text-white uppercase text-sm">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Role</th>
                        <th class="px-4 py-2">Province</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $user->id }}</td>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ $user->role }}</td>
                            <td class="px-4 py-2">{{ $user->staffProvinces->first()->province ?? 'N/A' }}</td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('staff-management.edit', $user->id) }}"
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                                    Edit
                                </a>
                                <form action="{{ route('staff-management.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center px-4 py-6 text-gray-500">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
    </div>
</x-app-layout>
