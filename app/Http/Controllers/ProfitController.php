<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\Interfaces\TransactionInterface;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    public function __construct(private TransactionInterface $transactionRepository) {}

    public function index(Request $request)
    {
        $dates = $this->transactionRepository->getTransactionDates();

        if ($request->query('start_date') && $request->query('end_date')) {
            $start_date = $request->query('start_date');
            $end_date = $request->query('end_date');
            $profit = $this->transactionRepository->getTransactionByDateRange($start_date, $end_date);
        } else {
            $profit = Transaction::where('transaction_status', 'paid')->sum('total_amount');
        }

        return view('pages.profit.index', compact('profit', 'dates'));
    }
}
