@extends('layouts.app')

@section('title', 'Editar Cuenta')
@section('header', 'Editar Cuenta')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="glass-effect backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30 p-6 sm:p-8 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-600/5"></div>
        <div class="relative z-10">
            <form action="{{ route('accounts.update', $account) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de la cuenta</label>
                        <input type="text" name="name" value="{{ old('name', $account->name) }}" 
                               class="w-full glass-effect backdrop-blur-xl border border-white/30 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" 
                               placeholder="Ej: Cuenta Corriente Santander" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de cuenta</label>
                        <select name="type" class="w-full glass-effect backdrop-blur-xl border border-white/30 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="bank" {{ old('type', $account->type) === 'bank' ? 'selected' : '' }}>Cuenta Bancaria</option>
                            <option value="savings" {{ old('type', $account->type) === 'savings' ? 'selected' : '' }}>Cuenta de Ahorros</option>
                            <option value="investment" {{ old('type', $account->type) === 'investment' ? 'selected' : '' }}>Cuenta de Inversión</option>
                            <option value="crypto" {{ old('type', $account->type) === 'crypto' ? 'selected' : '' }}>Criptomonedas</option>
                            <option value="cash" {{ old('type', $account->type) === 'cash' ? 'selected' : '' }}>Efectivo</option>
                            <option value="credit_card" {{ old('type', $account->type) === 'credit_card' ? 'selected' : '' }}>Tarjeta de Crédito</option>
                            <option value="paypal" {{ old('type', $account->type) === 'paypal' ? 'selected' : '' }}>PayPal</option>
                            <option value="business" {{ old('type', $account->type) === 'business' ? 'selected' : '' }}>Cuenta Empresarial</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Moneda</label>
                        <select name="currency" class="w-full glass-effect backdrop-blur-xl border border-white/30 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" required>
                            <option value="EUR" {{ old('currency', $account->currency) === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                            <option value="USD" {{ old('currency', $account->currency) === 'USD' ? 'selected' : '' }}>USD - Dólar</option>
                            <option value="GBP" {{ old('currency', $account->currency) === 'GBP' ? 'selected' : '' }}>GBP - Libra</option>
                        </select>
                        @error('currency')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Balance actual</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">€</span>
                            <input type="number" name="balance" value="{{ old('balance', $account->balance) }}" step="0.01" 
                                   class="w-full glass-effect backdrop-blur-xl border border-white/30 rounded-xl pl-8 pr-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" 
                                   placeholder="0.00" required>
                        </div>
                        @error('balance')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-600 mt-1">Ajusta el balance de la cuenta</p>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-white/20">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-6 rounded-xl hover:from-blue-700 hover:to-indigo-700 font-medium transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i>
                        Actualizar Cuenta
                    </button>
                    <a href="{{ route('accounts.index') }}" class="flex-1 glass-effect backdrop-blur-xl text-gray-700 py-3 px-6 rounded-xl hover:bg-gray-500/20 text-center font-medium transition-all duration-300 border border-white/30">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.glass-effect {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.18);
}
</style>
@endsection