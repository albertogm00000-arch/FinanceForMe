<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use App\Models\Category;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $period = $request->get('period', 'month');
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        
        // Configurar fechas según período
        switch ($period) {
            case 'year':
                $startDate = Carbon::create($year, 1, 1);
                $endDate = Carbon::create($year, 12, 31);
                break;
            case 'quarter':
                $quarter = $request->get('quarter', ceil(now()->month / 3));
                $startMonth = ($quarter - 1) * 3 + 1;
                $startDate = Carbon::create($year, $startMonth, 1);
                $endDate = $startDate->copy()->addMonths(2)->endOfMonth();
                break;
            default: // month
                $startDate = Carbon::create($year, $month, 1);
                $endDate = $startDate->copy()->endOfMonth();
        }

        // Resumen financiero
        $totalIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $totalExpenses = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $netIncome = $totalIncome - $totalExpenses;
        $totalBalance = Account::where('user_id', $user->id)->sum('balance');

        // Gastos por categoría
        $expensesByCategory = Transaction::where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.transaction_date', [$startDate, $endDate])
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('categories.name', 'categories.color', DB::raw('SUM(transactions.amount) as total'))
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->orderBy('total', 'desc')
            ->get();

        // Ingresos por categoría
        $incomeByCategory = Transaction::where('transactions.user_id', $user->id)
            ->where('transactions.type', 'income')
            ->whereBetween('transactions.transaction_date', [$startDate, $endDate])
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('categories.name', 'categories.color', DB::raw('SUM(transactions.amount) as total'))
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->orderBy('total', 'desc')
            ->get();

        // Evolución diaria/mensual
        $evolutionData = [];
        if ($period === 'month') {
            // Evolución diaria del mes
            for ($day = 1; $day <= $endDate->day; $day++) {
                $date = Carbon::create($year, $month, $day);
                $dayIncome = Transaction::where('transactions.user_id', $user->id)
                    ->where('transactions.type', 'income')
                    ->whereDate('transactions.transaction_date', $date)
                    ->sum('transactions.amount');
                $dayExpenses = Transaction::where('transactions.user_id', $user->id)
                    ->where('transactions.type', 'expense')
                    ->whereDate('transactions.transaction_date', $date)
                    ->sum('transactions.amount');
                
                $evolutionData[] = [
                    'label' => $date->format('d'),
                    'income' => $dayIncome,
                    'expenses' => $dayExpenses,
                    'net' => $dayIncome - $dayExpenses
                ];
            }
        } else {
            // Evolución mensual del año
            for ($m = 1; $m <= 12; $m++) {
                $monthStart = Carbon::create($year, $m, 1);
                $monthEnd = $monthStart->copy()->endOfMonth();
                
                $monthIncome = Transaction::where('transactions.user_id', $user->id)
                    ->where('transactions.type', 'income')
                    ->whereBetween('transactions.transaction_date', [$monthStart, $monthEnd])
                    ->sum('transactions.amount');
                $monthExpenses = Transaction::where('transactions.user_id', $user->id)
                    ->where('transactions.type', 'expense')
                    ->whereBetween('transactions.transaction_date', [$monthStart, $monthEnd])
                    ->sum('transactions.amount');
                
                $evolutionData[] = [
                    'label' => $monthStart->format('M'),
                    'income' => $monthIncome,
                    'expenses' => $monthExpenses,
                    'net' => $monthIncome - $monthExpenses
                ];
            }
        }

        // Gastos por cuenta
        $expensesByAccount = Transaction::where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.transaction_date', [$startDate, $endDate])
            ->join('accounts', 'transactions.account_id', '=', 'accounts.id')
            ->select('accounts.name', 'accounts.type', DB::raw('SUM(transactions.amount) as total'))
            ->groupBy('accounts.id', 'accounts.name', 'accounts.type')
            ->orderBy('total', 'desc')
            ->get();

        // Top transacciones
        $topExpenses = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->with(['category', 'account'])
            ->orderBy('amount', 'desc')
            ->limit(10)
            ->get();

        // Préstamos activos
        $activeLoans = Loan::where('user_id', $user->id)
            ->where('status', 'active')
            ->get();

        $totalLent = $activeLoans->where('type', 'lent')->sum('remaining_amount');
        $totalBorrowed = $activeLoans->where('type', 'borrowed')->sum('remaining_amount');

        // Comparación con período anterior
        $prevStartDate = $startDate->copy()->subMonths($period === 'month' ? 1 : 12);
        $prevEndDate = $endDate->copy()->subMonths($period === 'month' ? 1 : 12);

        $prevIncome = Transaction::where('transactions.user_id', $user->id)
            ->where('transactions.type', 'income')
            ->whereBetween('transactions.transaction_date', [$prevStartDate, $prevEndDate])
            ->sum('transactions.amount');

        $prevExpenses = Transaction::where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.transaction_date', [$prevStartDate, $prevEndDate])
            ->sum('transactions.amount');

        return view('reports.index', compact(
            'period', 'year', 'month',
            'startDate', 'endDate',
            'totalIncome', 'totalExpenses', 'netIncome', 'totalBalance',
            'expensesByCategory', 'incomeByCategory',
            'evolutionData', 'expensesByAccount', 'topExpenses',
            'totalLent', 'totalBorrowed',
            'prevIncome', 'prevExpenses'
        ));
    }
}