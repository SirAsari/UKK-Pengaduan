<x-app-layout>
    <div class="bg-blue-600 text-white py-20">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Selamat Datang di Pengaduan Nasional</h1>
            <p class="text-lg mb-6">Platform serba guna Anda untuk mengelola dan menyelesaikan pengaduan secara efisien.</p>
            <a href="{{ route('user.reports') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200">
                Lihat Pengaduan
            </a>
        </div>
    </div>

    <div class="py-16 bg-gray-100">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-center mb-8">Mengapa Memilih Kami?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <h3 class="text-xl font-semibold mb-4">Pelaporan yang Efisien</h3>
                    <p class="text-gray-600">Buat dan kelola pengaduan dengan mudah menggunakan antarmuka yang ramah pengguna.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <h3 class="text-xl font-semibold mb-4">Pembaruan Real-Time</h3>
                    <p class="text-gray-600">Tetap terinformasi dengan pembaruan real-time tentang status pengaduan Anda.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <h3 class="text-xl font-semibold mb-4">Aman dan Terpercaya</h3>
                    <p class="text-gray-600">Data Anda aman bersama kami, berkat platform kami yang terjamin keamanannya.</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p class="text-sm">&copy; {{ date('Y') }} Pengaduan Nasional. Semua Hak Dilindungi.</p>
            <div class="mt-4">
                <a href="{{ route('user.reports') }}" class="text-gray-400 hover:text-white mx-2">Lihat Pengaduan</a>
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white mx-2">Dashboard</a>
            </div>
        </div>
    </footer>
</x-app-layout>
