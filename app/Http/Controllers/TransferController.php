<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Models\Account;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function index()
    {
        $transfers = Transfer::where('user_id', auth()->id())
            ->with(['fromAccount', 'toAccount'])
            ->orderBy('transfer_date', 'desc')
            ->paginate(20);

        return view('transfers.index', compact('transfers'));
    }

    public function create()
    {
        $accounts = Account::where('user_id', auth()->id())->get();
        return view('transfers.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'from_account_id' => 'required|exists:accounts,id|different:to_account_id',
            'to_account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'transfer_date' => 'required|date',
            'fee' => 'nullable|numeric|min:0'
        ]);

        $validated['user_id'] = auth()->id();
        $validated['fee'] = $validated['fee'] ?? 0;

        // Verificar fondos suficientes
        $fromAccount = Account::find($validated['from_account_id']);
        $totalAmount = $validated['amount'] + $validated['fee'];
        
        if ($fromAccount->balance < $totalAmount) {
            return back()->withErrors(['amount' => 'Fondos insuficientes en la cuenta origen']);
        }

        $transfer = Transfer::create($validated);

        // Actualizar balances
        $fromAccount->decrement('balance', $totalAmount);
        Account::find($validated['to_account_id'])->increment('balance', $validated['amount']);

        return redirect()->route('transfers.index')
            ->with('success', 'Transferencia realizada exitosamente');
    }

    public function destroy(Transfer $transfer)
    {
        $this->authorize('delete', $transfer);
        
        // Revertir transferencia
        $transfer->fromAccount->increment('balance', $transfer->amount + $transfer->fee);
        $transfer->toAccount->decrement('balance', $transfer->amount);
        
        $transfer->delete();

        return redirect()->route('transfers.index')
            ->with('success', 'Transferencia eliminada exitosamente');
    }
}