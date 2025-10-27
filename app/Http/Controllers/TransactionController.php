<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', auth()->id())
            ->with(['account', 'category']);

        // Filtros
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('account')) {
            $query->where('account_id', $request->account);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
            ->paginate(20)
            ->withQueryString();

        $accounts = Account::where('user_id', auth()->id())->get();
        $categories = Category::all();

        return view('transactions.index', compact('transactions', 'accounts', 'categories'));
    }

    public function create()
    {
        $accounts = Account::where('user_id', auth()->id())->get();
        $categories = Category::all();
        
        return view('transactions.create', compact('accounts', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'transaction_date' => 'required|date'
        ]);

        $validated['user_id'] = auth()->id();
        
        $transaction = Transaction::create($validated);
        
        // Actualizar balance de la cuenta
        $account = Account::find($validated['account_id']);
        if ($validated['type'] === 'income') {
            $account->increment('balance', $validated['amount']);
        } else {
            $account->decrement('balance', $validated['amount']);
        }

        return redirect()->route('transactions.index')
            ->with('success', 'Transacción creada exitosamente');
    }

    public function destroy(Transaction $transaction)
    {
        // Revertir el balance
        if ($transaction->type === 'income') {
            $transaction->account->decrement('balance', $transaction->amount);
        } else {
            $transaction->account->increment('balance', $transaction->amount);
        }
        
        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transacción eliminada exitosamente');
    }
}