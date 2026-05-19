<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ETicket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/green.css') }}">
    <style>
        .password-strength {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        .strength-weak { background-color: #ef4444; }
        .strength-medium { background-color: #f59e0b; }
        .strength-strong { background-color: #3b82f6; }
    </style>
</head>
<body class="min-h-screen bg-gradient flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white bg-opacity-20 rounded-full mb-4">
                <i class="bi bi-person-plus text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">SITEPAT</h1>
            <p class="text-white text-opacity-80">SISTEM TIKET PELAYANAN TERPADU</p>
        </div>

        <!-- Register Form -->
        <div class="glass-effect rounded-2xl p-8 shadow-2xl">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <!-- Name Field -->
                <div class="mb-4">
                    <label for="name" class="block text-white text-sm font-medium mb-2">
                        <i class="bi bi-person mr-2"></i>Full Name
                    </label>
                    <input 
                        id="name" 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}"
                        class="w-full px-4 py-3 bg-white bg-opacity-10 border border-white border-opacity-30 rounded-lg text-white placeholder-white placeholder-opacity-60 focus:outline-none focus:border-blue-400 transition-colors input-focus"
                        placeholder="Enter your full name"
                        required 
                        autofocus 
                        autocomplete="name"
                    >
                    @error('name')
                        <p class="mt-2 text-red-300 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Field -->
                <div class="mb-4">
                    <label for="phone" class="block text-white text-sm font-medium mb-2">
                        <i class="bi bi-telephone mr-2"></i>Nomor HP / WhatsApp
                    </label>
                    <input
                        id="phone"
                        type="tel"
                        name="phone"
                        value="{{ old('phone') }}"
                        class="w-full px-4 py-3 bg-white bg-opacity-10 border border-white border-opacity-30 rounded-lg text-white placeholder-white placeholder-opacity-60 focus:outline-none focus:border-blue-400 transition-colors input-focus"
                        placeholder="08xxxxxxxx atau 628xxxxxxxx"
                        required
                        autocomplete="tel"
                    >
                    @error('phone')
                        <p class="mt-2 text-red-300 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="mb-4">
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
                        autocomplete="username"
                    >
                    @error('email')
                        <p class="mt-2 text-red-300 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="mb-4">
                    <label for="password" class="block text-white text-sm font-medium mb-2">
                        <i class="bi bi-lock mr-2"></i>Password
                    </label>
                    <div class="relative">
                        <input 
                            id="password" 
                            type="password" 
                            name="password"
                            class="w-full px-4 py-3 bg-white bg-opacity-10 border border-white border-opacity-30 rounded-lg text-white placeholder-white placeholder-opacity-60 focus:outline-none focus:border-blue-400 transition-colors input-focus pr-12"
                            placeholder="Create a password"
                            required 
                            autocomplete="new-password"
                            oninput="checkPasswordStrength(this.value)"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('password')"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white text-opacity-60 hover:text-opacity-100 transition-colors"
                        >
                            <i id="password-icon" class="bi bi-eye"></i>
                        </button>
                    </div>
                    <!-- Password Strength Indicator -->
                    <div class="mt-2">
                        <div class="flex space-x-1">
                            <div id="strength-1" class="password-strength flex-1 bg-gray-600"></div>
                            <div id="strength-2" class="password-strength flex-1 bg-gray-600"></div>
                            <div id="strength-3" class="password-strength flex-1 bg-gray-600"></div>
                            <div id="strength-4" class="password-strength flex-1 bg-gray-600"></div>
                        </div>
                        <p id="strength-text" class="mt-1 text-xs text-white text-opacity-60"></p>
                    </div>
                    @error('password')
                        <p class="mt-2 text-red-300 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-white text-sm font-medium mb-2">
                        <i class="bi bi-lock mr-2"></i>Confirm Password
                    </label>
                    <div class="relative">
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation"
                            class="w-full px-4 py-3 bg-white bg-opacity-10 border border-white border-opacity-30 rounded-lg text-white placeholder-white placeholder-opacity-60 focus:outline-none focus:border-blue-400 transition-colors input-focus pr-12"
                            placeholder="Confirm your password"
                            required 
                            autocomplete="new-password"
                            oninput="checkPasswordMatch()"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('password_confirmation')"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white text-opacity-60 hover:text-opacity-100 transition-colors"
                        >
                            <i id="password_confirmation-icon" class="bi bi-eye"></i>
                        </button>
                    </div>
                    <p id="password-match" class="mt-1 text-xs"></p>
                    @error('password_confirmation')
                        <p class="mt-2 text-red-300 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms and Conditions -->
                <div class="mb-6">
                    <label class="flex items-start text-white text-opacity-80">
                        <input 
                            type="checkbox" 
                            id="terms"
                            class="w-4 h-4 text-blue-600 bg-white bg-opacity-10 border-white border-opacity-30 rounded focus:ring-blue-500 focus:ring-2 mt-1"
                            required
                        >
                        <span class="ml-2 text-sm">
                            I agree to the 
                            <a href="#" class="text-blue-300 hover:text-blue-200 underline">Terms of Service</a> 
                            and 
                            <a href="#" class="text-blue-300 hover:text-blue-200 underline">Privacy Policy</a>
                        </span>
                    </label>
                </div>

                <!-- Register Button -->
                <button 
                    type="submit"
                    class="w-full bg-white bg-opacity-20 hover:bg-opacity-30 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-30"
                >
                    <i class="bi bi-person-plus mr-2"></i>Create Account
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-white text-opacity-80 text-sm">
                    Already have an account? 
                    <a 
                        href="{{ route('login') }}" 
                        class="text-blue-300 hover:text-blue-200 font-medium transition-colors"
                    >
                        Sign in here
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-white text-opacity-60 text-sm">
                © 2024 ETicket. All rights reserved.
            </p>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const passwordIcon = document.getElementById(fieldId + '-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.className = 'bi bi-eye-slash';
            } else {
                passwordInput.type = 'password';
                passwordIcon.className = 'bi bi-eye';
            }
        }

        function checkPasswordStrength(password) {
            const strengthBars = [
                document.getElementById('strength-1'),
                document.getElementById('strength-2'),
                document.getElementById('strength-3'),
                document.getElementById('strength-4')
            ];
            const strengthText = document.getElementById('strength-text');
            
            let strength = 0;
            let strengthClass = '';
            let strengthLabel = '';
            
            // Reset bars
            strengthBars.forEach(bar => {
                bar.className = 'password-strength flex-1 bg-gray-600';
            });
            
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            // Update visual strength indicator
            for (let i = 0; i < Math.min(strength, 4); i++) {
                if (strength <= 2) {
                    strengthClass = 'strength-weak';
                    strengthLabel = 'Weak';
                } else if (strength <= 3) {
                    strengthClass = 'strength-medium';
                    strengthLabel = 'Medium';
                } else {
                    strengthClass = 'strength-strong';
                    strengthLabel = 'Strong';
                }
                strengthBars[i].classList.add(strengthClass);
            }
            
            strengthText.textContent = password.length > 0 ? `Password strength: ${strengthLabel}` : '';
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const matchText = document.getElementById('password-match');
            
            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    matchText.textContent = '✓ Passwords match';
                    matchText.className = 'mt-1 text-xs text-blue-300';
                } else {
                    matchText.textContent = '✗ Passwords do not match';
                    matchText.className = 'mt-1 text-xs text-red-300';
                }
            } else {
                matchText.textContent = '';
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
