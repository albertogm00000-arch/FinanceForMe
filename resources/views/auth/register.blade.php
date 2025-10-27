<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - FinanceForMe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animate-float-delayed {
            animation: float 6s ease-in-out infinite 2s;
        }
        
        .animate-bounce-in {
            animation: bounceIn 0.8s ease-out;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        @keyframes bounceIn {
            0% { opacity: 0; transform: scale(0.3); }
            50% { opacity: 1; transform: scale(1.05); }
            100% { opacity: 1; transform: scale(1); }
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            border-color: #667eea;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Floating Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-20 w-32 h-32 bg-white/10 rounded-full animate-float"></div>
        <div class="absolute top-40 right-32 w-24 h-24 bg-white/5 rounded-full animate-float-delayed"></div>
        <div class="absolute bottom-32 left-40 w-40 h-40 bg-white/5 rounded-full animate-float"></div>
        <div class="absolute bottom-20 right-20 w-28 h-28 bg-white/10 rounded-full animate-float-delayed"></div>
    </div>

    <div class="w-full max-w-md animate-bounce-in">
        <!-- Logo Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 glass-effect rounded-2xl shadow-2xl mb-4">
                <i class="fas fa-chart-line text-3xl text-white"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">FinanceForMe</h1>
            <p class="text-white/80">Únete y gestiona tus finanzas</p>
        </div>

        <!-- Register Form -->
        <div class="glass-effect backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-8 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent"></div>
            <div class="relative z-10">
                <h2 class="text-2xl font-bold text-white mb-6 text-center">Crear Cuenta</h2>
                
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-white/90 mb-2">
                            <i class="fas fa-user mr-2"></i>Nombre Completo
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
                            class="w-full px-4 py-3 glass-effect backdrop-blur-xl rounded-xl border border-white/30 text-white placeholder-white/60 input-focus transition-all duration-300 focus:outline-none"
                            placeholder="Tu nombre completo"
                            required
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-white/90 mb-2">
                            <i class="fas fa-envelope mr-2"></i>Correo Electrónico
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 glass-effect backdrop-blur-xl rounded-xl border border-white/30 text-white placeholder-white/60 input-focus transition-all duration-300 focus:outline-none"
                            placeholder="tu@email.com"
                            required
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-white/90 mb-2">
                            <i class="fas fa-lock mr-2"></i>Contraseña
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password"
                                class="w-full px-4 py-3 glass-effect backdrop-blur-xl rounded-xl border border-white/30 text-white placeholder-white/60 input-focus transition-all duration-300 focus:outline-none pr-12"
                                placeholder="••••••••"
                                required
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword('password', 'password-icon')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white/60 hover:text-white transition-colors"
                            >
                                <i id="password-icon" class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-white/90 mb-2">
                            <i class="fas fa-lock mr-2"></i>Confirmar Contraseña
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation"
                                class="w-full px-4 py-3 glass-effect backdrop-blur-xl rounded-xl border border-white/30 text-white placeholder-white/60 input-focus transition-all duration-300 focus:outline-none pr-12"
                                placeholder="••••••••"
                                required
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword('password_confirmation', 'password-confirm-icon')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white/60 hover:text-white transition-colors"
                            >
                                <i id="password-confirm-icon" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Register Button -->
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center"
                    >
                        <i class="fas fa-user-plus mr-2"></i>
                        Crear Cuenta
                    </button>
                </form>

                <!-- Divider -->
                <div class="my-6 flex items-center">
                    <div class="flex-1 border-t border-white/20"></div>
                    <span class="px-4 text-white/60 text-sm">o</span>
                    <div class="flex-1 border-t border-white/20"></div>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-white/80">
                        ¿Ya tienes cuenta? 
                        <a href="{{ route('login') }}" class="text-white font-semibold hover:underline transition-all duration-300">
                            Inicia sesión aquí
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-white/60 text-sm">
                © 2024 FinanceForMe. Todos los derechos reservados.
            </p>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const passwordIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        // Add floating animation to form elements
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach((input, index) => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>