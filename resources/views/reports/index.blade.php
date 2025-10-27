@extends('layouts.app')

@section('title', 'Reportes Financieros')
@section('header', 'Reportes y Análisis')

@section('content')
<!-- Period Selector -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <form method="GET" class="flex flex-col lg:flex-row gap-4 items-end">
        <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Período</label>
                <select name="period" id="period" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="month" {{ $period === 'month' ? 'selected' : '' }}>Mes</option>
                    <option value="quarter" {{ $period === 'quarter' ? 'selected' : '' }}>Trimestre</option>
                    <option value="year" {{ $period === 'year' ? 'selected' : '' }}>Año</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Año</label>
                <select name="year" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @for($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            
            <div id="month-selector" class="{{ $period !== 'month' ? 'hidden' : '' }}">
                <label class="block text-sm font-medium text-gray-700 mb-2">Mes</label>
                <select name="month" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            
            <div id="quarter-selector" class="{{ $period !== 'quarter' ? 'hidden' : '' }}">
                <label class="block text-sm font-medium text-gray-700 mb-2">Trimestre</label>
                <select name="quarter" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="1" {{ request('quarter', ceil(now()->month / 3)) == 1 ? 'selected' : '' }}>Q1 (Ene-Mar)</option>
                    <option value="2" {{ request('quarter', ceil(now()->month / 3)) == 2 ? 'selected' : '' }}>Q2 (Abr-Jun)</option>
                    <option value="3" {{ request('quarter', ceil(now()->month / 3)) == 3 ? 'selected' : '' }}>Q3 (Jul-Sep)</option>
                    <option value="4" {{ request('quarter', ceil(now()->month / 3)) == 4 ? 'selected' : '' }}>Q4 (Oct-Dic)</option>
                </select>
            </div>
        </div>
        
        <button type="submit" class="bg-gradient-to-r from-teal-600 via-cyan-600 to-blue-600 text-white px-8 py-3 rounded-2xl hover:from-teal-700 hover:via-cyan-700 hover:to-blue-700 transition-all duration-500 shadow-2xl hover:shadow-3xl group relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10 flex items-center">
                <div class="w-6 h-6 bg-white/20 rounded-lg flex items-center justify-center mr-3 group-hover:rotate-180 transition-transform duration-500">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <span class="font-bold">Generar Reporte</span>
            </div>
        </button>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
    <div class="glass-effect backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/30 card-hover group relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-emerald-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Ingresos</p>
                <p class="text-2xl font-bold text-green-600 animate-bounce-in">{{ number_format($totalIncome, 2) }} EUR</p>
                @if($prevIncome > 0)
                    @php $incomeChange = (($totalIncome - $prevIncome) / $prevIncome) * 100; @endphp
                    <p class="text-xs {{ $incomeChange >= 0 ? 'text-green-600' : 'text-red-600' }} mt-2 flex items-center">
                        <i class="fas fa-{{ $incomeChange >= 0 ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                        {{ $incomeChange >= 0 ? '+' : '' }}{{ number_format($incomeChange, 1) }}% vs anterior
                    </p>
                @endif
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-arrow-up text-white text-xl group-hover:animate-bounce"></i>
            </div>
        </div>
    </div>
    
    <div class="glass-effect backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/30 card-hover group relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-red-500/10 to-pink-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Gastos</p>
                <p class="text-2xl font-bold text-red-600 animate-bounce-in">{{ number_format($totalExpenses, 2) }} EUR</p>
                @if($prevExpenses > 0)
                    @php $expenseChange = (($totalExpenses - $prevExpenses) / $prevExpenses) * 100; @endphp
                    <p class="text-xs {{ $expenseChange <= 0 ? 'text-green-600' : 'text-red-600' }} mt-2 flex items-center">
                        <i class="fas fa-{{ $expenseChange <= 0 ? 'arrow-down' : 'arrow-up' }} mr-1"></i>
                        {{ $expenseChange >= 0 ? '+' : '' }}{{ number_format($expenseChange, 1) }}% vs anterior
                    </p>
                @endif
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-arrow-down text-white text-xl group-hover:animate-bounce"></i>
            </div>
        </div>
    </div>
    
    <div class="glass-effect backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/30 card-hover group relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-{{ $netIncome >= 0 ? 'green' : 'red' }}-500/10 to-{{ $netIncome >= 0 ? 'emerald' : 'pink' }}-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Balance Neto</p>
                <p class="text-2xl font-bold {{ $netIncome >= 0 ? 'text-green-600' : 'text-red-600' }} animate-bounce-in">
                    {{ number_format($netIncome, 2) }} EUR
                </p>
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <span class="w-2 h-2 bg-{{ $netIncome >= 0 ? 'green' : 'red' }}-500 rounded-full mr-2 animate-pulse"></span>
                    {{ $totalExpenses > 0 ? number_format(($netIncome / $totalIncome) * 100, 1) : 0 }}% de ahorro
                </p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-{{ $netIncome >= 0 ? 'green' : 'red' }}-500 to-{{ $netIncome >= 0 ? 'emerald' : 'pink' }}-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-chart-line text-white text-xl group-hover:animate-pulse"></i>
            </div>
        </div>
    </div>
    
    <div class="glass-effect backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/30 card-hover group relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-indigo-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Balance Total</p>
                <p class="text-2xl font-bold text-blue-600 animate-bounce-in">{{ number_format($totalBalance, 2) }} EUR</p>
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
                    Préstamos: {{ number_format($totalLent - $totalBorrowed, 2) }} EUR
                </p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-wallet text-white text-xl group-hover:animate-float"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Evolution Chart -->
    <div class="glass-effect backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-6 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-teal-500/5 to-cyan-600/5"></div>
        <div class="relative z-10">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <div class="w-8 h-8 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-chart-line text-white text-sm"></i>
                </div>
                Evolución {{ $period === 'month' ? 'Diaria' : 'Mensual' }}
            </h3>
            <div class="h-64">
                <canvas id="evolutionChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Expenses by Category -->
    <div class="glass-effect backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-6 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-pink-600/5"></div>
        <div class="relative z-10">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-chart-pie text-white text-sm"></i>
                </div>
                Gastos por Categoría
            </h3>
            @if($expensesByCategory->count() > 0)
                <canvas id="expensesChart" class="w-full h-64"></canvas>
            @else
                <div class="flex items-center justify-center h-64 text-gray-500">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4 animate-float">
                            <i class="fas fa-chart-pie text-white text-2xl"></i>
                        </div>
                        <p class="font-medium">No hay gastos en este período</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Detailed Analysis -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Category Breakdown -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Expenses by Category Table -->
        <div class="glass-effect backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-6 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-red-600/5"></div>
            <div class="relative z-10">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-list text-white text-sm"></i>
                    </div>
                    Desglose de Gastos
                </h3>
            @if($expensesByCategory->count() > 0)
                <div class="space-y-3">
                    @foreach($expensesByCategory as $category)
                        @php $percentage = $totalExpenses > 0 ? ($category->total / $totalExpenses) * 100 : 0; @endphp
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $category->color }}"></div>
                                <span class="font-medium text-gray-800">{{ $category->name }}</span>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-800">{{ number_format($category->total, 2) }} EUR</p>
                                <p class="text-sm text-gray-600">{{ number_format($percentage, 1) }}%</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No hay gastos registrados</p>
            @endif
            </div>
        </div>
        
        <!-- Top Expenses -->
        <div class="glass-effect backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-6 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 to-pink-600/5"></div>
            <div class="relative z-10">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-trophy text-white text-sm"></i>
                    </div>
                    Mayores Gastos
                </h3>
            @if($topExpenses->count() > 0)
                <div class="space-y-3">
                    @foreach($topExpenses as $expense)
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full mr-3" style="background-color: {{ $expense->category->color }}"></div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $expense->description }}</p>
                                    <p class="text-sm text-gray-600">{{ $expense->category->name }} • {{ $expense->transaction_date->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <p class="font-semibold text-red-600">{{ number_format($expense->amount, 2) }} EUR</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No hay gastos registrados</p>
            @endif
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Accounts Breakdown -->
        <div class="glass-effect backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-6 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-600/5"></div>
            <div class="relative z-10">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-wallet text-white text-sm"></i>
                    </div>
                    Gastos por Cuenta
                </h3>
            @if($expensesByAccount->count() > 0)
                <div class="space-y-3">
                    @foreach($expensesByAccount as $account)
                        <div class="flex items-center justify-between p-3 glass-effect backdrop-blur-xl rounded-xl border border-white/30 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3 shadow-sm">
                                    <i class="fas {{ $account->type === 'bank' ? 'fa-university' : ($account->type === 'cash' ? 'fa-money-bill' : 'fa-credit-card') }} text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $account->name }}</p>
                                    <p class="text-sm text-gray-600">{{ number_format($account->total, 2) }} EUR</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No hay gastos por cuenta</p>
            @endif
            </div>
        </div>
    </div>
</div>

<script>
// Period selector logic
document.getElementById('period').addEventListener('change', function() {
    const period = this.value;
    const monthSelector = document.getElementById('month-selector');
    const quarterSelector = document.getElementById('quarter-selector');
    
    monthSelector.classList.toggle('hidden', period !== 'month');
    quarterSelector.classList.toggle('hidden', period !== 'quarter');
});

// Evolution Chart
const evolutionCtx = document.getElementById('evolutionChart').getContext('2d');
new Chart(evolutionCtx, {
    type: 'line',
    data: {
        labels: @json(collect($evolutionData)->pluck('label')),
        datasets: [{
            label: 'Ingresos',
            data: @json(collect($evolutionData)->pluck('income')),
            borderColor: '#10B981',
            backgroundColor: '#10B98120',
            tension: 0.4,
            fill: false
        }, {
            label: 'Gastos',
            data: @json(collect($evolutionData)->pluck('expenses')),
            borderColor: '#EF4444',
            backgroundColor: '#EF444420',
            tension: 0.4,
            fill: false
        }, {
            label: 'Neto',
            data: @json(collect($evolutionData)->pluck('net')),
            borderColor: '#3B82F6',
            backgroundColor: '#3B82F620',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            intersect: false
        },
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
                        return value + ' EUR';
                    }
                }
            }
        }
    }
});

@if($expensesByCategory->count() > 0)
// Expenses Chart
const expensesCtx = document.getElementById('expensesChart').getContext('2d');
new Chart(expensesCtx, {
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
</style>
@endsection