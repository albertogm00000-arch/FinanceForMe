@extends('layouts.app')

@section('title', 'Registrar Préstamo')
@section('header', 'Registrar Préstamo')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('loans.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Tipo de Préstamo -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Tipo de préstamo</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="relative">
                        <input type="radio" name="type" value="lent" class="sr-only" required>
                        <div class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-green-300 transition-colors lent-option">
                            <div class="flex items-center justify-center mb-2">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-hand-holding-usd text-green-600 text-xl"></i>
                                </div>
                            </div>
                            <p class="text-center font-medium text-gray-800">Dinero Prestado</p>
                            <p class="text-center text-sm text-gray-600">Le presté dinero a alguien</p>
                        </div>
                    </label>
                    
                    <label class="relative">
                        <input type="radio" name="type" value="borrowed" class="sr-only" required>
                        <div class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-red-300 transition-colors borrowed-option">
                            <div class="flex items-center justify-center mb-2">
                                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-credit-card text-red-600 text-xl"></i>
                                </div>
                            </div>
                            <p class="text-center font-medium text-gray-800">Dinero Prestado</p>
                            <p class="text-center text-sm text-gray-600">Alguien me prestó dinero</p>
                        </div>
                    </label>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cuenta asociada</label>
                    <select name="account_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Seleccionar cuenta</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }} ({{ number_format($account->balance, 2) }} EUR)</option>
                        @endforeach
                    </select>
                    @error('account_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">EUR</span>
                        <input type="number" name="amount" step="0.01" min="0.01" 
                               class="w-full border border-gray-300 rounded-lg pl-12 pr-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="0.00" required>
                    </div>
                    @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de la persona</label>
                    <input type="text" name="person_name" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           placeholder="Ej: Juan Pérez" required>
                    @error('person_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contacto (opcional)</label>
                    <input type="text" name="person_contact" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           placeholder="Teléfono, email, etc.">
                    @error('person_contact')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha del préstamo</label>
                    <input type="date" name="loan_date" value="{{ date('Y-m-d') }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    @error('loan_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha límite (opcional)</label>
                    <input type="date" name="due_date" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('due_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Interés % (opcional)</label>
                    <input type="number" name="interest_rate" step="0.01" min="0" max="100" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           placeholder="0.00">
                    @error('interest_rate')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                <textarea name="description" rows="3" 
                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                          placeholder="Motivo del préstamo, condiciones, etc." required></textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 font-medium">
                    <i class="fas fa-save mr-2"></i>
                    Registrar Préstamo
                </button>
                <a href="{{ route('loans.index') }}" class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-200 text-center font-medium">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
const typeInputs = document.querySelectorAll('input[name="type"]');

typeInputs.forEach(input => {
    input.addEventListener('change', function() {
        const selectedType = this.value;
        
        document.querySelectorAll('.lent-option, .borrowed-option').forEach(el => {
            el.classList.remove('border-green-500', 'border-red-500', 'bg-green-50', 'bg-red-50');
            el.classList.add('border-gray-200');
        });
        
        if (selectedType === 'lent') {
            document.querySelector('.lent-option').classList.remove('border-gray-200');
            document.querySelector('.lent-option').classList.add('border-green-500', 'bg-green-50');
        } else {
            document.querySelector('.borrowed-option').classList.remove('border-gray-200');
            document.querySelector('.borrowed-option').classList.add('border-red-500', 'bg-red-50');
        }
    });
});
</script>
@endsection