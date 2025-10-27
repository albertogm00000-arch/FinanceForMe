<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\TransferController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);
    
    if (auth()->attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }
    
    return back()->withErrors([
        'email' => 'Las credenciales no coinciden con nuestros registros.'
    ]);
});

Route::post('/register', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed'
    ]);
    
    $user = \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password'])
    ]);
    
    auth()->login($user);
    
    return redirect('/dashboard');
});

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('transactions', TransactionController::class);
    Route::resource('accounts', AccountController::class);
    Route::resource('loans', LoanController::class);
    Route::resource('transfers', TransferController::class)->except(['edit', 'update', 'show']);
    Route::patch('/loans/{loan}/payment', [LoanController::class, 'update'])->name('loans.payment');
    Route::put('/loans/{loan}/update', [LoanController::class, 'updateLoan'])->name('loans.updateLoan');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});
