<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::where('user_id', auth()->id())
            ->withCount('transactions')
            ->get();

        // Estadísticas generales
        $totalBalance = $accounts->sum('balance');
        $totalAccounts = $accounts->count();
        
        // Préstamos activos
        $activeLoans = \App\Models\Loan::where('user_id', auth()->id())
            ->where('status', 'active')
            ->get();
            
        $totalLent = $activeLoans->where('type', 'lent')->sum('remaining_amount');
        $totalBorrowed = $activeLoans->where('type', 'borrowed')->sum('remaining_amount');
        $overdueLoans = $activeLoans->filter(fn($loan) => $loan->isOverdue())->count();
        
        // Transferencias recientes
        $recentTransfers = \App\Models\Transfer::where('user_id', auth()->id())
            ->with(['fromAccount', 'toAccount'])
            ->orderBy('transfer_date', 'desc')
            ->limit(5)
            ->get();

        return view('accounts.index', compact(
            'accounts', 
            'totalBalance', 
            'totalAccounts',
            'totalLent',
            'totalBorrowed', 
            'overdueLoans',
            'recentTransfers'
        ));
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:bank,cash,credit_card,savings,investment,crypto,paypal,business',
            'balance' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3'
        ]);

        $validated['user_id'] = auth()->id();
        
        Account::create($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'Cuenta creada exitosamente');
    }

    public function edit(Account $account)
    {
        return view('accounts.edit', compact('account'));
    }

    public function update(Request $request, Account $account)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:bank,cash,credit_card,savings,investment,crypto,paypal,business',
            'balance' => 'required|numeric',
            'currency' => 'required|string|size:3'
        ]);

        $account->update($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'Cuenta actualizada exitosamente');
    }

    public function destroy(Account $account)
    {
        
        if ($account->transactions()->count() > 0) {
            return redirect()->route('accounts.index')
                ->with('error', 'No se puede eliminar una cuenta con transacciones');
        }

        if (\App\Models\Loan::where('account_id', $account->id)->count() > 0) {
            return redirect()->route('accounts.index')
                ->with('error', 'No se puede eliminar una cuenta con préstamos asociados');
        }

        $account->delete();

        return redirect()->route('accounts.index')
            ->with('success', 'Cuenta eliminada exitosamente');
    }
}