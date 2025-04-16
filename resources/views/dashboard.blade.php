<x-app-layout>
    <div class="bg-blue-600 text-white py-20">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Selamat Datang di Pengaduan Nasional</h1>
            <p class="text-lg mb-6">Platform serba guna Anda untuk mengelola dan menyelesaikan pengaduan secara efisien.</p>
            @if(auth()->check() && auth()->user()->role === 'USER')
            <a href="{{ route('user.reports') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200">
                Lihat Pengaduan
            </a>
            @endif
            @if(auth()->check() && (auth()->user()->role === 'STAFF' || auth()->user()->role === 'HEAD_STAFF'))
            <a href="{{ route('report.index') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200">
                Lihat Pengaduan
            </a>
            @endif
        </div>
    </div>

    <div class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-8">Mengapa Memilih Kami?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md text-center transform transition-all duration-500 ease-out hover:translate-y-4 hover:shadow-lg animate-up-delay-1">
                    <h3 class="text-xl font-semibold mb-4">Pelaporan yang Efisien</h3>
                    <p class="text-gray-600">Buat dan kelola pengaduan dengan mudah menggunakan antarmuka yang ramah pengguna.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center transform transition-all duration-500 ease-out hover:translate-y-4 hover:shadow-lg animate-up-delay-2">
                    <h3 class="text-xl font-semibold mb-4">Pembaruan Real-Time</h3>
                    <p class="text-gray-600">Tetap terinformasi dengan pembaruan real-time tentang status pengaduan Anda.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center transform transition-all duration-500 ease-out hover:translate-y-4 hover:shadow-lg animate-up-delay-3">
                    <h3 class="text-xl font-semibold mb-4">Aman dan Terpercaya</h3>
                    <p class="text-gray-600">Data Anda aman bersama kami, berkat platform kami yang terjamin keamanannya.</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes slideUp {
            0% {
                transform: translateY(30px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-up {
            animation: slideUp 0.7s ease-out forwards;
        }

        .animate-up-delay-1 {
            animation: slideUp 0.7s ease-out forwards;
            animation-delay: 0s;
        }

        .animate-up-delay-2 {
            animation: slideUp 0.7s ease-out forwards;
            animation-delay: 0.1s;
        }

        .animate-up-delay-3 {
            animation: slideUp 0.7s ease-out forwards;
            animation-delay: 0.2s;
        }
    </style>
</x-app-layout>
