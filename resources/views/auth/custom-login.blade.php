<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ETicket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/green.css') }}">
</head>
<body class="min-h-screen bg-gradient flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white bg-opacity-20 rounded-full mb-4">
                <i class="bi bi-ticket-perforated text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">SITEPAT</h1>
            <p class="text-white text-opacity-80">SISTEM TIKET PELAYANAN TERPADU</p>
        </div>

        <!-- Login Form -->
        <div class="glass-effect rounded-2xl p-8 shadow-2xl">
            @if (session('status'))
                <div class="mb-4 p-4 bg-blue-500 bg-opacity-20 text-blue-100 rounded-lg border border-blue-500 border-opacity-30">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email Field -->
                <div class="mb-6">
                    <label for="email" class="block text-white text-sm font-medium mb-2">
                        <i class="bi bi-envelope mr-2"></i>Email Address
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 bg-white bg-opacity-10 border border-white border-opacity-30 rounded-lg text-white placeholder-white placeholder-opacity-60 focus:outline-none focus:border-blue-400 transition-colors input-focus"
                        placeholder="Enter your email"
                        required 
                        autofocus 
                        autocomplete="username"
                    >
                    @error('email')
                        <p class="mt-2 text-red-300 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="mb-6">
                    <label for="password" class="block text-white text-sm font-medium mb-2">
                        <i class="bi bi-lock mr-2"></i>Password
                    </label>
                    <div class="relative">
                        <input 
                            id="password" 
                            type="password" 
                            name="password"
                            class="w-full px-4 py-3 bg-white bg-opacity-10 border border-white border-opacity-30 rounded-lg text-white placeholder-white placeholder-opacity-60 focus:outline-none focus:border-blue-400 transition-colors input-focus pr-12"
                            placeholder="Enter your password"
                            required 
                            autocomplete="current-password"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword()"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white text-opacity-60 hover:text-opacity-100 transition-colors"
                        >
                            <i id="password-icon" class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-red-300 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center text-white text-opacity-80">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            class="w-4 h-4 text-blue-600 bg-white bg-opacity-10 border-white border-opacity-30 rounded focus:ring-blue-500 focus:ring-2"
                        >
                        <span class="ml-2 text-sm">Remember me</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a 
                            href="{{ route('password.request') }}" 
                            class="text-blue-300 hover:text-blue-200 text-sm transition-colors"
                        >
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <button 
                    type="submit"
                    class="w-full bg-white bg-opacity-20 hover:bg-opacity-30 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-30"
                >
                    <i class="bi bi-box-arrow-in-right mr-2"></i>Sign In
                </button>
            </form>

            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p class="text-white text-opacity-80 text-sm">
                    Don't have an account? 
                    <a 
                        href="{{ route('register') }}" 
                        class="text-blue-300 hover:text-blue-200 font-medium transition-colors"
                    >
                        Sign up here
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-white text-opacity-60 text-sm">
                © 2025 SITEPAT. All rights reserved.
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.className = 'bi bi-eye-slash';
            } else {
                passwordInput.type = 'password';
                passwordIcon.className = 'bi bi-eye';
            }
        }

        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('scale-105');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('scale-105');
                });
            });
        });
    </script>
</body>
</html>
