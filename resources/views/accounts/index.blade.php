@extends('layouts.app')

@section('title', 'Cuentas')
@section('header', 'Gestión de Cuentas')

@section('content')
<!-- Stats Overview -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
    <div class="glass-effect backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/30 card-hover group relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-indigo-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Balance Total</p>
                <p class="text-2xl font-bold text-blue-600 animate-bounce-in">{{ number_format($totalBalance, 2) }} EUR</p>
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
                    Todas las cuentas
                </p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-wallet text-white text-xl group-hover:animate-bounce"></i>
            </div>
        </div>
    </div>
    
    <div class="glass-effect backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/30 card-hover group relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-emerald-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Dinero Prestado</p>
                <p class="text-2xl font-bold text-green-600 animate-bounce-in">{{ number_format($totalLent, 2) }} EUR</p>
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                    Por cobrar
                </p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-hand-holding-usd text-white text-xl group-hover:animate-pulse"></i>
            </div>
        </div>
    </div>
    
    <div class="glass-effect backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/30 card-hover group relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-red-500/10 to-pink-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Deudas Pendientes</p>
                <p class="text-2xl font-bold text-red-600 animate-bounce-in">{{ number_format($totalBorrowed, 2) }} EUR</p>
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                    Por pagar
                </p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-credit-card text-white text-xl group-hover:animate-pulse"></i>
            </div>
        </div>
    </div>
    
    <div class="glass-effect backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/30 card-hover group relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-{{ $overdueLoans > 0 ? 'red' : 'gray' }}-500/10 to-{{ $overdueLoans > 0 ? 'pink' : 'slate' }}-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Préstamos Vencidos</p>
                <p class="text-2xl font-bold {{ $overdueLoans > 0 ? 'text-red-600' : 'text-gray-600' }} animate-bounce-in">{{ $overdueLoans }}</p>
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <span class="w-2 h-2 bg-{{ $overdueLoans > 0 ? 'red' : 'gray' }}-500 rounded-full mr-2 animate-pulse"></span>
                    {{ $overdueLoans > 0 ? 'Requieren atención' : 'Todo al día' }}
                </p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-{{ $overdueLoans > 0 ? 'red' : 'gray' }}-500 to-{{ $overdueLoans > 0 ? 'pink' : 'slate' }}-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-exclamation-triangle text-white text-xl {{ $overdueLoans > 0 ? 'group-hover:animate-bounce' : 'group-hover:animate-pulse' }}"></i>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <a href="{{ route('accounts.create') }}" class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white px-6 py-4 rounded-2xl hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 transition-all duration-500 shadow-2xl hover:shadow-3xl group relative overflow-hidden flex items-center justify-center">
        <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center">
            <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center mr-3 group-hover:rotate-180 transition-transform duration-500">
                <i class="fas fa-plus"></i>
            </div>
            <span class="font-bold">Nueva Cuenta</span>
        </div>
    </a>
    <a href="{{ route('transfers.create') }}" class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 text-white px-6 py-4 rounded-2xl hover:from-green-700 hover:via-emerald-700 hover:to-teal-700 transition-all duration-500 shadow-2xl hover:shadow-3xl group relative overflow-hidden flex items-center justify-center">
        <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center">
            <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center mr-3 group-hover:rotate-180 transition-transform duration-500">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <span class="font-bold">Transferir</span>
        </div>
    </a>
    <a href="{{ route('loans.create') }}" class="bg-gradient-to-r from-purple-600 via-pink-600 to-rose-600 text-white px-6 py-4 rounded-2xl hover:from-purple-700 hover:via-pink-700 hover:to-rose-700 transition-all duration-500 shadow-2xl hover:shadow-3xl group relative overflow-hidden flex items-center justify-center">
        <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center">
            <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center mr-3 group-hover:rotate-180 transition-transform duration-500">
                <i class="fas fa-handshake"></i>
            </div>
            <span class="font-bold">Préstamo</span>
        </div>
    </a>
    <a href="{{ route('loans.index') }}" class="bg-gradient-to-r from-orange-600 via-red-600 to-pink-600 text-white px-6 py-4 rounded-2xl hover:from-orange-700 hover:via-red-700 hover:to-pink-700 transition-all duration-500 shadow-2xl hover:shadow-3xl group relative overflow-hidden flex items-center justify-center">
        <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center">
            <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center mr-3 group-hover:rotate-180 transition-transform duration-500">
                <i class="fas fa-list"></i>
            </div>
            <span class="font-bold">Ver Préstamos</span>
        </div>
    </a>
</div>

<!-- Accounts and Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Accounts List -->
    <div class="lg:col-span-2">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-wallet text-white text-sm"></i>
                </div>
                Mis Cuentas
                <span class="ml-3 px-3 py-1 bg-gradient-to-r from-blue-500/20 to-indigo-600/20 text-blue-600 rounded-full text-sm font-medium">
                    {{ $totalAccounts }}
                </span>
            </h3>
        </div>
        
        @if($accounts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($accounts as $account)
                    @php
                        $typeConfig = [
                            'bank' => ['from' => 'blue', 'to' => 'indigo', 'icon' => 'fa-university', 'label' => 'Cuenta Bancaria'],
                            'savings' => ['from' => 'green', 'to' => 'emerald', 'icon' => 'fa-piggy-bank', 'label' => 'Cuenta de Ahorros'],
                            'investment' => ['from' => 'purple', 'to' => 'pink', 'icon' => 'fa-chart-line', 'label' => 'Cuenta de Inversión'],
                            'crypto' => ['from' => 'yellow', 'to' => 'orange', 'icon' => 'fa-bitcoin', 'label' => 'Criptomonedas'],
                            'cash' => ['from' => 'emerald', 'to' => 'green', 'icon' => 'fa-money-bill', 'label' => 'Efectivo'],
                            'credit_card' => ['from' => 'red', 'to' => 'pink', 'icon' => 'fa-credit-card', 'label' => 'Tarjeta de Crédito'],
                            'paypal' => ['from' => 'blue', 'to' => 'indigo', 'icon' => 'fa-paypal', 'label' => 'PayPal'],
                            'business' => ['from' => 'gray', 'to' => 'slate', 'icon' => 'fa-building', 'label' => 'Cuenta Empresarial']
                        ];
                        $config = $typeConfig[$account->type] ?? ['from' => 'gray', 'to' => 'slate', 'icon' => 'fa-wallet', 'label' => 'Otra Cuenta'];
                    @endphp
                    <div class="glass-effect backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 overflow-hidden card-hover group relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-{{ $config['from'] }}-500/5 to-{{ $config['to'] }}-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="p-6 relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="w-14 h-14 bg-gradient-to-br from-{{ $config['from'] }}-500 to-{{ $config['to'] }}-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas {{ $config['icon'] }} text-white text-xl group-hover:animate-pulse"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-lg group-hover:text-gray-900 transition-colors">{{ $account->name }}</h4>
                                        <p class="text-sm text-gray-600 flex items-center mt-1">
                                            <span class="w-2 h-2 bg-{{ $config['from'] }}-500 rounded-full mr-2"></span>
                                            {{ $config['label'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('accounts.edit', $account) }}" class="glass-effect backdrop-blur-xl p-2 rounded-xl text-gray-600 hover:text-blue-600 hover:bg-blue-500/20 transition-all duration-300 border border-white/30">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('accounts.destroy', $account) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="glass-effect backdrop-blur-xl p-2 rounded-xl text-gray-600 hover:text-red-600 hover:bg-red-500/20 transition-all duration-300 border border-white/30" onclick="return confirm('¿Estás seguro?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="glass-effect backdrop-blur-xl rounded-xl p-4 border border-white/30">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-coins mr-2"></i>
                                        Balance
                                    </span>
                                    <span class="text-2xl font-bold {{ $account->balance >= 0 ? 'text-gray-800' : 'text-red-600' }} animate-bounce-in">{{ $account->currency }} {{ number_format($account->balance, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm text-gray-600 mb-4">
                                    <span class="flex items-center">
                                        <i class="fas fa-exchange-alt mr-2"></i>
                                        Transacciones
                                    </span>
                                    <span class="px-2 py-1 bg-gradient-to-r from-gray-500/20 to-slate-600/20 rounded-full font-medium">{{ $account->transactions_count }}</span>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <a href="{{ route('transactions.index', ['account' => $account->id]) }}" class="flex-1 text-center glass-effect backdrop-blur-xl text-gray-700 py-2 px-3 rounded-xl text-sm hover:bg-gradient-to-r hover:from-gray-500/80 hover:to-slate-600/80 hover:text-white transition-all duration-300 border border-white/30">
                                        Transacciones
                                    </a>
                                    <a href="{{ route('transfers.create', ['from' => $account->id]) }}" class="flex-1 text-center glass-effect backdrop-blur-xl text-blue-700 py-2 px-3 rounded-xl text-sm hover:bg-gradient-to-r hover:from-blue-500/80 hover:to-indigo-600/80 hover:text-white transition-all duration-300 border border-white/30">
                                        Transferir
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="glass-effect backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-12 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-600/5"></div>
                <div class="relative z-10">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg animate-float">
                        <i class="fas fa-wallet text-white text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-3">No tienes cuentas registradas</h4>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">Crea tu primera cuenta para empezar a gestionar tus finanzas de manera inteligente</p>
                    <a href="{{ route('accounts.create') }}" class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white px-8 py-4 rounded-2xl hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 transition-all duration-500 shadow-2xl hover:shadow-3xl group relative overflow-hidden inline-flex items-center">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 flex items-center">
                            <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center mr-3 group-hover:rotate-180 transition-transform duration-500">
                                <i class="fas fa-plus"></i>
                            </div>
                            <span class="font-bold">Crear Primera Cuenta</span>
                        </div>
                    </a>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Recent Activity Sidebar -->
    <div class="space-y-6">
        <!-- Recent Transfers -->
        <div class="glass-effect backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-emerald-600/5"></div>
            <div class="p-6 border-b border-white/20 relative z-10">
                <div class="flex justify-between items-center">
                    <h4 class="font-bold text-gray-800 flex items-center">
                        <div class="w-6 h-6 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-2">
                            <i class="fas fa-exchange-alt text-white text-xs"></i>
                        </div>
                        Transferencias Recientes
                    </h4>
                    <a href="{{ route('transfers.index') }}" class="glass-effect backdrop-blur-xl px-3 py-1 rounded-xl text-blue-600 hover:text-white hover:bg-gradient-to-r hover:from-blue-500/80 hover:to-indigo-600/80 text-sm transition-all duration-300 border border-white/30">Ver todas</a>
                </div>
            </div>
            <div class="p-6">
                @if($recentTransfers->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentTransfers as $transfer)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-exchange-alt text-green-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $transfer->fromAccount->name }}</p>
                                        <p class="text-xs text-gray-600">a {{ $transfer->toAccount->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $transfer->transfer_date->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                                <p class="text-sm font-semibold text-gray-800">{{ number_format($transfer->amount, 2) }} EUR</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm text-center py-4">No hay transferencias recientes</p>
                @endif
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="glass-effect backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-pink-600/5"></div>
            <div class="p-6 border-b border-white/20 relative z-10">
                <h4 class="font-bold text-gray-800 flex items-center">
                    <div class="w-6 h-6 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-2">
                        <i class="fas fa-bolt text-white text-xs"></i>
                    </div>
                    Acciones Rápidas
                </h4>
            </div>
            <div class="p-6 space-y-3 relative z-10">
                <a href="{{ route('transactions.create') }}" class="w-full glass-effect backdrop-blur-xl text-blue-700 py-3 px-4 rounded-xl hover:bg-gradient-to-r hover:from-blue-500/80 hover:to-indigo-600/80 hover:text-white flex items-center transition-all duration-300 border border-white/30 group">
                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3 group-hover:bg-white/20 transition-colors">
                        <i class="fas fa-plus"></i>
                    </div>
                    <span class="font-medium">Nueva Transacción</span>
                </a>
                <a href="{{ route('transfers.create') }}" class="w-full glass-effect backdrop-blur-xl text-green-700 py-3 px-4 rounded-xl hover:bg-gradient-to-r hover:from-green-500/80 hover:to-emerald-600/80 hover:text-white flex items-center transition-all duration-300 border border-white/30 group">
                    <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center mr-3 group-hover:bg-white/20 transition-colors">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <span class="font-medium">Transferir Dinero</span>
                </a>
                <a href="{{ route('loans.create') }}" class="w-full glass-effect backdrop-blur-xl text-purple-700 py-3 px-4 rounded-xl hover:bg-gradient-to-r hover:from-purple-500/80 hover:to-pink-600/80 hover:text-white flex items-center transition-all duration-300 border border-white/30 group">
                    <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center mr-3 group-hover:bg-white/20 transition-colors">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <span class="font-medium">Registrar Préstamo</span>
                </a>
                <a href="{{ route('reports.index') }}" class="w-full glass-effect backdrop-blur-xl text-orange-700 py-3 px-4 rounded-xl hover:bg-gradient-to-r hover:from-orange-500/80 hover:to-red-600/80 hover:text-white flex items-center transition-all duration-300 border border-white/30 group">
                    <div class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center mr-3 group-hover:bg-white/20 transition-colors">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <span class="font-medium">Ver Reportes</span>
                </a>
            </div>
        </div>
    </div>
</div>
<style>
.glass-effect {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.18);
}

.card-hover {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.card-hover:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.animate-bounce-in {
    animation: bounceIn 0.6s ease-out;
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

@keyframes bounceIn {
    0% { opacity: 0; transform: scale(0.3); }
    50% { opacity: 1; transform: scale(1.05); }
    100% { opacity: 1; transform: scale(1); }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.account-card {
    animation: slideInUp 0.5s ease-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection