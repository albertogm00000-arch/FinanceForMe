@extends('layouts.app')

@section('title', 'Transferencias')
@section('header', 'Historial de Transferencias')

@section('content')
<!-- Stats Overview -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
    @php
        $totalTransferred = $transfers->sum('amount');
        $totalFees = $transfers->sum('fee');
        $thisMonth = $transfers->filter(fn($t) => $t->transfer_date->isCurrentMonth());
        $monthlyTransferred = $thisMonth->sum('amount');
        $avgTransfer = $transfers->count() > 0 ? $totalTransferred / $transfers->count() : 0;
    @endphp
    
    <div class="glass-effect backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/30 card-hover group relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-indigo-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Total Transferido</p>
                <p class="text-2xl font-bold text-blue-600 animate-bounce-in">{{ number_format($totalTransferred, 2) }} EUR</p>
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
                    Todas las transferencias
                </p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-exchange-alt text-white text-xl group-hover:animate-spin"></i>
            </div>
        </div>
    </div>
    
    <div class="glass-effect backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/30 card-hover group relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-emerald-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Este Mes</p>
                <p class="text-2xl font-bold text-green-600 animate-bounce-in">{{ number_format($monthlyTransferred, 2) }} EUR</p>
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                    {{ $thisMonth->count() }} transferencias
                </p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-calendar-month text-white text-xl group-hover:animate-pulse"></i>
            </div>
        </div>
    </div>
    
    <div class="glass-effect backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/30 card-hover group relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-red-500/10 to-pink-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Comisiones Pagadas</p>
                <p class="text-2xl font-bold text-red-600 animate-bounce-in">{{ number_format($totalFees, 2) }} EUR</p>
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                    Costos adicionales
                </p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-receipt text-white text-xl group-hover:animate-bounce"></i>
            </div>
        </div>
    </div>
    
    <div class="glass-effect backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/30 card-hover group relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-pink-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-2">Promedio por Transferencia</p>
                <p class="text-2xl font-bold text-purple-600 animate-bounce-in">{{ number_format($avgTransfer, 2) }} EUR</p>
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <span class="w-2 h-2 bg-purple-500 rounded-full mr-2 animate-pulse"></span>
                    Cantidad media
                </p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-chart-bar text-white text-xl group-hover:animate-pulse"></i>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="flex flex-col sm:flex-row gap-4 mb-8">
    <a href="{{ route('transfers.create') }}" class="flex-1 bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 text-white px-6 py-4 rounded-2xl hover:from-green-700 hover:via-emerald-700 hover:to-teal-700 transition-all duration-500 shadow-2xl hover:shadow-3xl group relative overflow-hidden flex items-center justify-center">
        <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center">
            <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center mr-3 group-hover:rotate-180 transition-transform duration-500">
                <i class="fas fa-plus"></i>
            </div>
            <span class="font-bold text-lg">Nueva Transferencia</span>
        </div>
    </a>
    <div class="flex-1 flex gap-2">
        <button onclick="filterTransfers('all')" class="flex-1 glass-effect backdrop-blur-xl text-gray-700 px-4 py-3 rounded-2xl hover:bg-gradient-to-r hover:from-gray-500/80 hover:to-slate-600/80 hover:text-white filter-btn active transition-all duration-300 border border-white/30 shadow-lg">
            Todas
        </button>
        <button onclick="filterTransfers('today')" class="flex-1 glass-effect backdrop-blur-xl text-green-700 px-4 py-3 rounded-2xl hover:bg-gradient-to-r hover:from-green-500/80 hover:to-emerald-600/80 hover:text-white filter-btn transition-all duration-300 border border-white/30 shadow-lg">
            Hoy
        </button>
        <button onclick="filterTransfers('week')" class="flex-1 glass-effect backdrop-blur-xl text-blue-700 px-4 py-3 rounded-2xl hover:bg-gradient-to-r hover:from-blue-500/80 hover:to-indigo-600/80 hover:text-white filter-btn transition-all duration-300 border border-white/30 shadow-lg">
            Semana
        </button>
        <button onclick="filterTransfers('month')" class="flex-1 glass-effect backdrop-blur-xl text-purple-700 px-4 py-3 rounded-2xl hover:bg-gradient-to-r hover:from-purple-500/80 hover:to-pink-600/80 hover:text-white filter-btn transition-all duration-300 border border-white/30 shadow-lg">
            Mes
        </button>
    </div>
</div>

<!-- Transfers List -->
@if($transfers->count() > 0)
    <div class="space-y-4" id="transfers-container">
        @foreach($transfers as $transfer)
            <div class="transfer-card glass-effect backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 overflow-hidden card-hover group relative" 
                 data-date="{{ $transfer->transfer_date->format('Y-m-d') }}">
                
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <!-- Transfer Info -->
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-exchange-alt text-blue-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $transfer->description }}</h3>
                                        <div class="flex items-center text-sm text-gray-600 mt-1">
                                            <span class="font-medium">{{ $transfer->fromAccount->name }}</span>
                                            <i class="fas fa-arrow-right mx-2 text-gray-400"></i>
                                            <span class="font-medium">{{ $transfer->toAccount->name }}</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">{{ $transfer->transfer_date->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                
                                <!-- Date Badge -->
                                <div class="flex items-center space-x-2">
                                    @if($transfer->transfer_date->isToday())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Hoy
                                        </span>
                                    @elseif($transfer->transfer_date->isYesterday())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-calendar mr-1"></i>
                                            Ayer
                                        </span>
                                    @elseif($transfer->transfer_date->isCurrentWeek())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-calendar-week mr-1"></i>
                                            Esta semana
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Account Details -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                <div class="bg-red-50 p-3 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-2">
                                                <i class="fas {{ $transfer->fromAccount->type === 'bank' ? 'fa-university' : ($transfer->fromAccount->type === 'cash' ? 'fa-money-bill' : 'fa-credit-card') }} text-red-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-red-800">Origen</p>
                                                <p class="text-red-600">{{ $transfer->fromAccount->name }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-red-600 font-semibold">-{{ number_format($transfer->amount + $transfer->fee, 2) }} EUR</p>
                                            @if($transfer->fee > 0)
                                                <p class="text-xs text-red-500">(+{{ number_format($transfer->fee, 2) }} comisión)</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-green-50 p-3 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-2">
                                                <i class="fas {{ $transfer->toAccount->type === 'bank' ? 'fa-university' : ($transfer->toAccount->type === 'cash' ? 'fa-money-bill' : 'fa-credit-card') }} text-green-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-green-800">Destino</p>
                                                <p class="text-green-600">{{ $transfer->toAccount->name }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-green-600 font-semibold">+{{ number_format($transfer->amount, 2) }} EUR</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Amount and Actions -->
                        <div class="lg:w-64">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-center mb-3">
                                    <p class="text-sm text-gray-600 mb-1">Cantidad Transferida</p>
                                    <p class="text-2xl font-bold text-blue-600">{{ number_format($transfer->amount, 2) }} EUR</p>
                                    @if($transfer->fee > 0)
                                        <p class="text-sm text-red-600">+ {{ number_format($transfer->fee, 2) }} EUR comisión</p>
                                        <p class="text-xs text-gray-500">Total: {{ number_format($transfer->amount + $transfer->fee, 2) }} EUR</p>
                                    @endif
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <button onclick="showTransferDetails({{ $transfer->id }})" 
                                            class="flex-1 bg-blue-100 text-blue-700 py-2 px-3 rounded text-sm hover:bg-blue-200">
                                        <i class="fas fa-eye mr-1"></i>
                                        Detalles
                                    </button>
                                    
                                    <form action="{{ route('transfers.destroy', $transfer) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-100 text-red-700 py-2 px-3 rounded text-sm hover:bg-red-200" 
                                                onclick="return confirm('¿Revertir esta transferencia? Se restaurarán los balances originales.')">
                                            <i class="fas fa-undo"></i>
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
        {{ $transfers->links() }}
    </div>
@else
    <div class="glass-effect backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-12 text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-teal-600/5"></div>
        <div class="relative z-10">
            <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg animate-float">
                <i class="fas fa-exchange-alt text-white text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-3">No hay transferencias registradas</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">Realiza transferencias inteligentes entre tus cuentas para optimizar tu gestión financiera</p>
            <a href="{{ route('transfers.create') }}" class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 text-white px-8 py-4 rounded-2xl hover:from-green-700 hover:via-emerald-700 hover:to-teal-700 transition-all duration-500 shadow-2xl hover:shadow-3xl group relative overflow-hidden inline-flex items-center">
                <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10 flex items-center">
                    <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center mr-3 group-hover:rotate-180 transition-transform duration-500">
                        <i class="fas fa-plus"></i>
                    </div>
                    <span class="font-bold">Primera Transferencia</span>
                </div>
            </a>
        </div>
    </div>
@endif

<!-- Transfer Details Modal -->
<div id="transferModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Detalles de la Transferencia</h3>
                    <button onclick="closeTransferModal()" class="text-gray-400 hover:text-gray-600">
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
function filterTransfers(period) {
    const cards = document.querySelectorAll('.transfer-card');
    const buttons = document.querySelectorAll('.filter-btn');
    const today = new Date().toISOString().split('T')[0];
    const weekAgo = new Date(Date.now() - 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
    const monthAgo = new Date(Date.now() - 30 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
    
    buttons.forEach(btn => btn.classList.remove('active', 'bg-blue-600', 'text-white'));
    event.target.classList.add('active', 'bg-blue-600', 'text-white');
    
    cards.forEach(card => {
        const cardDate = card.dataset.date;
        let show = false;
        
        switch(period) {
            case 'all':
                show = true;
                break;
            case 'today':
                show = cardDate === today;
                break;
            case 'week':
                show = cardDate >= weekAgo;
                break;
            case 'month':
                show = cardDate >= monthAgo;
                break;
        }
        
        card.style.display = show ? 'block' : 'none';
    });
}

function showTransferDetails(transferId) {
    // In a real implementation, you would fetch transfer details via AJAX
    const modalContent = document.getElementById('modalContent');
    modalContent.innerHTML = `
        <div class="space-y-4">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-semibold text-gray-800 mb-2">Información de la Transferencia</h4>
                <p class="text-sm text-gray-600">ID: #${transferId}</p>
                <p class="text-sm text-gray-600">Estado: Completada</p>
            </div>
            <div class="text-center">
                <p class="text-gray-600">Detalles completos disponibles próximamente</p>
            </div>
        </div>
    `;
    document.getElementById('transferModal').classList.remove('hidden');
}

function closeTransferModal() {
    document.getElementById('transferModal').classList.add('hidden');
}

// Close modal on outside click
document.getElementById('transferModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeTransferModal();
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
</style>
@endsection