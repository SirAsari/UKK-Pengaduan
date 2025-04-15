<x-app-layout>
    <div class="container mt-4">
        <h1 class="mb-4">Edit Staff</h1>

        <form action="{{ route('staff-management.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password (Leave blank to keep current password)</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <div class="mb-3">
                <label for="province" class="form-label">Province</label>
                <input type="text" name="province" id="province" class="form-control" value="{{ $user->staffProvinces->first()->province ?? '' }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('staff-management.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</x-app-layout>
