<x-app-layout>
    <div class="container mt-4">
        <h1 class="mb-4">Create Report</h1>

        <form action="{{ route('user.report.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="" disabled selected>Select Type</option>
                    <option value="KEJAHATAN">KEJAHATAN</option>
                    <option value="PEMBANGUNAN">PEMBANGUNAN</option>
                    <option value="SOSIAL">SOSIAL</option>
                </select>
            </div>

            {{-- <select id="province" name="province">
                <option value="">Pilih Provinsi</option>
            </select>

            <select id="regency" name="regency" disabled>
                <option value="">Pilih Kabupaten/Kota</option>
            </select>

            <select id="subdistrict" name="subdistrict" disabled>
                <option value="">Pilih Kecamatan</option>
            </select>

            <select id="village" name="village" disabled>
                <option value="">Pilih Kelurahan/Desa</option>
            </select> --}}

            <!-- Province -->
            <div class="mb-3">
                <label for="province" class="form-label">Province</label>
                <input type="text" name="province" id="province" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="regency" class="form-label">Regency</label>
                <input type="text" name="regency" id="regency" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="subdistrict" class="form-label">Subdistrict</label>
                <input type="text" name="subdistrict" id="subdistrict" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="village" class="form-label">Village</label>
                <input type="text" name="village" id="village" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('report.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Load Provinsi
        axios.get('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json')
            .then(response => {
                const select = document.getElementById("provinsi");
                response.data.forEach(prov => {
                    select.innerHTML += `<option value="${prov.id}">${prov.name}</option>`;
                });
            });

        document.getElementById("provinsi").addEventListener("change", function () {
            const provId = this.value;
            document.getElementById("kabupaten").innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
            document.getElementById("kabupaten").disabled = false;
            document.getElementById("kecamatan").innerHTML = '<option value="">Pilih Kecamatan</option>';
            document.getElementById("kecamatan").disabled = true;
            document.getElementById("kelurahan").innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
            document.getElementById("kelurahan").disabled = true;

            axios.get(`https://emsifa.github.io/api-wilayah-indonesia/api/regencies/${provId}.json`)
                .then(response => {
                    response.data.forEach(item => {
                        document.getElementById("kabupaten").innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                });
        });

        document.getElementById("kabupaten").addEventListener("change", function () {
            const kabId = this.value;
            document.getElementById("kecamatan").innerHTML = '<option value="">Pilih Kecamatan</option>';
            document.getElementById("kecamatan").disabled = false;
            document.getElementById("kelurahan").innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
            document.getElementById("kelurahan").disabled = true;

            axios.get(`https://emsifa.github.io/api-wilayah-indonesia/api/districts/${kabId}.json`)
                .then(response => {
                    response.data.forEach(item => {
                        document.getElementById("kecamatan").innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                });
        });

        document.getElementById("kecamatan").addEventListener("change", function () {
            const kecId = this.value;
            document.getElementById("kelurahan").innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
            document.getElementById("kelurahan").disabled = false;

            axios.get(`https://emsifa.github.io/api-wilayah-indonesia/api/villages/${kecId}.json`)
                .then(response => {
                    response.data.forEach(item => {
                        document.getElementById("kelurahan").innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                });
        });
    });
    </script>
</x-app-layout>
