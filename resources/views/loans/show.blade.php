@extends('layouts.app')

@section('title', 'Detalle del Préstamo')
@section('header', 'Detalle del Préstamo')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex items-center">
                <div class="w-16 h-16 {{ $loan->type === 'lent' ? 'bg-green-100' : 'bg-red-100' }} rounded-xl flex items-center justify-center mr-4">
                    <i class="fas {{ $loan->type === 'lent' ? 'fa-hand-holding-usd text-green-600' : 'fa-credit-card text-red-600' }} text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $loan->person_name }}</h1>
                    <p class="text-gray-600">
                        {{ $loan->type === 'lent' ? 'Le presté dinero' : 'Me prestó dinero' }}
                        @if($loan->person_contact)
                            • {{ $loan->person_contact }}
                        @endif
                    </p>
                    <p class="text-sm text-gray-500">Cuenta: {{ $loan->account->name }}</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                @if($loan->isOverdue())
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Vencido
                    </span>
                @elseif($loan->status === 'paid')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i class="fas fa-check mr-2"></i>
                        Pagado
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <i class="fas fa-clock mr-2"></i>
                        Activo
                    </span>
                @endif
                
                <a href="{{ route('loans.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Loan Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Información del Préstamo</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Cantidad Original</label>
                        <p class="text-xl font-bold text-gray-800">{{ number_format($loan->amount, 2) }} EUR</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Cantidad Pendiente</label>
                        <p class="text-xl font-bold {{ $loan->type === 'lent' ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($loan->remaining_amount, 2) }} EUR
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Fecha del Préstamo</label>
                        <p class="text-gray-800">{{ $loan->loan_date->format('d/m/Y') }}</p>
                    </div>
                    
                    @if($loan->due_date)
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Fecha Límite</label>
                            <p class="text-gray-800 {{ $loan->isOverdue() ? 'text-red-600 font-semibold' : '' }}">
                                {{ $loan->due_date->format('d/m/Y') }}
                                @if($loan->isOverdue())
                                    <span class="text-red-600 text-sm">(Vencido)</span>
                                @endif
                            </p>
                        </div>
                    @endif
                    
                    @if($loan->interest_rate > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Tasa de Interés</label>
                            <p class="text-gray-800">{{ $loan->interest_rate }}% anual</p>
                        </div>
                    @endif
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Progreso</label>
                        <div class="flex items-center space-x-3">
                            <div class="flex-1 bg-gray-200 rounded-full h-3">
                                <div class="bg-blue-600 h-3 rounded-full transition-all duration-300" 
                                     style="width: {{ $loan->progress_percentage }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-700">{{ number_format($loan->progress_percentage, 1) }}%</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Descripción</label>
                    <p class="text-gray-800 bg-gray-50 p-4 rounded-lg">{{ $loan->description }}</p>
                </div>
            </div>
            
            <!-- Payment History -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Historial de Pagos</h2>
                    @if($loan->status === 'active')
                        <button onclick="openPaymentModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            <i class="fas fa-plus mr-2"></i>
                            Registrar Pago
                        </button>
                    @endif
                </div>
                
                @php
                    $paidAmount = $loan->amount - $loan->remaining_amount;
                @endphp
                
                @if($paidAmount > 0)
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-green-800">Cantidad Pagada</p>
                                    <p class="text-sm text-green-600">Total de pagos realizados</p>
                                </div>
                            </div>
                            <p class="font-bold text-green-800">{{ number_format($paidAmount, 2) }} EUR</p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-receipt text-4xl mb-3"></i>
                        <p>No hay pagos registrados aún</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Acciones Rápidas</h3>
                <div class="space-y-3">
                    @if($loan->status === 'active')
                        <button onclick="openPaymentModal()" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 flex items-center justify-center">
                            <i class="fas fa-money-bill mr-2"></i>
                            Registrar Pago
                        </button>
                        
                        @if($loan->remaining_amount > 0)
                            <button onclick="markAsPaid()" class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 flex items-center justify-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                Marcar como Pagado
                            </button>
                        @endif
                    @endif
                    
                    <a href="{{ route('loans.edit', $loan) }}" class="w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Préstamo
                    </a>
                    
                    <form action="{{ route('loans.destroy', $loan) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-100 text-red-700 py-3 px-4 rounded-lg hover:bg-red-200 flex items-center justify-center" 
                                onclick="return confirm('¿Estás seguro de eliminar este préstamo?')">
                            <i class="fas fa-trash mr-2"></i>
                            Eliminar Préstamo
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Contact Info -->
            @if($loan->person_contact)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Información de Contacto</h3>
                    <div class="space-y-2">
                        <p class="text-sm text-gray-600">Persona:</p>
                        <p class="font-medium text-gray-800">{{ $loan->person_name }}</p>
                        <p class="text-sm text-gray-600 mt-3">Contacto:</p>
                        <p class="text-gray-800">{{ $loan->person_contact }}</p>
                    </div>
                </div>
            @endif
            
            <!-- Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Resumen</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tipo:</span>
                        <span class="font-medium">{{ $loan->type === 'lent' ? 'Dinero prestado' : 'Dinero recibido' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Estado:</span>
                        <span class="font-medium capitalize">{{ $loan->status === 'active' ? 'Activo' : 'Pagado' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Cuenta:</span>
                        <span class="font-medium">{{ $loan->account->name }}</span>
                    </div>
                    @if($loan->due_date)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Días restantes:</span>
                            <span class="font-medium {{ $loan->isOverdue() ? 'text-red-600' : '' }}">
                                @if($loan->isOverdue())
                                    {{ $loan->due_date->diffInDays(now()) }} días vencido
                                @else
                                    {{ now()->diffInDays($loan->due_date) }} días
                                @endif
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

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
                
                <form action="{{ route('loans.payment', $loan) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Cantidad pendiente: <span class="font-semibold">{{ number_format($loan->remaining_amount, 2) }} EUR</span></p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad del pago</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">EUR</span>
                            <input type="number" name="payment_amount" step="0.01" min="0.01" max="{{ $loan->remaining_amount }}"
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
function openPaymentModal() {
    document.getElementById('paymentModal').classList.remove('hidden');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
}

function markAsPaid() {
    if (confirm('¿Marcar este préstamo como completamente pagado?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("loans.payment", $loan) }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PATCH';
        
        const amountField = document.createElement('input');
        amountField.type = 'hidden';
        amountField.name = 'payment_amount';
        amountField.value = '{{ $loan->remaining_amount }}';
        
        const dateField = document.createElement('input');
        dateField.type = 'hidden';
        dateField.name = 'payment_date';
        dateField.value = '{{ date("Y-m-d") }}';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        form.appendChild(amountField);
        form.appendChild(dateField);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Close modal on outside click
document.getElementById('paymentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePaymentModal();
    }
});
</script>
@endsection