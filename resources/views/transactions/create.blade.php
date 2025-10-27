@extends('layouts.app')

@section('title', 'Nueva Transacción')
@section('header', 'Nueva Transacción')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Type Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Tipo de transacción</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="relative">
                        <input type="radio" name="type" value="income" class="sr-only" required>
                        <div class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-green-300 transition-colors income-option">
                            <div class="flex items-center justify-center mb-2">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-arrow-up text-green-600 text-xl"></i>
                                </div>
                            </div>
                            <p class="text-center font-medium text-gray-800">Ingreso</p>
                            <p class="text-center text-sm text-gray-600">Dinero que recibes</p>
                        </div>
                    </label>
                    
                    <label class="relative">
                        <input type="radio" name="type" value="expense" class="sr-only" required>
                        <div class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-red-300 transition-colors expense-option">
                            <div class="flex items-center justify-center mb-2">
                                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-arrow-down text-red-600 text-xl"></i>
                                </div>
                            </div>
                            <p class="text-center font-medium text-gray-800">Gasto</p>
                            <p class="text-center text-sm text-gray-600">Dinero que gastas</p>
                        </div>
                    </label>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cuenta</label>
                    <select name="account_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Seleccionar cuenta</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                {{ $account->name }} (€{{ number_format($account->balance, 2) }})
                            </option>
                        @endforeach
                    </select>
                    @error('account_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                    <select name="category_id" id="category_select" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Seleccionar categoría</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" data-type="{{ $category->type }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">€</span>
                        <input type="number" name="amount" value="{{ old('amount') }}" step="0.01" min="0.01" 
                               class="w-full border border-gray-300 rounded-lg pl-8 pr-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="0.00" required>
                    </div>
                    @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
                    <input type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    @error('transaction_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                <input type="text" name="description" value="{{ old('description') }}" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                       placeholder="Ej: Compra en supermercado" required>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 font-medium">
                    <i class="fas fa-save mr-2"></i>
                    Guardar Transacción
                </button>
                <a href="{{ route('transactions.index') }}" class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-200 text-center font-medium">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Filter categories based on transaction type
const typeInputs = document.querySelectorAll('input[name="type"]');
const categorySelect = document.getElementById('category_select');
const allOptions = Array.from(categorySelect.options);

typeInputs.forEach(input => {
    input.addEventListener('change', function() {
        const selectedType = this.value;
        
        // Update UI
        document.querySelectorAll('.income-option, .expense-option').forEach(el => {
            el.classList.remove('border-green-500', 'border-red-500', 'bg-green-50', 'bg-red-50');
            el.classList.add('border-gray-200');
        });
        
        if (selectedType === 'income') {
            document.querySelector('.income-option').classList.remove('border-gray-200');
            document.querySelector('.income-option').classList.add('border-green-500', 'bg-green-50');
        } else {
            document.querySelector('.expense-option').classList.remove('border-gray-200');
            document.querySelector('.expense-option').classList.add('border-red-500', 'bg-red-50');
        }
        
        // Filter categories
        categorySelect.innerHTML = '<option value="">Seleccionar categoría</option>';
        
        allOptions.forEach(option => {
            if (option.value && option.dataset.type === selectedType) {
                categorySelect.appendChild(option.cloneNode(true));
            }
        });
    });
});
</script>
@endsection