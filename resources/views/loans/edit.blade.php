@extends('layouts.app')

@section('title', 'Editar Préstamo')
@section('header', 'Editar Préstamo')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <div class="mb-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 {{ $loan->type === 'lent' ? 'bg-green-100' : 'bg-red-100' }} rounded-lg flex items-center justify-center mr-3">
                    <i class="fas {{ $loan->type === 'lent' ? 'fa-hand-holding-usd text-green-600' : 'fa-credit-card text-red-600' }} text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Editando préstamo de {{ $loan->person_name }}</h2>
                    <p class="text-sm text-gray-600">{{ $loan->type === 'lent' ? 'Dinero prestado' : 'Dinero recibido' }}</p>
                </div>
            </div>
        </div>
        
        <form action="{{ route('loans.updateLoan', $loan) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de la persona</label>
                    <input type="text" name="person_name" value="{{ old('person_name', $loan->person_name) }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           required>
                    @error('person_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contacto</label>
                    <input type="text" name="person_contact" value="{{ old('person_contact', $loan->person_contact) }}" 
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
                    <input type="date" name="loan_date" value="{{ old('loan_date', $loan->loan_date->format('Y-m-d')) }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    @error('loan_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha límite</label>
                    <input type="date" name="due_date" value="{{ old('due_date', $loan->due_date?->format('Y-m-d')) }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('due_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Interés %</label>
                    <input type="number" name="interest_rate" value="{{ old('interest_rate', $loan->interest_rate) }}" 
                           step="0.01" min="0" max="100" 
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
                          required>{{ old('description', $loan->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Warning about amount changes -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-yellow-800">Información importante</h4>
                        <p class="text-sm text-yellow-700 mt-1">
                            La cantidad original del préstamo ({{ number_format($loan->amount, 2) }} EUR) y la cantidad pendiente 
                            ({{ number_format($loan->remaining_amount, 2) }} EUR) no se pueden modificar desde aquí. 
                            Para registrar pagos, usa la función "Registrar Pago".
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 font-medium">
                    <i class="fas fa-save mr-2"></i>
                    Guardar Cambios
                </button>
                <a href="{{ route('loans.show', $loan) }}" class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-200 text-center font-medium">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection