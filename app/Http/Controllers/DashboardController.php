<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Estadísticas básicas
        $totalBalance = Account::where('user_id', $user->id)->sum('balance');
        $monthlyIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');
        $monthlyExpenses = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');
        
        // Transacciones recientes
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->with(['account', 'category'])
            ->orderBy('transaction_date', 'desc')
            ->limit(5)
            ->get();

        // Gastos por categoría (mes actual)
        $expensesByCategory = Transaction::where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->whereMonth('transactions.transaction_date', now()->month)
            ->whereYear('transactions.transaction_date', now()->year)
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('categories.name', 'categories.color', DB::raw('SUM(transactions.amount) as total'))
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->orderBy('total', 'desc')
            ->get();

        // Evolución últimos 6 meses
        $monthlyEvolution = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $income = Transaction::where('user_id', $user->id)
                ->where('type', 'income')
                ->whereMonth('transaction_date', $date->month)
                ->whereYear('transaction_date', $date->year)
                ->sum('amount');
            $expenses = Transaction::where('user_id', $user->id)
                ->where('type', 'expense')
                ->whereMonth('transaction_date', $date->month)
                ->whereYear('transaction_date', $date->year)
                ->sum('amount');
            
            $monthlyEvolution[] = [
                'month' => $date->format('M Y'),
                'income' => $income,
                'expenses' => $expenses,
                'net' => $income - $expenses
            ];
        }

        // Cuentas con balances y estadísticas
        $accounts = Account::where('user_id', $user->id)
            ->withCount('transactions')
            ->get();

        // Transferencias recientes
        $recentTransfers = \App\Models\Transfer::where('user_id', $user->id)
            ->with(['fromAccount', 'toAccount'])
            ->orderBy('transfer_date', 'desc')
            ->limit(3)
            ->get();

        // Préstamos con alertas
        $activeLoans = \App\Models\Loan::where('user_id', $user->id)
            ->where('status', 'active')
            ->get();
            
        $totalLent = $activeLoans->where('type', 'lent')->sum('remaining_amount');
        $totalBorrowed = $activeLoans->where('type', 'borrowed')->sum('remaining_amount');
        $overdueLoans = $activeLoans->filter(fn($loan) => $loan->isOverdue());
        
        // Objetivos de ahorro (simulado)
        $savingsGoal = 5000; // Esto podría venir de una tabla de objetivos
        $currentSavings = $totalBalance;
        $savingsProgress = $savingsGoal > 0 ? ($currentSavings / $savingsGoal) * 100 : 0;
        
        // Transacciones por día de la semana
        $weeklyPattern = [];
        for ($i = 0; $i < 7; $i++) {
            $dayOfWeek = now()->startOfWeek()->addDays($i);
            $dayExpenses = Transaction::where('transactions.user_id', $user->id)
                ->where('transactions.type', 'expense')
                ->whereRaw('DAYOFWEEK(transactions.transaction_date) = ?', [$dayOfWeek->dayOfWeek + 1])
                ->avg('transactions.amount') ?? 0;
            
            $weeklyPattern[] = [
                'day' => $dayOfWeek->format('D'),
                'amount' => $dayExpenses
            ];
        }
        
        // Top categorías del mes
        $topCategories = Transaction::where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->whereMonth('transactions.transaction_date', now()->month)
            ->whereYear('transactions.transaction_date', now()->year)
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('categories.name', 'categories.color', DB::raw('SUM(transactions.amount) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalBalance',
            'monthlyIncome', 
            'monthlyExpenses',
            'recentTransactions',
            'expensesByCategory',
            'monthlyEvolution',
            'accounts',
            'recentTransfers',
            'totalLent',
            'totalBorrowed',
            'overdueLoans',
            'savingsGoal',
            'savingsProgress',
            'weeklyPattern',
            'topCategories'
        ));
    }
}