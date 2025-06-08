<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\TransactionInterface;

class ProfitController extends Controller
{
    public function __construct(private TransactionInterface $transactionRepository) {}

    public function index(Request $request)
    {
        if (!Auth::user()->hasRole('owner')) {
            return abort(403, 'Unauthorized action.');
        }

        $dates = $this->transactionRepository->getTransactionDates();

        if ($request->query('start_date') && $request->query('end_date')) {
            $start_date = $request->query('start_date');
            $end_date = $request->query('end_date');
            $profit = $this->transactionRepository->getTransactionProfitByDateRange($start_date, $end_date);
        } else {
            $profit = $this->transactionRepository->getTotalTransactionProfit();
        }

        return view('pages.profit.index', compact('profit', 'dates'));
    }
}
