<x-app-layout>
    <div class="container mx-auto mt-8 mb-10">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Pengaduan</h1>
            <div class="flex space-x-4">
                <a href="{{ route('report.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Tambah Pengaduan
                </a>
                <a href="{{ route('report.export') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    Ekspor Semua ke Excel
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Ekspor Berdasarkan Tanggal</h2>
            <form method="GET" action="{{ route('report.exportByDate') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="date" name="start_date" class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tanggal Mulai" required>
                <input type="date" name="end_date" class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tanggal Akhir" required>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    Ekspor
                </button>
            </form>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Cari Pengaduan</h2>
            <form method="GET" action="{{ route('report.index') }}" class="flex flex-wrap items-center space-x-4">
                <input type="text" name="search" class="flex-grow border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Cari pengaduan..." value="{{ request('search') }}">

                <select name="type" class="border border-gray-300 rounded-lg p-2">
                    <option value="">Semua Tipe</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>

                <select name="province" class="border border-gray-300 rounded-lg p-2">
                    <option value="">Semua Provinsi  </option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province }}" {{ request('province') == $province ? 'selected' : '' }}>{{ $province }}</option>
                    @endforeach
                </select>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Cari
                </button>
            </form>

        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Daftar Pengaduan</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">ID</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Deskripsi</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Tipe</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Provinsi</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Status</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                            <tr class="border-t border-gray-300 hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $report->id }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $report->description }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $report->type }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $report->province }}</td>
                                <td class="px-4 py-2 text-sm">
                                    <span class="px-3 py-1 rounded-full text-white
                                        @if($report->statement == 'pending') bg-yellow-500
                                        @elseif($report->statement == 'on_process') bg-blue-500
                                        @elseif($report->statement == 'done') bg-green-500
                                        @elseif($report->statement == 'rejected') bg-red-500
                                        @endif">
                                        {{ ucfirst($report->statement) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('report.show', $report->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-700">
                                            Lihat
                                        </a>
                                        <a href="{{ route('report.edit', $report->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-yellow-600">
                                            Edit
                                        </a>
                                        <form action="{{ route('report.destroy', $report->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-2 text-center text-gray-500">Tidak ada pengaduan ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $reports->links('pagination::tailwind') }}
            </div>
        </div>

    </div>
</x-app-layout>
