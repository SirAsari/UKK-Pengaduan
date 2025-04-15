<x-app-layout>
    <div class="container mt-4">
        <h1 class="mb-4">Create Report</h1>

        <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
            </div>

            <!-- Type -->
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="" disabled selected>Select Type</option>
                    <option value="KEJAHATAN">KEJAHATAN</option>
                    <option value="PEMBANGUNAN">PEMBANGUNAN</option>
                    <option value="SOSIAL">SOSIAL</option>
                </select>
            </div>

            <!-- Province -->
            <div class="mb-3">
                <label for="province" class="form-label">Province</label>
                <input type="text" name="province" id="province" class="form-control" required>
            </div>

            <!-- Regency -->
            <div class="mb-3">
                <label for="regency" class="form-label">Regency</label>
                <input type="text" name="regency" id="regency" class="form-control" required>
            </div>

            <!-- Subdistrict -->
            <div class="mb-3">
                <label for="subdistrict" class="form-label">Subdistrict</label>
                <input type="text" name="subdistrict" id="subdistrict" class="form-control" required>
            </div>

            <!-- Village -->
            <div class="mb-3">
                <label for="village" class="form-label">Village</label>
                <input type="text" name="village" id="village" class="form-control" required>
            </div>

            <!-- Image -->
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <!-- Submit and Cancel Buttons -->
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('report.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</x-app-layout>
