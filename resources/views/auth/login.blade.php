<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bimbingan Konseling</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-600 rounded-full mb-4">
                <i class="fas fa-graduation-cap text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang</h1>
            <p class="text-gray-600">Sistem Bimbingan Konseling</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Login</h2>

            <!-- Success Message -->
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-envelope mr-2 text-blue-600"></i>Email
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror" 
                           placeholder="email@example.com"
                           required 
                           autofocus>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-lock mr-2 text-blue-600"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror" 
                               placeholder="••••••••"
                               required>
                        <button type="button" 
                                onclick="togglePassword()"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-eye" id="toggle-icon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="remember" 
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                    </label>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700">Lupa Password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Login
                </button>
            </form>

            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                        Daftar Sekarang
                    </a>
                </p>
            </div>

            <!-- Back to Home -->
            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700 text-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-gray-600 text-sm">
            <p>&copy; {{ date('Y') }} Bimbingan Konseling. All rights reserved.</p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('toggle-icon');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>