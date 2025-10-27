@extends('layouts.app')

@section('title', 'Nueva Cuenta')
@section('header', 'Nueva Cuenta')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('accounts.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de la cuenta</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           placeholder="Ej: Cuenta Corriente Santander" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de cuenta</label>
                    <select name="type" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Seleccionar tipo</option>
                        <option value="bank" {{ old('type') === 'bank' ? 'selected' : '' }}>Cuenta Bancaria</option>
                        <option value="savings" {{ old('type') === 'savings' ? 'selected' : '' }}>Cuenta de Ahorros</option>
                        <option value="investment" {{ old('type') === 'investment' ? 'selected' : '' }}>Cuenta de Inversión</option>
                        <option value="crypto" {{ old('type') === 'crypto' ? 'selected' : '' }}>Criptomonedas</option>
                        <option value="cash" {{ old('type') === 'cash' ? 'selected' : '' }}>Efectivo</option>
                        <option value="credit_card" {{ old('type') === 'credit_card' ? 'selected' : '' }}>Tarjeta de Crédito</option>
                        <option value="paypal" {{ old('type') === 'paypal' ? 'selected' : '' }}>PayPal</option>
                        <option value="business" {{ old('type') === 'business' ? 'selected' : '' }}>Cuenta Empresarial</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Moneda</label>
                    <select name="currency" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                        <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>USD - Dólar</option>
                        <option value="GBP" {{ old('currency') === 'GBP' ? 'selected' : '' }}>GBP - Libra</option>
                    </select>
                    @error('currency')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Balance inicial</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">€</span>
                        <input type="number" name="balance" value="{{ old('balance', '0') }}" step="0.01" min="0" 
                               class="w-full border border-gray-300 rounded-lg pl-8 pr-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="0.00" required>
                    </div>
                    @error('balance')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-600 mt-1">Introduce el balance actual de esta cuenta</p>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 font-medium">
                    <i class="fas fa-save mr-2"></i>
                    Crear Cuenta
                </button>
                <a href="{{ route('accounts.index') }}" class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-200 text-center font-medium">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection