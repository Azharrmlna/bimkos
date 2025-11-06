<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Bimbingan Konseling</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-600 rounded-full mb-4">
                <i class="fas fa-user-plus text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Daftar Akun Baru</h1>
            <p class="text-gray-600">Sistem Bimbingan Konseling</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Register Siswa</h2>

            <!-- Error Messages -->
            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-user mr-2 text-blue-600"></i>Nama Lengkap
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror" 
                           placeholder="Nama lengkap Anda"
                           required 
                           autofocus>
                </div>

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
                           required>
                </div>

                <!-- Kelas -->
                <div class="mb-4">
                    <label for="kelas" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-school mr-2 text-blue-600"></i>Kelas
                    </label>
                    <select id="kelas" 
                            name="kelas" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kelas') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Kelas</option>
                        <option value="X TBSM 1" {{ old('kelas') == 'X TBSM 1' ? 'selected' : '' }}>X TBSM 1</option>
                        <option value="X TBSM 2" {{ old('kelas') == 'X TBSM 2' ? 'selected' : '' }}>X TBSM 2</option>
                        <option value="XI TBSM 1" {{ old('kelas') == 'XI TBSM 1' ? 'selected' : '' }}>XI TBSM 1</option>
                        <option value="XI TBSM 2" {{ old('kelas') == 'XI TBSM 2' ? 'selected' : '' }}>XI TBSM 2</option>
                        <option value="XII TBSM 1" {{ old('kelas') == 'XII TBSM 1' ? 'selected' : '' }}>XII TBSM 1</option>
                        <option value="XII TBSM 2" {{ old('kelas') == 'XII TBSM 2' ? 'selected' : '' }}>XII TBSM 2</option>
                        <option value="X RPL 1" {{ old('kelas') == 'X RPL 1' ? 'selected' : '' }}>X RPL 1</option>
                        <option value="X RPL 2" {{ old('kelas') == 'X RPL 2' ? 'selected' : '' }}>X RPL 2</option>
                        <option value="XI RPL 1" {{ old('kelas') == 'XI RPL 1' ? 'selected' : '' }}>XI RPL 1</option>
                        <option value="XI RPL 2" {{ old('kelas') == 'XI RPL 2' ? 'selected' : '' }}>XI RPL 2</option>
                        <option value="XII RPL 1" {{ old('kelas') == 'XII RPL 1' ? 'selected' : '' }}>XII RPL 1</option>
                        <option value="XII RPL 2" {{ old('kelas') == 'XII RPL 2' ? 'selected' : '' }}>XII RPL 2</option>
                        <option value="X TKRO 1" {{ old('kelas') == 'X TKRO 1' ? 'selected' : '' }}>X TKRO 1</option>
                        <option value="X TKRO 2" {{ old('kelas') == 'X TKRO 2' ? 'selected' : '' }}>X TKRO 2</option>
                        <option value="XI TKRO 1" {{ old('kelas') == 'XI TKRO 1' ? 'selected' : '' }}>XI TKRO 1</option>
                        <option value="XI TKRO 2" {{ old('kelas') == 'XI TKRO 2' ? 'selected' : '' }}>XI TKRO 2</option>
                        <option value="XII TKRO 1" {{ old('kelas') == 'XII TKRO 1' ? 'selected' : '' }}>XII TKRO 1</option>
                        <option value="XII TKRO 2" {{ old('kelas') == 'XII TKRO 2' ? 'selected' : '' }}>XII TKRO 2</option>
                    </select>
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-phone mr-2 text-blue-600"></i>Nomor Telepon <span class="text-gray-500 text-sm">(Opsional)</span>
                    </label>
                    <input type="text" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror" 
                           placeholder="08xxxxxxxxxx">
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
                               placeholder="Minimal 8 karakter"
                               required>
                        <button type="button" 
                                onclick="togglePassword('password', 'toggle-icon-1')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-eye" id="toggle-icon-1"></i>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-lock mr-2 text-blue-600"></i>Konfirmasi Password
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Ulangi password"
                               required>
                        <button type="button" 
                                onclick="togglePassword('password_confirmation', 'toggle-icon-2')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-eye" id="toggle-icon-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar Sekarang
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                        Login di sini
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
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
