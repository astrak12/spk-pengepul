<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Sampah Japos Bersih RW09</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        body { font-family: 'Inter', sans-serif; }
        
        .hero-bg {
            background: linear-gradient(135deg, #166534 0%, #22c55e 100%);
        }
        
        .floating {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-600 rounded-2xl flex items-center justify-center text-white text-2xl">♻️</div>
                <div>
                    <h1 class="font-bold text-2xl text-green-700">Japos Bersih</h1>
                    <p class="text-xs text-green-600 -mt-1">RW09</p>
                </div>
            </div>
            
            <div class="hidden md:flex items-center gap-8 font-medium">
                <a href="#" class="hover:text-green-600 transition">Beranda</a>
                <a href="#" class="hover:text-green-600 transition">Tentang</a>
                <a href="#" class="hover:text-green-600 transition">Fitur</a>
                <a href="#" class="hover:text-green-600 transition">Cara Kerja</a>
                <a href="#" class="hover:text-green-600 transition">Hasil Keputusan</a>
                <a href="#" class="hover:text-green-600 transition">Kontak</a>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="/login" class="px-6 py-2.5 bg-white border border-green-600 text-green-600 font-medium rounded-2xl hover:bg-green-50 transition">
                    Login
                </a>
                <a href="/spk" class="px-6 py-2.5 bg-green-600 text-white font-semibold rounded-2xl hover:bg-green-700 transition">
                    Login ke SPK
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-bg text-white pt-24 pb-20">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-8">
                <h1 class="text-5xl md:text-6xl font-bold leading-tight">
                    Bank Sampah Japos Bersih RW09
                </h1>
                <p class="text-2xl font-medium text-green-100">
                    Mengelola Sampah, Membangun Masa Depan Hijau
                </p>
                <p class="text-lg max-w-lg text-green-100">
                    Sistem Pendukung Keputusan Pemilihan Pengepul Terbaik menggunakan metode 
                    <span class="font-semibold">SAW</span> & <span class="font-semibold">TOPSIS</span>
                </p>
                
                <div class="flex flex-wrap gap-4">
                    <a href="/spk" class="px-8 py-4 bg-white text-green-700 font-semibold rounded-3xl flex items-center gap-3 hover:scale-105 transition">
                        <i class="fas fa-calculator"></i>
                        Akses SPK Sekarang
                    </a>
                    <a href="#tentang" class="px-8 py-4 border border-white text-white font-semibold rounded-3xl flex items-center gap-3 hover:bg-white/10 transition">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
                
                <div class="flex items-center gap-8 pt-6">
                    <div>
                        <span class="block text-4xl font-bold">150+</span>
                        <span class="text-sm">Nasabah Aktif</span>
                    </div>
                    <div>
                        <span class="block text-4xl font-bold">12</span>
                        <span class="text-sm">Pengepul Mitra</span>
                    </div>
                    <div>
                        <span class="block text-4xl font-bold">2.8 Ton</span>
                        <span class="text-sm">Sampah Daur Ulang</span>
                    </div>
                </div>
            </div>
            
            <div class="relative">
                <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-8 shadow-2xl">
                    <img src="https://placehold.co/600x500/166534/ffffff?text=Bank+Sampah+Japos+Bersih" 
                         alt="Bank Sampah Japos Bersih RW09" 
                         class="rounded-2xl shadow-xl">
                </div>
                <!-- Floating elements -->
                <div class="absolute -top-6 -left-6 text-6xl floating">♻️</div>
                <div class="absolute -bottom-6 right-10 text-5xl floating" style="animation-delay: 1s;">🌱</div>
                <div class="absolute top-1/3 -right-8 text-4xl floating" style="animation-delay: 2s;">🍃</div>
            </div>
        </div>
    </section>

    <!-- About Us -->
    <section id="tentang" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-green-700">Tentang Bank Sampah Japos Bersih RW09</h2>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                    Kami adalah bank sampah berbasis komunitas yang berkomitmen mengurangi limbah rumah tangga 
                    dan meningkatkan nilai ekonomi sampah melalui daur ulang.
                </p>
            </div>
        </div>
    </section>

    <!-- Fitur Utama -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-12 text-green-700">Fitur Utama</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-8 rounded-3xl shadow hover:shadow-xl hover:-translate-y-2 transition">
                    <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center text-3xl mb-6">📊</div>
                    <h3 class="text-xl font-semibold mb-2">Kelola Kriteria</h3>
                    <p class="text-gray-600">Kelola bobot kriteria penilaian pengepul secara fleksibel.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow hover:shadow-xl hover:-translate-y-2 transition">
                    <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center text-3xl mb-6">📝</div>
                    <h3 class="text-xl font-semibold mb-2">Input Penilaian</h3>
                    <p class="text-gray-600">Input data penilaian pengepul dengan mudah dan akurat.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow hover:shadow-xl hover:-translate-y-2 transition">
                    <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center text-3xl mb-6">🔬</div>
                    <h3 class="text-xl font-semibold mb-2">SAW + TOPSIS</h3>
                    <p class="text-gray-600">Perhitungan otomatis menggunakan dua metode terbaik.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow hover:shadow-xl hover:-translate-y-2 transition">
                    <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center text-3xl mb-6">🏆</div>
                    <h3 class="text-xl font-semibold mb-2">Ranking Otomatis</h3>
                    <p class="text-gray-600">Rekomendasi pengepul terbaik secara real-time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-green-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="text-4xl">♻️</div>
                        <h3 class="text-2xl font-bold">Japos Bersih RW09</h3>
                    </div>
                    <p class="text-green-200">Mengelola sampah hari ini untuk lingkungan yang lebih baik besok.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Navigasi</h4>
                    <ul class="space-y-2 text-green-200">
                        <li><a href="#" class="hover:text-white">Beranda</a></li>
                        <li><a href="#" class="hover:text-white">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white">Fitur SPK</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <p class="text-green-200">RW 09 Kel. Japos, Kec. Tangerang</p>
                    <p class="text-green-200">WA: 0812-3456-7890</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Ikuti Kami</h4>
                    <div class="flex gap-4 text-2xl">
                        <i class="fab fa-instagram hover:text-green-300 cursor-pointer"></i>
                        <i class="fab fa-whatsapp hover:text-green-300 cursor-pointer"></i>
                    </div>
                </div>
            </div>
            <div class="border-t border-green-700 mt-12 pt-6 text-center text-green-300 text-sm">
                © 2025 Bank Sampah Japos Bersih RW09 - All Rights Reserved
            </div>
        </div>
    </footer>

    <script>
        // Tailwind script sudah di-load via CDN
        console.log("%c✅ Landing Page Bank Sampah Japos Bersih RW09 siap digunakan!", "color: #166534; font-size: 16px; font-weight: bold");
    </script>
</body>
</html>