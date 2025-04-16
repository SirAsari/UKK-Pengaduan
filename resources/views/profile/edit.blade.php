<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-900 leading-tight">
            {{ __('Profil Anda') }}
        </h2>
        <p class="text-sm text-gray-500 mt-1">Kelola informasi akun dan laporan Anda.</p>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            {{-- Report List --}}
            <div class="bg-white p-6 shadow-xl rounded-2xl">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Laporan Anda</h3>
                @if($reports->isEmpty())
                    <p class="text-gray-500">Belum ada laporan yang dibuat.</p>
                @else
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($reports as $report)
                            <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition">
                                <h4 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $report->description }}</h4>
                                <p class="text-sm text-gray-500">
                                    <strong>Status:</strong>
                                    <span class="capitalize inline-block
                                        @if($report->statement == 'pending') text-yellow-600
                                        @elseif($report->statement == 'on_process') text-blue-600
                                        @elseif($report->statement == 'done') text-green-600
                                        @elseif($report->statement == 'rejected') text-red-600
                                        @endif">
                                        {{ $report->statement }}
                                    </span>
                                </p>
                                <a href="{{ route('user.report.show', $report->id) }}" class="mt-2 inline-block text-sm text-blue-600 hover:underline">
                                    Lihat Detail
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Profile Update --}}
            <div class="bg-white p-6 shadow-xl rounded-2xl">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Informasi Profil</h3>
                <div class="max-w-2xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Password Update --}}
            <div class="bg-white p-6 shadow-xl rounded-2xl">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Ubah Kata Sandi</h3>
                <div class="max-w-2xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="bg-white p-6 shadow-xl rounded-2xl">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Hapus Akun</h3>
                <div class="max-w-2xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
