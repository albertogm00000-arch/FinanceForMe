@extends('layouts.app')

@section('title', 'Dashboard - FinanceForMe')
@section('header', 'Dashboard Financiero')

@section('content')
<!-- Quick Actions Bar -->
<div class="glass-effect rounded-2xl p-6 mb-8 animate-fade-in">
    <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ route('transactions.create') }}" class="group flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 px-6 rounded-xl hover:from-blue-700 hover:to-blue-800 flex items-center justify-center transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3 group-hover:rotate-12 transition-transform duration-300">
                <i class="fas fa-plus"></i>
            </div>
            <span class="font-semibold">Nueva Transacción</span>
        </a>
        <a href="{{ route('transfers.create') }}" class="group flex-1 bg-gradient-to-r from-green-600 to-emerald-700 text-white py-4 px-6 rounded-xl hover:from-green-700 hover:to-emerald-800 flex items-center justify-center transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3 group-hover:rotate-12 transition-transform duration-300">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <span class="font-semibold">Transferir</span>
        </a>
        <a href="{{ route('loans.create') }}" class="group flex-1 bg-gradient-to-r from-purple-600 to-pink-700 text-white py-4 px-6 rounded-xl hover:from-purple-700 hover:to-pink-800 flex items-center justify-center transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3 group-hover:rotate-12 transition-transform duration-300">
                <i class="fas fa-handshake"></i>
            </div>
            <span class="font-semibold">Préstamo</span>
        </a>
        <a href="{{ route('reports.index') }}" class="group flex-1 bg-gradient-to-r from-orange-600 to-red-700 text-white py-4 px-6 rounded-xl hover:from-orange-700 hover:to-red-800 flex items-center justify-center transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3 group-hover:rotate-12 transition-transform duration-300">
                <i class="fas fa-chart-bar"></i>
            </div>
            <span class="font-semibold">Reportes</span>
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="glass-effect p-6 rounded-2xl card-hover group animate-slide-up" style="animation-delay: 0.1s">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 group-hover:text-gray-700 transition-colors">Balance Total</p>
                <p class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">{{ number_format($totalBalance, 2) }} EUR</p>
                <p class="text-xs text-gray-500 mt-1">{{ $accounts->count() }} cuentas activas</p>
            </div>
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-110">
                <i class="fas fa-wallet text-white text-xl"></i>
            </div>
        </div>
        <div class="mt-4 h-1 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    </div>
    
    <div class="glass-effect p-6 rounded-2xl card-hover group animate-slide-up" style="animation-delay: 0.2s">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 group-hover:text-gray-700 transition-colors">Ingresos del Mes</p>
                <p class="text-3xl font-bold bg-gradient-to-r from-green-500 to-emerald-600 bg-clip-text text-transparent">{{ number_format($monthlyIncome, 2) }} EUR</p>
                <p class="text-xs text-gray-500 mt-1">+{{ number_format(($monthlyIncome / max($monthlyExpenses, 1)) * 100, 0) }}% vs gastos</p>
            </div>
            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-110">
                <i class="fas fa-arrow-up text-white text-xl"></i>
            </div>
        </div>
        <div class="mt-4 h-1 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    </div>
    
    <div class="glass-effect p-6 rounded-2xl card-hover group animate-slide-up" style="animation-delay: 0.3s">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 group-hover:text-gray-700 transition-colors">Gastos del Mes</p>
                <p class="text-3xl font-bold bg-gradient-to-r from-red-500 to-pink-600 bg-clip-text text-transparent">{{ number_format($monthlyExpenses, 2) }} EUR</p>
                <p class="text-xs text-gray-500 mt-1">{{ number_format($monthlyExpenses / max(now()->day, 1), 2) }} EUR/día</p>
            </div>
            <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-110">
                <i class="fas fa-arrow-down text-white text-xl"></i>
            </div>
        </div>
        <div class="mt-4 h-1 bg-gradient-to-r from-red-500 to-pink-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    </div>
    
    <div class="glass-effect p-6 rounded-2xl card-hover group animate-slide-up" style="animation-delay: 0.4s">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 group-hover:text-gray-700 transition-colors">Balance Neto</p>
                <p class="text-3xl font-bold bg-gradient-to-r {{ ($monthlyIncome - $monthlyExpenses) >= 0 ? 'from-green-500 to-emerald-600' : 'from-red-500 to-pink-600' }} bg-clip-text text-transparent">
                    {{ number_format($monthlyIncome - $monthlyExpenses, 2) }} EUR
                </p>
                <p class="text-xs text-gray-500 mt-1">{{ number_format(($monthlyIncome > 0 ? (($monthlyIncome - $monthlyExpenses) / $monthlyIncome) * 100 : 0), 1) }}% ahorro</p>
            </div>
            <div class="w-16 h-16 bg-gradient-to-br {{ ($monthlyIncome - $monthlyExpenses) >= 0 ? 'from-green-500 to-emerald-600' : 'from-red-500 to-pink-600' }} rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-110">
                <i class="fas fa-piggy-bank text-white text-xl"></i>
            </div>
        </div>
        <div class="mt-4 h-1 bg-gradient-to-r {{ ($monthlyIncome - $monthlyExpenses) >= 0 ? 'from-green-500 to-emerald-600' : 'from-red-500 to-pink-600' }} rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    </div>
</div>

<!-- Alerts Section -->
@if($overdueLoans->count() > 0 || $totalBorrowed > 0)
<div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-8">
    <div class="flex items-start">
        <i class="fas fa-exclamation-triangle text-red-600 mt-1 mr-3"></i>
        <div class="flex-1">
            <h4 class="font-semibold text-red-800">Alertas Financieras</h4>
            <div class="mt-2 space-y-1">
                @if($overdueLoans->count() > 0)
                    <p class="text-sm text-red-700">
                        <i class="fas fa-clock mr-1"></i>
                        Tienes {{ $overdueLoans->count() }} préstamo(s) vencido(s)
                        <a href="{{ route('loans.index') }}" class="underline hover:no-underline">Ver detalles</a>
                    </p>
                @endif
                @if($totalBorrowed > 0)
                    <p class="text-sm text-red-700">
                        <i class="fas fa-credit-card mr-1"></i>
                        Debes {{ number_format($totalBorrowed, 2) }} EUR en préstamos activos
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

<!-- Savings Goal -->
@if($savingsGoal > 0)
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Objetivo de Ahorro</h3>
        <span class="text-sm text-gray-600">{{ number_format($savingsProgress, 1) }}%</span>
    </div>
    <div class="mb-3">
        <div class="flex justify-between text-sm text-gray-600 mb-1">
            <span>{{ number_format($totalBalance, 2) }} EUR</span>
            <span>{{ number_format($savingsGoal, 2) }} EUR</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full transition-all duration-500" 
                 style="width: {{ min($savingsProgress, 100) }}%"></div>
        </div>
    </div>
    <p class="text-sm text-gray-600">
        @if($savingsProgress >= 100)
            ¡Felicidades! Has alcanzado tu objetivo de ahorro
        @else
            Te faltan {{ number_format($savingsGoal - $totalBalance, 2) }} EUR para alcanzar tu objetivo
        @endif
    </p>
</div>
@endif

<!-- Charts and Analysis Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Monthly Evolution Chart -->
    <div class="lg:col-span-2 glass-effect p-8 rounded-2xl card-hover animate-slide-up">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Evolución de los Últimos 6 Meses</h3>
                <p class="text-sm text-gray-600 mt-1">Tendencia de ingresos y gastos</p>
            </div>
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-chart-line text-white"></i>
            </div>
        </div>
        <div class="h-80 relative">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
    
    <!-- Weekly Pattern -->
    <div class="glass-effect p-8 rounded-2xl card-hover animate-slide-up" style="animation-delay: 0.2s">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Patrón Semanal</h3>
                <p class="text-sm text-gray-600 mt-1">Gastos por día de la semana</p>
            </div>
            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-week text-white"></i>
            </div>
        </div>
        <div class="space-y-4">
            @foreach($weeklyPattern as $day)
                <div class="group">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-gray-700">{{ $day['day'] }}</span>
                        <span class="text-sm font-medium text-gray-600">{{ number_format($day['amount'], 0) }} EUR</span>
                    </div>
                    <div class="w-full bg-gray-200/50 rounded-full h-3 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-3 rounded-full transition-all duration-1000 ease-out group-hover:from-purple-500 group-hover:to-pink-600" 
                             style="width: {{ collect($weeklyPattern)->max('amount') > 0 ? ($day['amount'] / collect($weeklyPattern)->max('amount')) * 100 : 0 }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Secondary Charts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Expenses by Category -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Categorías del Mes</h3>
        @if($topCategories->count() > 0)
            <div class="space-y-3">
                @foreach($topCategories as $category)
                    @php $percentage = $monthlyExpenses > 0 ? ($category->total / $monthlyExpenses) * 100 : 0; @endphp
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $category->color }}"></div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $category->name }}</p>
                                <p class="text-xs text-gray-600">{{ $category->count }} transacciones</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-800">{{ number_format($category->total, 2) }} EUR</p>
                            <p class="text-xs text-gray-600">{{ number_format($percentage, 1) }}%</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex items-center justify-center h-32 text-gray-500">
                <div class="text-center">
                    <i class="fas fa-chart-pie text-3xl mb-2"></i>
                    <p>No hay gastos este mes</p>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Loans Summary -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Préstamos Activos</h3>
            <a href="{{ route('loans.index') }}" class="text-blue-600 hover:text-blue-700 text-sm">Ver todos</a>
        </div>
        
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-hand-holding-usd text-green-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-green-800">Dinero Prestado</p>
                        <p class="text-sm text-green-600">A cobrar</p>
                    </div>
                </div>
                <p class="font-bold text-green-600">{{ number_format($totalLent, 2) }} EUR</p>
            </div>
            
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-credit-card text-red-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-red-800">Deudas Pendientes</p>
                        <p class="text-sm text-red-600">A pagar</p>
                    </div>
                </div>
                <p class="font-bold text-red-600">{{ number_format($totalBorrowed, 2) }} EUR</p>
            </div>
            
            <div class="border-t pt-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-700">Balance Neto:</span>
                    <span class="font-bold {{ ($totalLent - $totalBorrowed) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($totalLent - $totalBorrowed, 2) }} EUR
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Section: Accounts, Transactions, and Transfers -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Accounts -->
    <div class="glass-effect rounded-2xl overflow-hidden card-hover animate-slide-up">
        <div class="p-6 border-b border-white/10">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-wallet text-white"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Mis Cuentas</h3>
                </div>
                <a href="{{ route('accounts.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium hover:underline transition-all duration-200">Ver todas</a>
            </div>
        </div>
        <div class="p-6">
            @if($accounts->count() > 0)
                <div class="space-y-3">
                    @foreach($accounts->take(4) as $account)
                        <div class="group flex items-center justify-between p-4 bg-white/30 rounded-xl hover:bg-white/50 transition-all duration-300 border border-white/20">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas {{ $account->type === 'bank' ? 'fa-university' : ($account->type === 'cash' ? 'fa-money-bill' : 'fa-credit-card') }} text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm group-hover:text-gray-900 transition-colors">{{ $account->name }}</p>
                                    <p class="text-xs text-gray-600">{{ $account->transactions_count }} transacciones</p>
                                </div>
                            </div>
                            <p class="font-bold text-gray-800 text-sm">{{ number_format($account->balance, 2) }} EUR</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6 text-gray-500">
                    <i class="fas fa-wallet text-3xl mb-2"></i>
                    <p class="text-sm">No hay cuentas registradas</p>
                    <a href="{{ route('accounts.create') }}" class="text-blue-600 hover:underline text-sm">Crear primera cuenta</a>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Recent Transactions -->
    <div class="glass-effect rounded-2xl overflow-hidden card-hover animate-slide-up" style="animation-delay: 0.1s">
        <div class="p-6 border-b border-white/10">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-receipt text-white"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Transacciones Recientes</h3>
                </div>
                <a href="{{ route('transactions.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium hover:underline transition-all duration-200">Ver todas</a>
            </div>
        </div>
        <div class="p-6">
            @if($recentTransactions->count() > 0)
                <div class="space-y-3">
                    @foreach($recentTransactions->take(4) as $transaction)
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background-color: {{ $transaction->category->color }}20">
                                    <i class="fas {{ $transaction->type === 'income' ? 'fa-arrow-up' : 'fa-arrow-down' }} text-xs" style="color: {{ $transaction->category->color }}"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 text-sm">{{ Str::limit($transaction->description, 20) }}</p>
                                    <p class="text-xs text-gray-600">{{ $transaction->category->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-sm {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }} EUR
                                </p>
                                <p class="text-xs text-gray-500">{{ $transaction->transaction_date->format('d/m') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6 text-gray-500">
                    <i class="fas fa-receipt text-3xl mb-2"></i>
                    <p class="text-sm">No hay transacciones</p>
                    <a href="{{ route('transactions.create') }}" class="text-blue-600 hover:underline text-sm">Crear primera transacción</a>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Recent Transfers -->
    <div class="glass-effect rounded-2xl overflow-hidden card-hover animate-slide-up" style="animation-delay: 0.2s">
        <div class="p-6 border-b border-white/10">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exchange-alt text-white"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Transferencias Recientes</h3>
                </div>
                <a href="{{ route('transfers.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium hover:underline transition-all duration-200">Ver todas</a>
            </div>
        </div>
        <div class="p-6">
            @if($recentTransfers->count() > 0)
                <div class="space-y-3">
                    @foreach($recentTransfers as $transfer)
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-exchange-alt text-purple-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 text-sm">{{ Str::limit($transfer->description, 15) }}</p>
                                    <p class="text-xs text-gray-600">{{ Str::limit($transfer->fromAccount->name, 8) }} → {{ Str::limit($transfer->toAccount->name, 8) }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-sm text-purple-600">{{ number_format($transfer->amount, 2) }} EUR</p>
                                <p class="text-xs text-gray-500">{{ $transfer->transfer_date->format('d/m') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6 text-gray-500">
                    <i class="fas fa-exchange-alt text-3xl mb-2"></i>
                    <p class="text-sm">No hay transferencias</p>
                    <a href="{{ route('transfers.create') }}" class="text-blue-600 hover:underline text-sm">Crear primera transferencia</a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
// Monthly Evolution Chart
const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
new Chart(monthlyCtx, {
    type: 'line',
    data: {
        labels: @json(collect($monthlyEvolution)->pluck('month')),
        datasets: [{
            label: 'Ingresos',
            data: @json(collect($monthlyEvolution)->pluck('income')),
            borderColor: '#10B981',
            backgroundColor: '#10B98120',
            tension: 0.4
        }, {
            label: 'Gastos',
            data: @json(collect($monthlyEvolution)->pluck('expenses')),
            borderColor: '#EF4444',
            backgroundColor: '#EF444420',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '€' + value;
                    }
                }
            }
        }
    }
});

@if($expensesByCategory->count() > 0)
// Category Chart
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
new Chart(categoryCtx, {
    type: 'doughnut',
    data: {
        labels: @json($expensesByCategory->pluck('name')),
        datasets: [{
            data: @json($expensesByCategory->pluck('total')),
            backgroundColor: @json($expensesByCategory->pluck('color'))
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
@endif
</script>
@endsection