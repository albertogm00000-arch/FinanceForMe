@extends('layouts.app')

@section('title', 'Préstamos')
@section('header', 'Gestión de Préstamos')

@section('content')
<!-- Stats Overview -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
    @php
        $totalLent = $loans->where('type', 'lent')->where('status', 'active')->sum('remaining_amount');
        $totalBorrowed = $loans->where('type', 'borrowed')->where('status', 'active')->sum('remaining_amount');
        $overdueCount = $loans->filter(fn($loan) => $loan->isOverdue())->count();
        $activeCount = $loans->where('status', 'active')->count();
    @endphp
    
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
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-indigo-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Préstamos Activos</p>
                <p class="text-2xl font-bold text-blue-600 animate-bounce-in">{{ $activeCount }}</p>
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
                    En curso
                </p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-handshake text-white text-xl group-hover:animate-bounce"></i>
            </div>
        </div>
    </div>
    
    <div class="glass-effect backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/30 card-hover group relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-{{ $overdueCount > 0 ? 'red' : 'gray' }}-500/10 to-{{ $overdueCount > 0 ? 'pink' : 'slate' }}-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Préstamos Vencidos</p>
                <p class="text-2xl font-bold {{ $overdueCount > 0 ? 'text-red-600' : 'text-gray-600' }} animate-bounce-in">{{ $overdueCount }}</p>
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <span class="w-2 h-2 bg-{{ $overdueCount > 0 ? 'red' : 'gray' }}-500 rounded-full mr-2 animate-pulse"></span>
                    {{ $overdueCount > 0 ? 'Requieren atención' : 'Todo al día' }}
                </p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-{{ $overdueCount > 0 ? 'red' : 'gray' }}-500 to-{{ $overdueCount > 0 ? 'pink' : 'slate' }}-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-exclamation-triangle text-white text-xl {{ $overdueCount > 0 ? 'group-hover:animate-bounce' : 'group-hover:animate-pulse' }}"></i>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="flex flex-col sm:flex-row gap-4 mb-8">
    <a href="{{ route('loans.create') }}" class="flex-1 bg-gradient-to-r from-purple-600 via-pink-600 to-rose-600 text-white px-6 py-4 rounded-2xl hover:from-purple-700 hover:via-pink-700 hover:to-rose-700 transition-all duration-500 shadow-2xl hover:shadow-3xl group relative overflow-hidden flex items-center justify-center">
        <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center">
            <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center mr-3 group-hover:rotate-180 transition-transform duration-500">
                <i class="fas fa-plus"></i>
            </div>
            <span class="font-bold text-lg">Nuevo Préstamo</span>
        </div>
    </a>
    <div class="flex-1 flex gap-2">
        <button onclick="filterLoans('all')" class="flex-1 glass-effect backdrop-blur-xl text-gray-700 px-4 py-3 rounded-2xl hover:bg-gradient-to-r hover:from-gray-500/80 hover:to-slate-600/80 hover:text-white filter-btn active transition-all duration-300 border border-white/30 shadow-lg">
            Todos
        </button>
        <button onclick="filterLoans('lent')" class="flex-1 glass-effect backdrop-blur-xl text-green-700 px-4 py-3 rounded-2xl hover:bg-gradient-to-r hover:from-green-500/80 hover:to-emerald-600/80 hover:text-white filter-btn transition-all duration-300 border border-white/30 shadow-lg">
            Prestados
        </button>
        <button onclick="filterLoans('borrowed')" class="flex-1 glass-effect backdrop-blur-xl text-red-700 px-4 py-3 rounded-2xl hover:bg-gradient-to-r hover:from-red-500/80 hover:to-pink-600/80 hover:text-white filter-btn transition-all duration-300 border border-white/30 shadow-lg">
            Recibidos
        </button>
        <button onclick="filterLoans('overdue')" class="flex-1 glass-effect backdrop-blur-xl text-orange-700 px-4 py-3 rounded-2xl hover:bg-gradient-to-r hover:from-orange-500/80 hover:to-red-600/80 hover:text-white filter-btn transition-all duration-300 border border-white/30 shadow-lg">
            Vencidos
        </button>
    </div>
</div>

<!-- Loans List -->
@if($loans->count() > 0)
    <div class="space-y-4" id="loans-container">
        @foreach($loans as $loan)
            <div class="loan-card glass-effect backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 overflow-hidden card-hover group relative" 
                 data-type="{{ $loan->type }}" 
                 data-status="{{ $loan->status }}" 
                 data-overdue="{{ $loan->isOverdue() ? 'true' : 'false' }}">
                <div class="absolute inset-0 bg-gradient-to-br from-{{ $loan->type === 'lent' ? 'green' : 'red' }}-500/5 to-{{ $loan->type === 'lent' ? 'emerald' : 'pink' }}-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="p-6 relative z-10">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <!-- Loan Info -->
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-14 h-14 bg-gradient-to-br from-{{ $loan->type === 'lent' ? 'green' : 'red' }}-500 to-{{ $loan->type === 'lent' ? 'emerald' : 'pink' }}-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas {{ $loan->type === 'lent' ? 'fa-hand-holding-usd' : 'fa-credit-card' }} text-white text-xl group-hover:animate-pulse"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-gray-900 transition-colors">{{ $loan->person_name }}</h3>
                                        <p class="text-sm text-gray-600 flex items-center mt-1">
                                            <span class="w-2 h-2 bg-{{ $loan->type === 'lent' ? 'green' : 'red' }}-500 rounded-full mr-2"></span>
                                            {{ $loan->type === 'lent' ? 'Le presté dinero' : 'Me prestó dinero' }}
                                            @if($loan->person_contact)
                                                • {{ $loan->person_contact }}
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1 flex items-center">
                                            <i class="fas fa-wallet mr-1"></i>
                                            {{ $loan->account->name }}
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Status Badge -->
                                <div class="flex items-center space-x-2">
                                    @if($loan->isOverdue())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            Vencido
                                        </span>
                                    @elseif($loan->status === 'paid')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i>
                                            Pagado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Activo
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <p class="text-sm text-gray-700 mb-3">{{ $loan->description }}</p>
                            
                            <!-- Dates and Interest -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm text-gray-600">
                                <div>
                                    <span class="font-medium">Fecha:</span> {{ $loan->loan_date->format('d/m/Y') }}
                                </div>
                                @if($loan->due_date)
                                    <div class="{{ $loan->isOverdue() ? 'text-red-600' : '' }}">
                                        <span class="font-medium">Vence:</span> {{ $loan->due_date->format('d/m/Y') }}
                                    </div>
                                @endif
                                @if($loan->interest_rate > 0)
                                    <div>
                                        <span class="font-medium">Interés:</span> {{ $loan->interest_rate }}%
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Amount Info -->
                        <div class="lg:w-80">
                            <div class="glass-effect backdrop-blur-xl rounded-2xl p-4 border border-white/30 shadow-lg">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-coins mr-2"></i>
                                        Cantidad original:
                                    </span>
                                    <span class="font-bold text-gray-800 text-lg">{{ number_format($loan->amount, 2) }} EUR</span>
                                </div>
                                
                                @if($loan->status === 'active')
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-check mr-2"></i>
                                            Pagado:
                                        </span>
                                        <span class="font-semibold text-green-600">{{ number_format($loan->paid_amount, 2) }} EUR</span>
                                    </div>
                                    
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-clock mr-2"></i>
                                            Pendiente:
                                        </span>
                                        <span class="font-bold text-xl {{ $loan->type === 'lent' ? 'text-green-600' : 'text-red-600' }} animate-bounce-in">
                                            {{ number_format($loan->remaining_amount, 2) }} EUR
                                        </span>
                                    </div>
                                    
                                    <!-- Progress Bar -->
                                    <div class="mb-4">
                                        <div class="flex justify-between text-xs text-gray-600 mb-2">
                                            <span class="flex items-center">
                                                <i class="fas fa-chart-line mr-1"></i>
                                                Progreso
                                            </span>
                                            <span class="px-2 py-1 bg-gradient-to-r from-blue-500/20 to-indigo-600/20 rounded-full font-medium">{{ number_format($loan->progress_percentage, 1) }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200/50 rounded-full h-3 overflow-hidden">
                                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500 shadow-sm" 
                                                 style="width: {{ $loan->progress_percentage }}%"></div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-2">
                                            <i class="fas fa-check-circle text-white text-xl"></i>
                                        </div>
                                        <span class="text-green-600 font-bold">
                                            Préstamo completado
                                        </span>
                                    </div>
                                @endif
                                
                                <!-- Action Buttons -->
                                <div class="flex gap-2 mt-4">
                                    @if($loan->status === 'active')
                                        <button onclick="openPaymentModal({{ $loan->id }}, '{{ $loan->person_name }}', {{ $loan->remaining_amount }})" 
                                                class="flex-1 glass-effect backdrop-blur-xl text-blue-700 py-2 px-3 rounded-xl text-sm hover:bg-gradient-to-r hover:from-blue-500/80 hover:to-indigo-600/80 hover:text-white transition-all duration-300 border border-white/30 group">
                                            <i class="fas fa-money-bill mr-1 group-hover:animate-pulse"></i>
                                            Registrar Pago
                                        </button>
                                    @endif
                                    
                                    <a href="{{ route('loans.show', $loan) }}" 
                                       class="flex-1 glass-effect backdrop-blur-xl text-gray-700 py-2 px-3 rounded-xl text-sm hover:bg-gradient-to-r hover:from-gray-500/80 hover:to-slate-600/80 hover:text-white transition-all duration-300 border border-white/30 text-center group">
                                        <i class="fas fa-eye mr-1 group-hover:animate-pulse"></i>
                                        Detalles
                                    </a>
                                    
                                    <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="glass-effect backdrop-blur-xl text-red-700 py-2 px-3 rounded-xl text-sm hover:bg-gradient-to-r hover:from-red-500/80 hover:to-pink-600/80 hover:text-white transition-all duration-300 border border-white/30 group" 
                                                onclick="return confirm('¿Estás seguro de eliminar este préstamo?')">
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
        {{ $loans->links() }}
    </div>
@else
    <div class="glass-effect backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-12 text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-pink-600/5"></div>
        <div class="relative z-10">
            <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg animate-float">
                <i class="fas fa-handshake text-white text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-3">No tienes préstamos registrados</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">Registra préstamos para llevar control inteligente de dinero prestado o recibido</p>
            <a href="{{ route('loans.create') }}" class="bg-gradient-to-r from-purple-600 via-pink-600 to-rose-600 text-white px-8 py-4 rounded-2xl hover:from-purple-700 hover:via-pink-700 hover:to-rose-700 transition-all duration-500 shadow-2xl hover:shadow-3xl group relative overflow-hidden inline-flex items-center">
                <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10 flex items-center">
                    <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center mr-3 group-hover:rotate-180 transition-transform duration-500">
                        <i class="fas fa-plus"></i>
                    </div>
                    <span class="font-bold">Registrar Primer Préstamo</span>
                </div>
            </a>
        </div>
    </div>
@endif

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Registrar Pago</h3>
                    <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="paymentForm" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Préstamo de: <span id="modalPersonName" class="font-semibold"></span></p>
                        <p class="text-sm text-gray-600">Cantidad pendiente: <span id="modalRemainingAmount" class="font-semibold"></span> EUR</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad del pago</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">EUR</span>
                            <input type="number" name="payment_amount" id="paymentAmount" step="0.01" min="0.01" 
                                   class="w-full border border-gray-300 rounded-lg pl-12 pr-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="0.00" required>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha del pago</label>
                        <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700">
                            Registrar Pago
                        </button>
                        <button type="button" onclick="closePaymentModal()" class="flex-1 bg-gray-100 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-200">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function filterLoans(type) {
    const cards = document.querySelectorAll('.loan-card');
    const buttons = document.querySelectorAll('.filter-btn');
    
    buttons.forEach(btn => btn.classList.remove('active', 'bg-blue-600', 'text-white'));
    event.target.classList.add('active', 'bg-blue-600', 'text-white');
    
    cards.forEach(card => {
        const cardType = card.dataset.type;
        const cardStatus = card.dataset.status;
        const isOverdue = card.dataset.overdue === 'true';
        
        let show = false;
        
        switch(type) {
            case 'all':
                show = true;
                break;
            case 'lent':
                show = cardType === 'lent';
                break;
            case 'borrowed':
                show = cardType === 'borrowed';
                break;
            case 'overdue':
                show = isOverdue;
                break;
        }
        
        card.style.display = show ? 'block' : 'none';
    });
}

function openPaymentModal(loanId, personName, remainingAmount) {
    document.getElementById('modalPersonName').textContent = personName;
    document.getElementById('modalRemainingAmount').textContent = remainingAmount.toFixed(2);
    document.getElementById('paymentAmount').max = remainingAmount;
    document.getElementById('paymentForm').action = `/loans/${loanId}/payment`;
    document.getElementById('paymentModal').classList.remove('hidden');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
    document.getElementById('paymentForm').reset();
}

// Close modal on outside click
document.getElementById('paymentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePaymentModal();
    }
});
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

.filter-btn.active {
    background: linear-gradient(135deg, #3b82f6, #6366f1) !important;
    color: white !important;
    box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3) !important;
    transform: scale(1.05) !important;
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

.loan-card {
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