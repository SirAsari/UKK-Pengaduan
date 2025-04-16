<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-xl">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Buat Laporan Baru</h1>

            <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="description" class="block font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required></textarea>
                </div>

                <div>
                    <label for="type" class="block font-medium text-gray-700 mb-1">Report Type</label>
                    <select name="type" id="type" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="" disabled selected>Pilih Jenis</option>
                        <option value="KEJAHATAN">Kejahatan</option>
                        <option value="PEMBANGUNAN">Pembangunan</option>
                        <option value="SOSIAL">Sosial</option>
                        <option value="KECELAKAAN">Kecelakaan</option>
                        <option value="LINGKUNGAN">Lingkungan</option>
                        <option value="KESEHATAN">Kesehatan</option>
                        <option value="KEAMANAN">Keamanan</option>
                        <option value="KERUSAKAAN PROPERTI">Kerusakan Properti</option>
                        <option value="LAINNYA">Lainnya</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="province" class="block font-medium text-gray-700 mb-1">Provinsi</label>
                        <input type="text" name="province" id="province" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="regency" class="block font-medium text-gray-700 mb-1">Kabupaten</label>
                        <input type="text" name="regency" id="regency" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="subdistrict" class="block font-medium text-gray-700 mb-1">Kecamatan</label>
                        <input type="text" name="subdistrict" id="subdistrict" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="village" class="block font-medium text-gray-700 mb-1">Desa/Kelurahan</label>
                        <input type="text" name="village" id="village" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                </div>

                <div>
                    <label for="image" class="block font-medium text-gray-700 mb-1">Upload Gambar (opsional)</label>
                    <input type="file" name="image" id="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('report.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Cancel</a>
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">Submit</button>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
