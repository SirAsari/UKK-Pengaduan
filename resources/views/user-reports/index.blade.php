<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Pembuatan Pengaduan</h2>
                <ul class="list-disc pl-5 text-gray-700 space-y-2">
                    <li>Pengaduan bisa dibuat hanya jika Anda telah membuat akun sebelumnya.</li>
                    <li>Keseluruhan data pada pengaduan bernilai <strong>BENAR</strong> dan <strong>DAPAT DIPERTANGGUNG JAWABKAN</strong>.</li>
                    <li>Seluruh bagian data perlu diisi.</li>
                    <li>Pengaduan Anda akan ditanggapi dalam <strong>2x24 Jam</strong>.</li>
                    <li>Periksa tanggapan Kami, pada <strong>Dashboard setelah Anda Login</strong>.</li>
                    <li>Pembuatan pengaduan dapat dilakukan pada halaman berikut: <a href="{{ route('user.report.create') }}" class="text-blue-600 font-semibold">Ikuti Tautan</a></li>
                </ul>
            </div>


            <div class="flex flex-col sm:flex-row justify-between items-center mb-2">
                <h1 class="text-3xl font-bold text-gray-800">Laporan Terbaru di Sekitar Anda</h1>
                <a href="{{ route('user.report.create') }}" class="mt-4 sm:mt-0 inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    + Buat Laporan
                </a>
            </div>
            <form method="GET" action="{{ route('user.reports') }}" class="mb-5 flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0 mb-6">
                <input type="text" name="search" placeholder="Cari pengaduan..." value="{{ request('search') }}"
                       class="border border-gray-300 rounded-lg p-2 w-full md:w-1/3 focus:ring-2 focus:ring-blue-500">

                <select name="type" class="border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Tipe</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>

                <select name="province" class="border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Provinsi</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province }}" {{ request('province') == $province ? 'selected' : '' }}>{{ $province }}</option>
                    @endforeach
                </select>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Cari</button>
            </form>

            @if($reports->isEmpty())
                <div class="text-gray-500 text-center py-20">
                    <p class="text-lg">Belum ada laporan ditemukan.</p>
                </div>
            @else
                <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($reports as $report)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col">
                            <div class="h-48 w-full overflow-hidden">
                                @if($report->image)
                                    <img src="{{ asset('storage/' . $report->image) }}" alt="Report Image" class="w-full h-full object-cover">
                                @else
                                    <img src="https://via.placeholder.com/300x200?text=No+Image" alt="No Image" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="p-5 flex-1 flex flex-col">
                                <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ Str::limit($report->description, 60) }}</h2>
                                <div class="text-sm text-gray-600 flex-1">
                                    <p><span class="font-medium">Jenis:</span> {{ $report->type }}</p>
                                    <p><span class="font-medium">Provinsi:</span> {{ $report->province }}</p>
                                    <p><span class="font-medium">Status:</span>
                                        <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                            @if($report->statement == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($report->statement == 'on_process') bg-blue-100 text-blue-800
                                            @elseif($report->statement == 'done') bg-green-100 text-green-800
                                            @elseif($report->statement == 'rejected') bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($report->statement) }}
                                        </span>
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('user.report.show', $report->id) }}" class="inline-block text-center w-full px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $reports->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
