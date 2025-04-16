<x-app-layout>
    <div class="container mx-auto mt-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-blue-600 text-white px-6 py-4">
                <h1 class="text-2xl font-bold">Detail Pengaduan</h1>
                <p class="text-sm">ID Pengaduan: <span class="font-semibold">{{ $report->id }}</span></p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        @if($report->image)
                            <img src="{{ asset('storage/' . $report->image) }}" alt="Report Image" class="rounded-lg shadow-md mt-2">
                        @endif
                        <p class="text-gray-700 pt-4"><strong>Total Suara:</strong>
                            <i class="fas fa-thumbs-up text-blue-500"></i> {{ $report->voting }}
                        </p>
                        <p class="text-gray-700"><strong>Jumlah Dilihat:</strong> {{ $report->viewers }}</p>

                    </div>
                    <div>
                        <p class="text-gray-700 pt-1"><strong>Deskripsi:</strong> {{ $report->description }}</p>
                        <p class="text-gray-700 pt-1"><strong>Tipe:</strong> {{ $report->type }}</p>
                        <p class="text-gray-700 pt-1"><strong>Provinsi:</strong> {{ $report->province }}</p>
                        <p class="text-gray-700 pt-1"><strong>Kabupaten:</strong> {{ $report->regency }}</p>
                        <p class="text-gray-700 pt-1"><strong>Kecamatan:</strong> {{ $report->subdistrict }}</p>
                        <p class="text-gray-700 pt-1"><strong>Desa:</strong> {{ $report->village }}</p>
                        <p class="text-gray-700 pt-1"><strong>Status:</strong>
                            <span class="px-3 py-1 rounded-full text-white
                                @if($report->statement == 'pending') bg-yellow-500
                                @elseif($report->statement == 'on_process') bg-blue-500
                                @elseif($report->statement == 'done') bg-green-500
                                @elseif($report->statement == 'rejected') bg-red-500
                                @endif">
                                {{ ucfirst($report->statement) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 px-6 py-4 text-center">
                @php
                    $votedBy = $report->voted_by ? json_decode($report->voted_by, true) : [];
                @endphp

                @if(in_array(auth()->id(), $votedBy))
                    <button class="bg-gray-400 text-white px-4 py-2 rounded-lg cursor-not-allowed">
                        <i class="fas fa-thumbs-up"></i> Anda Sudah Memberi Suara
                    </button>
                @else
                    <form action="{{ route('report.vote', $report->id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            <i class="fas fa-thumbs-up"></i> Beri Suara
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4">Komentar</h2>
            <form action="{{ route('report.comment', $report->id) }}" method="POST" class="mb-6">
                @csrf
                <textarea name="comment" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Tulis komentar Anda..." required></textarea>
                <button type="submit" class="mt-3 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Kirim Komentar
                </button>
            </form>

            <div class="space-y-4">
                @forelse($report->comments as $comment)
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <p class="font-semibold">{{ $comment->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                        <p class="text-gray-700 mt-2">{{ $comment->comment }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada komentar. Jadilah yang pertama untuk berkomentar!</p>
                @endforelse
            </div>
        </div>
        <div x-data="{ open: {{ session('badword_detected') ? 'true' : 'false' }} }" x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                <h2 class="text-xl font-bold mb-4 text-red-600">Komentar Ditolak</h2>
                <p class="text-gray-700">Komentar Anda mengandung kata tidak pantas.</p>
                <div class="mt-4 text-right">
                    <button @click="open = false" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
