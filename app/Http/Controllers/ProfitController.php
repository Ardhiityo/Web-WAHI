<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Services\Interfaces\TransactionInterface;

class ProfitController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private TransactionInterface $transactionRepository) {}

    public function index(Request $request)
    {
        $this->authorize('profit.index');

        $dates = $this->transactionRepository->getTransactionPaidDates();

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
