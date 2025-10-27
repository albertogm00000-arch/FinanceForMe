@extends('layouts.app')

@section('title', 'Transacciones')
@section('header', 'Historial de Transacciones')

@section('content')
<!-- Stats Overview -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
    @php
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpenses = $transactions->where('type', 'expense')->sum('amount');
        $avgTransaction = $transactions->count() > 0 ? $transactions->avg('amount') : 0;
        $thisMonth = $transactions->filter(fn($t) => $t->transaction_date->isCurrentMonth());
    @endphp
    
    <div class="glass-effect backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/30 card-hover group relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-emerald-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Total Ingresos</p>
                <p class="text-2xl font-bold text-green-600 animate-bounce-in">{{ number_format($totalIncome, 2) }} EUR</p>
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                    {{ $transactions->where('type', 'income')->count() }} transacciones
                </p>
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
                <p class="text-sm font-medium text-gray-600 mb-2">Total Gastos</p>
                <p class="text-2xl font-bold text-red-600 animate-bounce-in">{{ number_format($totalExpenses, 2) }} EUR</p>
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                    {{ $transactions->where('type', 'expense')->count() }} transacciones
                </p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-arrow-down text-white text-xl group-hover:animate-bounce"></i>
            </div>
        </div>
    </div>
    
    <div class="glass-effect backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/30 card-hover group relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-{{ ($totalIncome - $totalExpenses) >= 0 ? 'green' : 'red' }}-500/10 to-{{ ($totalIncome - $totalExpenses) >= 0 ? 'emerald' : 'pink' }}-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Balance Neto</p>
                <p class="text-2xl font-bold {{ ($totalIncome - $totalExpenses) >= 0 ? 'text-green-600' : 'text-red-600' }} animate-bounce-in">
                    {{ number_format($totalIncome - $totalExpenses, 2) }} EUR
                </p>
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <span class="w-2 h-2 bg-{{ ($totalIncome - $totalExpenses) >= 0 ? 'green' : 'red' }}-500 rounded-full mr-2 animate-pulse"></span>
                    {{ $transactions->count() }} transacciones totales
                </p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-{{ ($totalIncome - $totalExpenses) >= 0 ? 'green' : 'red' }}-500 to-{{ ($totalIncome - $totalExpenses) >= 0 ? 'emerald' : 'pink' }}-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-chart-line text-white text-xl group-hover:animate-pulse"></i>
            </div>
        </div>
    </div>
    
    <div class="glass-effect backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/30 card-hover group relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-indigo-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Promedio por Transacción</p>
                <p class="text-2xl font-bold text-blue-600 animate-bounce-in">{{ number_format($avgTransaction, 2) }} EUR</p>
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
                    Este mes: {{ $thisMonth->count() }} transacciones
                </p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-calculator text-white text-xl group-hover:animate-spin"></i>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="flex flex-col sm:flex-row gap-4 mb-8">
    <a href="{{ route('transactions.create') }}" class="flex-1 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 text-white px-6 py-4 rounded-2xl hover:from-blue-700 hover:via-purple-700 hover:to-indigo-700 transition-all duration-500 shadow-2xl hover:shadow-3xl group relative overflow-hidden flex items-center justify-center">
        <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center">
            <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center mr-3 group-hover:rotate-180 transition-transform duration-500">
                <i class="fas fa-plus"></i>
            </div>
            <span class="font-bold text-lg">Nueva Transacción</span>
        </div>
    </a>
    <div class="flex-1 flex gap-2">
        <button onclick="filterTransactions('all')" class="flex-1 glass-effect backdrop-blur-xl text-gray-700 px-4 py-3 rounded-2xl hover:bg-gradient-to-r hover:from-gray-500/80 hover:to-slate-600/80 hover:text-white filter-btn active transition-all duration-300 border border-white/30 shadow-lg">
            Todas
        </button>
        <button onclick="filterTransactions('income')" class="flex-1 glass-effect backdrop-blur-xl text-green-700 px-4 py-3 rounded-2xl hover:bg-gradient-to-r hover:from-green-500/80 hover:to-emerald-600/80 hover:text-white filter-btn transition-all duration-300 border border-white/30 shadow-lg">
            Ingresos
        </button>
        <button onclick="filterTransactions('expense')" class="flex-1 glass-effect backdrop-blur-xl text-red-700 px-4 py-3 rounded-2xl hover:bg-gradient-to-r hover:from-red-500/80 hover:to-pink-600/80 hover:text-white filter-btn transition-all duration-300 border border-white/30 shadow-lg">
            Gastos
        </button>
        <button onclick="filterTransactions('today')" class="flex-1 glass-effect backdrop-blur-xl text-purple-700 px-4 py-3 rounded-2xl hover:bg-gradient-to-r hover:from-purple-500/80 hover:to-indigo-600/80 hover:text-white filter-btn transition-all duration-300 border border-white/30 shadow-lg">
            Hoy
        </button>
    </div>
</div>

<!-- Advanced Filters -->
<div class="glass-effect backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-4 sm:p-6 mb-6 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-purple-600/5"></div>
    <div class="relative z-10">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-filter text-white text-sm"></i>
                </div>
                Filtros Avanzados
            </h3>
            <button onclick="toggleFilters()" class="glass-effect backdrop-blur-xl px-4 py-2 rounded-xl text-blue-600 hover:text-white hover:bg-gradient-to-r hover:from-blue-500/80 hover:to-purple-600/80 text-sm transition-all duration-300 border border-white/30 shadow-lg">
                <i class="fas fa-filter mr-1"></i>
                <span id="filter-toggle-text">Mostrar</span>
            </button>
        </div>
    
    <div id="advanced-filters" class="hidden">
        <form method="GET" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                <div class="xl:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Buscar descripción..." 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <select name="type" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todos los tipos</option>
                        <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Ingresos</option>
                        <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Gastos</option>
                    </select>
                </div>
                
                <div>
                    <select name="category" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todas las categorías</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <select name="account" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todas las cuentas</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" {{ request('account') == $account->id ? 'selected' : '' }}>
                                {{ $account->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex space-x-2">
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('transactions.index') }}" class="flex-1 bg-gray-100 text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-200 text-center">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Desde</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Hasta</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Cantidad mínima</label>
                    <input type="number" name="amount_min" value="{{ request('amount_min') }}" step="0.01" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="0.00">
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Cantidad máxima</label>
                    <input type="number" name="amount_max" value="{{ request('amount_max') }}" step="0.01" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="999999.99">
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Transactions List -->
@if($transactions->count() > 0)
    <div class="space-y-4" id="transactions-container">
        @foreach($transactions as $transaction)
            <div class="transaction-card glass-effect backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 overflow-hidden card-hover group relative" 
                 data-type="{{ $transaction->type }}" 
                 data-date="{{ $transaction->transaction_date->format('Y-m-d') }}">
                <div class="absolute inset-0 bg-gradient-to-br from-{{ $transaction->type === 'income' ? 'green' : 'red' }}-500/5 to-{{ $transaction->type === 'income' ? 'emerald' : 'pink' }}-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="p-6 relative z-10">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <!-- Transaction Info -->
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mr-4 shadow-lg group-hover:scale-110 transition-transform duration-300" 
                                         style="background: linear-gradient(135deg, {{ $transaction->category->color }}20, {{ $transaction->category->color }}40)">
                                        <i class="fas {{ $transaction->type === 'income' ? 'fa-arrow-up' : 'fa-arrow-down' }} text-xl group-hover:animate-bounce" 
                                           style="color: {{ $transaction->category->color }}"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-gray-900 transition-colors">{{ $transaction->description }}</h3>
                                        <div class="flex items-center text-sm text-gray-600 mt-1">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium shadow-sm" 
                                                  style="background: linear-gradient(135deg, {{ $transaction->category->color }}20, {{ $transaction->category->color }}30); color: {{ $transaction->category->color }}">
                                                <span class="w-2 h-2 rounded-full mr-2" style="background-color: {{ $transaction->category->color }}"></span>
                                                {{ $transaction->category->name }}
                                            </span>
                                            <span class="mx-2 text-gray-400">•</span>
                                            <span class="font-medium">{{ $transaction->account->name }}</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2 flex items-center">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $transaction->transaction_date->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Type Badge -->
                                <div class="flex items-center space-x-2">
                                    @if($transaction->transaction_date->isToday())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Hoy
                                        </span>
                                    @elseif($transaction->transaction_date->isYesterday())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-calendar mr-1"></i>
                                            Ayer
                                        </span>
                                    @elseif($transaction->transaction_date->isCurrentWeek())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-calendar-week mr-1"></i>
                                            Esta semana
                                        </span>
                                    @endif
                                    
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $transaction->type === 'income' ? 'Ingreso' : 'Gasto' }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Account Details -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center mr-2">
                                        <i class="fas {{ $transaction->account->type === 'bank' ? 'fa-university' : ($transaction->account->type === 'cash' ? 'fa-money-bill' : 'fa-credit-card') }} text-gray-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $transaction->account->name }}</p>
                                        <p class="text-gray-600 capitalize">{{ $transaction->account->type }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-2" 
                                         style="background-color: {{ $transaction->category->color }}20">
                                        <i class="fas fa-tag text-sm" style="color: {{ $transaction->category->color }}"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $transaction->category->name }}</p>
                                        <p class="text-gray-600">Categoría</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                                        <i class="fas fa-calendar text-blue-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $transaction->transaction_date->format('d/m/Y') }}</p>
                                        <p class="text-gray-600">{{ $transaction->transaction_date->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Amount and Actions -->
                        <div class="lg:w-64">
                            <div class="glass-effect backdrop-blur-xl rounded-2xl p-4 border border-white/30 shadow-lg">
                                <div class="text-center mb-4">
                                    <p class="text-sm text-gray-600 mb-2 flex items-center justify-center">
                                        <i class="fas fa-coins mr-2"></i>
                                        Cantidad
                                    </p>
                                    <p class="text-3xl font-bold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }} animate-bounce-in">
                                        {{ $transaction->type === 'income' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }} EUR
                                    </p>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <button onclick="showTransactionDetails({{ $transaction->id }})" 
                                            class="flex-1 glass-effect backdrop-blur-xl text-blue-700 py-2 px-3 rounded-xl text-sm hover:bg-gradient-to-r hover:from-blue-500/80 hover:to-indigo-600/80 hover:text-white transition-all duration-300 border border-white/30 shadow-sm group">
                                        <i class="fas fa-eye mr-1 group-hover:animate-pulse"></i>
                                        Detalles
                                    </button>
                                    
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="glass-effect backdrop-blur-xl text-red-700 py-2 px-3 rounded-xl text-sm hover:bg-gradient-to-r hover:from-red-500/80 hover:to-pink-600/80 hover:text-white transition-all duration-300 border border-white/30 shadow-sm group" 
                                                onclick="return confirm('¿Eliminar esta transacción?')">
                                            <i class="fas fa-trash group-hover:animate-bounce"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-8">
        {{ $transactions->links() }}
    </div>
@else
    <div class="glass-effect backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-12 text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-purple-600/5"></div>
        <div class="relative z-10">
            <div class="w-20 h-20 bg-gradient-to-br from-gray-400 to-gray-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg animate-float">
                <i class="fas fa-receipt text-white text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-3">No hay transacciones</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                @if(request()->hasAny(['search', 'type', 'category', 'account', 'date_from', 'date_to']))
                    No se encontraron transacciones con los filtros aplicados.
                @else
                    No tienes transacciones registradas aún. ¡Comienza creando tu primera transacción!
                @endif
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @if(request()->hasAny(['search', 'type', 'category', 'account', 'date_from', 'date_to']))
                    <a href="{{ route('transactions.index') }}" class="glass-effect backdrop-blur-xl px-6 py-3 rounded-xl text-blue-600 hover:text-white hover:bg-gradient-to-r hover:from-blue-500/80 hover:to-indigo-600/80 transition-all duration-300 border border-white/30 shadow-lg">
                        <i class="fas fa-times mr-2"></i>
                        Limpiar filtros
                    </a>
                @endif
                <a href="{{ route('transactions.create') }}" class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 text-white px-8 py-4 rounded-2xl hover:from-blue-700 hover:via-purple-700 hover:to-indigo-700 transition-all duration-500 shadow-2xl hover:shadow-3xl group relative overflow-hidden inline-flex items-center">
                    <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10 flex items-center">
                        <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center mr-3 group-hover:rotate-180 transition-transform duration-500">
                            <i class="fas fa-plus"></i>
                        </div>
                        <span class="font-bold">Nueva Transacción</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endif

<!-- Transaction Details Modal -->
<div id="transactionModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Detalles de la Transacción</h3>
                    <button onclick="closeTransactionModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div id="modalContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filterTransactions(type) {
    const cards = document.querySelectorAll('.transaction-card');
    const buttons = document.querySelectorAll('.filter-btn');
    const today = new Date().toISOString().split('T')[0];
    
    buttons.forEach(btn => btn.classList.remove('active', 'bg-blue-600', 'text-white'));
    event.target.classList.add('active', 'bg-blue-600', 'text-white');
    
    cards.forEach(card => {
        const cardType = card.dataset.type;
        const cardDate = card.dataset.date;
        let show = false;
        
        switch(type) {
            case 'all':
                show = true;
                break;
            case 'income':
                show = cardType === 'income';
                break;
            case 'expense':
                show = cardType === 'expense';
                break;
            case 'today':
                show = cardDate === today;
                break;
        }
        
        card.style.display = show ? 'block' : 'none';
    });
}

function toggleFilters() {
    const filters = document.getElementById('advanced-filters');
    const toggleText = document.getElementById('filter-toggle-text');
    
    if (filters.classList.contains('hidden')) {
        filters.classList.remove('hidden');
        toggleText.textContent = 'Ocultar';
    } else {
        filters.classList.add('hidden');
        toggleText.textContent = 'Mostrar';
    }
}

function showTransactionDetails(transactionId) {
    const modalContent = document.getElementById('modalContent');
    modalContent.innerHTML = `
        <div class="space-y-4">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-semibold text-gray-800 mb-2">Información de la Transacción</h4>
                <p class="text-sm text-gray-600">ID: #${transactionId}</p>
            </div>
            <div class="text-center">
                <p class="text-gray-600">Detalles completos disponibles próximamente</p>
            </div>
        </div>
    `;
    document.getElementById('transactionModal').classList.remove('hidden');
}

function closeTransactionModal() {
    document.getElementById('transactionModal').classList.add('hidden');
}

// Close modal on outside click
document.getElementById('transactionModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeTransactionModal();
    }
});
</script>

<style>
.filter-btn.active {
    background: linear-gradient(135deg, #3b82f6, #6366f1) !important;
    color: white !important;
    box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3) !important;
    transform: scale(1.05) !important;
}

.transaction-card {
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
</style>
@endsection