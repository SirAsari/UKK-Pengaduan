<x-app-layout>
    <div class="container mt-4">
        <h1 class="mb-4">Create Staff</h1>

        <form action="{{ route('staff-management.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="province" class="form-label">Province</label>
                <input type="text" name="province" id="province" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('staff-management.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</x-app-layout>
