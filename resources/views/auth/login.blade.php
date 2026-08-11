<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-green-50">
        
        <div class="mb-6 text-center">
            <h1 class="text-4xl font-extrabold text-green-700 tracking-wider uppercase mb-2">SPK Pengepul</h1>
            <p class="text-green-600 font-medium">Sistem Pendukung Keputusan Pemilihan Pengepul Terbaik</p>
        </div>

        <div class="w-full sm:max-w-md mt-2 px-8 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-xl border-t-4 border-green-600">
            
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Silakan Masuk</h2>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-5">
                    <label for="email" class="block font-medium text-sm text-gray-700">Email Aplikasi</label>
                    <input id="email" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan email Anda..." />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
                </div>

                <div class="mb-5">
                    <label for="password" class="block font-medium text-sm text-gray-700">Kata Sandi</label>
                    <input id="password" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi..." />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
                </div>

                <div class="block mt-4 mb-6">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                    </label>
                </div>

                <div class="flex flex-col items-center justify-end mt-4">
                    <button type="submit" class="w-full text-center items-center px-4 py-3 bg-green-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md mb-4">
                        Masuk Sekarang
                    </button>

                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-500 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" href="{{ route('password.request') }}">
                            Lupa kata sandi Anda?
                        </a>
                    @endif
                </div>
            </form>
        </div>
        
        <div class="mt-8 text-center text-sm text-green-600">
            &copy; 2025 Bank Sampah Japos 09.
        </div>
    </div>
</x-guest-layout>