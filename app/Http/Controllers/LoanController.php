<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Account;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::where('user_id', auth()->id())
            ->with('account')
            ->orderBy('loan_date', 'desc')
            ->paginate(20);

        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $accounts = Account::where('user_id', auth()->id())->get();
        return view('loans.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'type' => 'required|in:lent,borrowed',
            'person_name' => 'required|string|max:255',
            'person_contact' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string',
            'loan_date' => 'required|date',
            'due_date' => 'nullable|date|after:loan_date',
            'interest_rate' => 'nullable|numeric|min:0|max:100'
        ]);

        $validated['user_id'] = auth()->id();
        $validated['remaining_amount'] = $validated['amount'];
        $validated['interest_rate'] = $validated['interest_rate'] ?? 0;

        $loan = Loan::create($validated);

        // Actualizar balance de cuenta
        $account = Account::find($validated['account_id']);
        if ($validated['type'] === 'lent') {
            $account->decrement('balance', $validated['amount']);
        } else {
            $account->increment('balance', $validated['amount']);
        }

        return redirect()->route('loans.index')
            ->with('success', 'Préstamo registrado exitosamente');
    }

    public function show(Loan $loan)
    {
        $this->authorize('view', $loan);
        return view('loans.show', compact('loan'));
    }

    public function update(Request $request, Loan $loan)
    {
        $this->authorize('update', $loan);
        
        $validated = $request->validate([
            'payment_amount' => 'required|numeric|min:0.01|max:' . $loan->remaining_amount,
            'payment_date' => 'required|date'
        ]);

        $loan->remaining_amount -= $validated['payment_amount'];
        
        if ($loan->remaining_amount <= 0) {
            $loan->status = 'paid';
            $loan->remaining_amount = 0;
        }
        
        $loan->save();

        // Actualizar balance de cuenta
        if ($loan->type === 'lent') {
            $loan->account->increment('balance', $validated['payment_amount']);
        } else {
            $loan->account->decrement('balance', $validated['payment_amount']);
        }

        return redirect()->route('loans.show', $loan)
            ->with('success', 'Pago registrado exitosamente');
    }

    public function edit(Loan $loan)
    {
        $this->authorize('update', $loan);
        return view('loans.edit', compact('loan'));
    }

    public function updateLoan(Request $request, Loan $loan)
    {
        $this->authorize('update', $loan);
        
        $validated = $request->validate([
            'person_name' => 'required|string|max:255',
            'person_contact' => 'nullable|string|max:255',
            'description' => 'required|string',
            'loan_date' => 'required|date',
            'due_date' => 'nullable|date|after:loan_date',
            'interest_rate' => 'nullable|numeric|min:0|max:100'
        ]);

        $validated['interest_rate'] = $validated['interest_rate'] ?? 0;
        $loan->update($validated);

        return redirect()->route('loans.show', $loan)
            ->with('success', 'Préstamo actualizado exitosamente');
    }

    public function destroy(Loan $loan)
    {
        $this->authorize('delete', $loan);
        
        // Revertir balance si el préstamo está activo
        if ($loan->status === 'active') {
            $paidAmount = $loan->amount - $loan->remaining_amount;
            
            if ($loan->type === 'lent') {
                $loan->account->increment('balance', $loan->remaining_amount);
                $loan->account->decrement('balance', $paidAmount);
            } else {
                $loan->account->decrement('balance', $loan->remaining_amount);
                $loan->account->increment('balance', $paidAmount);
            }
        }

        $loan->delete();

        return redirect()->route('loans.index')
            ->with('success', 'Préstamo eliminado exitosamente');
    }
}