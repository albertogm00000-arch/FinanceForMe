<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FinanceForMe')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif']
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'bounce-in': 'bounceIn 0.6s ease-out',
                        'pulse-slow': 'pulse 3s infinite',
                        'float': 'float 3s ease-in-out infinite'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        bounceIn: {
                            '0%': { opacity: '0', transform: 'scale(0.3)' },
                            '50%': { opacity: '1', transform: 'scale(1.05)' },
                            '100%': { opacity: '1', transform: 'scale(1)' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' }
                        }
                    },
                    backdropBlur: {
                        'xs': '2px'
                    }
                }
            }
        }
    </script>
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .btn-glow {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
        }
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 min-h-screen font-sans">
    <!-- Mobile menu button -->
    <div class="lg:hidden fixed top-6 left-6 z-[60]">
        <button id="mobile-menu-btn" class="group glass-effect backdrop-blur-xl text-gray-800 p-4 rounded-2xl shadow-2xl hover:shadow-3xl transition-all duration-300 border border-white/30">
            <div class="relative w-6 h-6">
                <span class="hamburger-line absolute top-0 left-0 w-full h-0.5 bg-gray-800 rounded-full transition-all duration-300 group-hover:bg-blue-600"></span>
                <span class="hamburger-line absolute top-2.5 left-0 w-full h-0.5 bg-gray-800 rounded-full transition-all duration-300 group-hover:bg-blue-600"></span>
                <span class="hamburger-line absolute top-5 left-0 w-full h-0.5 bg-gray-800 rounded-full transition-all duration-300 group-hover:bg-blue-600"></span>
            </div>
        </button>
    </div>

    <!-- Sidebar -->
    <div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 glass-effect backdrop-blur-xl transform -translate-x-full lg:translate-x-0 transition-all duration-500 ease-out flex flex-col">
        <div class="p-6 border-b border-white/20 flex-shrink-0">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center animate-float">
                    <i class="fas fa-chart-line text-white text-lg"></i>
                </div>
                <h1 class="text-xl font-bold text-gradient">FinanceForMe</h1>
            </div>
        </div>
        <nav class="flex-1 overflow-y-auto mt-8 px-4 space-y-2 pb-40">
            <!-- Dashboard -->
            <div class="menu-item-wrapper" style="animation-delay: 0.1s">
                <a href="{{ route('dashboard') }}" class="menu-item group flex items-center px-5 py-4 text-gray-700 hover:text-white rounded-2xl transition-all duration-500 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-500 via-purple-500 to-indigo-600 text-white shadow-2xl scale-105' : 'hover:bg-gradient-to-r hover:from-blue-500/80 hover:via-purple-500/80 hover:to-indigo-600/80 hover:scale-105' }} relative overflow-hidden">
                    @if(request()->routeIs('dashboard'))
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 to-purple-400/20 animate-pulse"></div>
                    @endif
                    <div class="relative z-10 flex items-center w-full">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-4 {{ request()->routeIs('dashboard') ? 'bg-white/25 shadow-lg' : 'group-hover:bg-white/15' }} transition-all duration-300 group-hover:rotate-12">
                            <i class="fas fa-chart-line text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <span class="font-semibold text-base">Dashboard</span>
                            <p class="text-xs opacity-75 mt-0.5">Vista general</p>
                        </div>
                        @if(request()->routeIs('dashboard'))
                            <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                        @endif
                    </div>
                </a>
            </div>

            <!-- Transactions -->
            <div class="menu-item-wrapper" style="animation-delay: 0.2s">
                <a href="{{ route('transactions.index') }}" class="menu-item group flex items-center px-5 py-4 text-gray-700 hover:text-white rounded-2xl transition-all duration-500 {{ request()->routeIs('transactions.*') ? 'bg-gradient-to-r from-green-500 via-emerald-500 to-teal-600 text-white shadow-2xl scale-105' : 'hover:bg-gradient-to-r hover:from-green-500/80 hover:via-emerald-500/80 hover:to-teal-600/80 hover:scale-105' }} relative overflow-hidden">
                    @if(request()->routeIs('transactions.*'))
                        <div class="absolute inset-0 bg-gradient-to-r from-green-400/20 to-teal-400/20 animate-pulse"></div>
                    @endif
                    <div class="relative z-10 flex items-center w-full">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-4 {{ request()->routeIs('transactions.*') ? 'bg-white/25 shadow-lg' : 'group-hover:bg-white/15' }} transition-all duration-300 group-hover:rotate-12">
                            <i class="fas fa-exchange-alt text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <span class="font-semibold text-base">Transacciones</span>
                            <p class="text-xs opacity-75 mt-0.5">Ingresos y gastos</p>
                        </div>
                        @if(request()->routeIs('transactions.*'))
                            <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                        @endif
                    </div>
                </a>
            </div>

            <!-- Accounts -->
            <div class="menu-item-wrapper" style="animation-delay: 0.3s">
                <a href="{{ route('accounts.index') }}" class="menu-item group flex items-center px-5 py-4 text-gray-700 hover:text-white rounded-2xl transition-all duration-500 {{ request()->routeIs('accounts.*') ? 'bg-gradient-to-r from-indigo-500 via-blue-500 to-cyan-600 text-white shadow-2xl scale-105' : 'hover:bg-gradient-to-r hover:from-indigo-500/80 hover:via-blue-500/80 hover:to-cyan-600/80 hover:scale-105' }} relative overflow-hidden">
                    @if(request()->routeIs('accounts.*'))
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-400/20 to-cyan-400/20 animate-pulse"></div>
                    @endif
                    <div class="relative z-10 flex items-center w-full">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-4 {{ request()->routeIs('accounts.*') ? 'bg-white/25 shadow-lg' : 'group-hover:bg-white/15' }} transition-all duration-300 group-hover:rotate-12">
                            <i class="fas fa-wallet text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <span class="font-semibold text-base">Cuentas</span>
                            <p class="text-xs opacity-75 mt-0.5">Gestión de cuentas</p>
                        </div>
                        @if(request()->routeIs('accounts.*'))
                            <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                        @endif
                    </div>
                </a>
            </div>

            <!-- Loans -->
            <div class="menu-item-wrapper" style="animation-delay: 0.4s">
                <a href="{{ route('loans.index') }}" class="menu-item group flex items-center px-5 py-4 text-gray-700 hover:text-white rounded-2xl transition-all duration-500 {{ request()->routeIs('loans.*') ? 'bg-gradient-to-r from-purple-500 via-pink-500 to-rose-600 text-white shadow-2xl scale-105' : 'hover:bg-gradient-to-r hover:from-purple-500/80 hover:via-pink-500/80 hover:to-rose-600/80 hover:scale-105' }} relative overflow-hidden">
                    @if(request()->routeIs('loans.*'))
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-400/20 to-rose-400/20 animate-pulse"></div>
                    @endif
                    <div class="relative z-10 flex items-center w-full">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-4 {{ request()->routeIs('loans.*') ? 'bg-white/25 shadow-lg' : 'group-hover:bg-white/15' }} transition-all duration-300 group-hover:rotate-12">
                            <i class="fas fa-handshake text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <span class="font-semibold text-base">Préstamos</span>
                            <p class="text-xs opacity-75 mt-0.5">Dinero prestado</p>
                        </div>
                        @if(request()->routeIs('loans.*'))
                            <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                        @endif
                    </div>
                </a>
            </div>

            <!-- Transfers -->
            <div class="menu-item-wrapper" style="animation-delay: 0.5s">
                <a href="{{ route('transfers.index') }}" class="menu-item group flex items-center px-5 py-4 text-gray-700 hover:text-white rounded-2xl transition-all duration-500 {{ request()->routeIs('transfers.*') ? 'bg-gradient-to-r from-orange-500 via-red-500 to-pink-600 text-white shadow-2xl scale-105' : 'hover:bg-gradient-to-r hover:from-orange-500/80 hover:via-red-500/80 hover:to-pink-600/80 hover:scale-105' }} relative overflow-hidden">
                    @if(request()->routeIs('transfers.*'))
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-400/20 to-pink-400/20 animate-pulse"></div>
                    @endif
                    <div class="relative z-10 flex items-center w-full">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-4 {{ request()->routeIs('transfers.*') ? 'bg-white/25 shadow-lg' : 'group-hover:bg-white/15' }} transition-all duration-300 group-hover:rotate-12">
                            <i class="fas fa-arrow-right-arrow-left text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <span class="font-semibold text-base">Transferencias</span>
                            <p class="text-xs opacity-75 mt-0.5">Entre cuentas</p>
                        </div>
                        @if(request()->routeIs('transfers.*'))
                            <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                        @endif
                    </div>
                </a>
            </div>

            <!-- Reports -->
            <div class="menu-item-wrapper" style="animation-delay: 0.6s">
                <a href="{{ route('reports.index') }}" class="menu-item group flex items-center px-5 py-4 text-gray-700 hover:text-white rounded-2xl transition-all duration-500 {{ request()->routeIs('reports.*') ? 'bg-gradient-to-r from-teal-500 via-cyan-500 to-blue-600 text-white shadow-2xl scale-105' : 'hover:bg-gradient-to-r hover:from-teal-500/80 hover:via-cyan-500/80 hover:to-blue-600/80 hover:scale-105' }} relative overflow-hidden">
                    @if(request()->routeIs('reports.*'))
                        <div class="absolute inset-0 bg-gradient-to-r from-teal-400/20 to-blue-400/20 animate-pulse"></div>
                    @endif
                    <div class="relative z-10 flex items-center w-full">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-4 {{ request()->routeIs('reports.*') ? 'bg-white/25 shadow-lg' : 'group-hover:bg-white/15' }} transition-all duration-300 group-hover:rotate-12">
                            <i class="fas fa-chart-pie text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <span class="font-semibold text-base">Reportes</span>
                            <p class="text-xs opacity-75 mt-0.5">Análisis financiero</p>
                        </div>
                        @if(request()->routeIs('reports.*'))
                            <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                        @endif
                    </div>
                </a>
            </div>
        </nav>
        <!-- Bottom Section -->
        <div class="flex-shrink-0 p-6 space-y-4 border-t border-white/20 bg-gradient-to-t from-white/10 to-transparent">
            <!-- Quick Stats -->
            <div class="glass-effect rounded-2xl p-4 border border-white/20">
                <div class="text-center">
                    <p class="text-xs text-gray-600 mb-1">Balance Total</p>
                    <p class="text-lg font-bold text-gradient">{{ number_format(auth()->user()->accounts?->sum('balance') ?? 0, 0) }} EUR</p>
                </div>
            </div>
            
            <!-- CTA Button -->
            <a href="{{ route('transactions.create') }}" class="block w-full bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 text-white py-4 px-4 rounded-2xl hover:from-blue-700 hover:via-purple-700 hover:to-indigo-700 transition-all duration-500 shadow-2xl hover:shadow-3xl group relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10 flex items-center justify-center">
                    <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center mr-3 group-hover:rotate-180 transition-transform duration-500">
                        <i class="fas fa-plus"></i>
                    </div>
                    <span class="font-bold text-lg">Nueva Transacción</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 hidden lg:hidden transition-all duration-500"></div>

    <!-- Main content -->
    <div class="lg:ml-64 min-h-screen">
        <header class="glass-effect backdrop-blur-xl border-b border-white/20 px-4 sm:px-6 lg:px-8 py-6 relative z-10">
            <div class="flex items-center justify-between">
                <div class="ml-12 lg:ml-0">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gradient animate-fade-in">@yield('header', 'Dashboard')</h2>
                    <p class="text-sm text-gray-600 mt-1 animate-slide-up">{{ now()->format('l, F j, Y') }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden sm:flex items-center space-x-3">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">Bienvenido de vuelta</p>
                        </div>
                    </div>
                    <div class="relative group">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg group-hover:shadow-xl transition-all duration-300 cursor-pointer">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="absolute top-full right-0 mt-2 w-48 bg-white/95 backdrop-blur-xl rounded-xl shadow-2xl border border-white/30 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[60]">
                            <div class="p-4">
                                <p class="font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-sm text-gray-700">{{ auth()->user()->email }}</p>
                                <hr class="my-3 border-gray-200">
                                <a href="#" class="block text-sm text-gray-800 hover:text-blue-600 py-2 px-2 rounded-lg hover:bg-blue-50 transition-colors">Configuración</a>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="block w-full text-left text-sm text-gray-800 hover:text-red-600 py-2 px-2 rounded-lg hover:bg-red-50 transition-colors">Cerrar Sesión</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-4 sm:p-6 lg:p-8">
            @if(session('success'))
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4 rounded-2xl mb-6 flex items-center shadow-lg animate-bounce-in">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-gradient-to-r from-red-500 to-pink-600 text-white px-6 py-4 rounded-2xl mb-6 flex items-center shadow-lg animate-bounce-in">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-exclamation-triangle text-sm"></i>
                    </div>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <div class="animate-fade-in">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        mobileMenuBtn.addEventListener('click', () => {
            const isOpen = !sidebar.classList.contains('-translate-x-full');
            const hamburgerLines = mobileMenuBtn.querySelectorAll('.hamburger-line');
            
            if (isOpen) {
                // Close menu
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                hamburgerLines[0].style.transform = 'rotate(0deg) translateY(0px)';
                hamburgerLines[1].style.opacity = '1';
                hamburgerLines[2].style.transform = 'rotate(0deg) translateY(0px)';
            } else {
                // Open menu
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                hamburgerLines[0].style.transform = 'rotate(45deg) translateY(10px)';
                hamburgerLines[1].style.opacity = '0';
                hamburgerLines[2].style.transform = 'rotate(-45deg) translateY(-10px)';
            }
        });

        overlay.addEventListener('click', () => {
            const hamburgerLines = mobileMenuBtn.querySelectorAll('.hamburger-line');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            hamburgerLines[0].style.transform = 'rotate(0deg) translateY(0px)';
            hamburgerLines[1].style.opacity = '1';
            hamburgerLines[2].style.transform = 'rotate(0deg) translateY(0px)';
        });

        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';

        // Add intersection observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, observerOptions);

        // Animate menu items on sidebar open
        const animateMenuItems = () => {
            const menuItems = document.querySelectorAll('.menu-item-wrapper');
            menuItems.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('animate-slide-up');
                }, index * 100);
            });
        };

        // Observe all cards and sections
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('.card-hover, .bg-white, .glass-effect');
            elements.forEach(el => observer.observe(el));
            
            // Add menu animation styles
            const style = document.createElement('style');
            style.textContent = `
                .menu-item-wrapper {
                    opacity: 0;
                    transform: translateX(-20px);
                    animation: slideInLeft 0.5s ease-out forwards;
                }
                @keyframes slideInLeft {
                    to {
                        opacity: 1;
                        transform: translateX(0);
                    }
                }
            `;
            document.head.appendChild(style);
        });

        // Add loading states
        window.addEventListener('beforeunload', () => {
            document.body.style.opacity = '0.7';
        });
    </script>
</body>
</html>