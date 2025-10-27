@extends('layouts.app')

@section('title', 'Nueva Transferencia')
@section('header', 'Transferir Dinero')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('transfers.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cuenta origen</label>
                    <select name="from_account_id" id="from_account" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Seleccionar cuenta origen</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" data-balance="{{ $account->balance }}" {{ request('from') == $account->id ? 'selected' : '' }}>
                                {{ $account->name }} ({{ number_format($account->balance, 2) }} EUR)
                            </option>
                        @endforeach
                    </select>
                    @error('from_account_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p id="balance_info" class="text-sm text-gray-600 mt-1"></p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cuenta destino</label>
                    <select name="to_account_id" id="to_account" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Seleccionar cuenta destino</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                    @error('to_account_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad a transferir</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">EUR</span>
                        <input type="number" name="amount" id="amount" step="0.01" min="0.01" 
                               class="w-full border border-gray-300 rounded-lg pl-12 pr-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="0.00" required>
                    </div>
                    @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Comisión (opcional)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">EUR</span>
                        <input type="number" name="fee" step="0.01" min="0" 
                               class="w-full border border-gray-300 rounded-lg pl-12 pr-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="0.00">
                    </div>
                    @error('fee')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de transferencia</label>
                    <input type="date" name="transfer_date" value="{{ date('Y-m-d') }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    @error('transfer_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-end">
                    <div class="w-full bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-600 mb-1">Total a descontar:</p>
                        <p id="total_amount" class="text-lg font-semibold text-gray-800">0.00 EUR</p>
                    </div>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                <input type="text" name="description" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                       placeholder="Motivo de la transferencia" required>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Transfer Preview -->
            <div id="transfer_preview" class="bg-blue-50 border border-blue-200 rounded-lg p-4 hidden">
                <h4 class="font-medium text-blue-800 mb-2">Resumen de la transferencia:</h4>
                <div class="space-y-1 text-sm text-blue-700">
                    <p><span class="font-medium">De:</span> <span id="preview_from"></span></p>
                    <p><span class="font-medium">A:</span> <span id="preview_to"></span></p>
                    <p><span class="font-medium">Cantidad:</span> <span id="preview_amount"></span></p>
                    <p><span class="font-medium">Comisión:</span> <span id="preview_fee"></span></p>
                    <p><span class="font-medium">Total:</span> <span id="preview_total"></span></p>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t">
                <button type="submit" id="submit_btn" class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 font-medium disabled:bg-gray-400" disabled>
                    <i class="fas fa-exchange-alt mr-2"></i>
                    Realizar Transferencia
                </button>
                <a href="{{ route('accounts.index') }}" class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-200 text-center font-medium">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
const fromAccount = document.getElementById('from_account');
const toAccount = document.getElementById('to_account');
const amountInput = document.getElementById('amount');
const feeInput = document.querySelector('input[name="fee"]');
const totalAmount = document.getElementById('total_amount');
const balanceInfo = document.getElementById('balance_info');
const transferPreview = document.getElementById('transfer_preview');
const submitBtn = document.getElementById('submit_btn');

function updatePreview() {
    const fromSelected = fromAccount.selectedOptions[0];
    const toSelected = toAccount.selectedOptions[0];
    const amount = parseFloat(amountInput.value) || 0;
    const fee = parseFloat(feeInput.value) || 0;
    const total = amount + fee;
    
    totalAmount.textContent = total.toFixed(2) + ' EUR';
    
    if (fromSelected && fromSelected.value) {
        const balance = parseFloat(fromSelected.dataset.balance);
        balanceInfo.textContent = `Balance disponible: ${balance.toFixed(2)} EUR`;
        
        if (total > balance) {
            balanceInfo.className = 'text-sm text-red-600 mt-1';
            balanceInfo.textContent += ' - Fondos insuficientes';
            submitBtn.disabled = true;
        } else {
            balanceInfo.className = 'text-sm text-gray-600 mt-1';
            submitBtn.disabled = false;
        }
    }
    
    if (fromSelected && toSelected && fromSelected.value && toSelected.value && amount > 0) {
        document.getElementById('preview_from').textContent = fromSelected.textContent;
        document.getElementById('preview_to').textContent = toSelected.textContent;
        document.getElementById('preview_amount').textContent = amount.toFixed(2) + ' EUR';
        document.getElementById('preview_fee').textContent = fee.toFixed(2) + ' EUR';
        document.getElementById('preview_total').textContent = total.toFixed(2) + ' EUR';
        transferPreview.classList.remove('hidden');
    } else {
        transferPreview.classList.add('hidden');
    }
}

fromAccount.addEventListener('change', updatePreview);
toAccount.addEventListener('change', updatePreview);
amountInput.addEventListener('input', updatePreview);
feeInput.addEventListener('input', updatePreview);

// Filter destination accounts
fromAccount.addEventListener('change', function() {
    const selectedFromId = this.value;
    const toOptions = toAccount.querySelectorAll('option');
    
    toOptions.forEach(option => {
        if (option.value === selectedFromId) {
            option.style.display = 'none';
        } else {
            option.style.display = 'block';
        }
    });
    
    if (toAccount.value === selectedFromId) {
        toAccount.value = '';
    }
});

updatePreview();
</script>
@endsection