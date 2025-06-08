<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\InvoiceExport;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\Interfaces\TransactionInterface;
use App\Http\Requests\Report\StoreReportRequest;

class ReportController extends Controller
{
    public function __construct(private TransactionInterface $transactionRepository) {}

    public function index(Request $request)
    {
        $dates = $this->transactionRepository->getTransactionDates();

        if ($request->query('start_date') && $request->query('end_date')) {
            $start_date = $request->query('start_date');
            $end_date = $request->query('end_date');
            $profit = $this->transactionRepository->getTransactionByDateRange($start_date, $end_date);
        }

        return view('pages.report.index', compact('dates'));
    }

    public function exportByDate(StoreReportRequest $request)
    {
        $data = $request->validated();

        return Excel::download(new TransactionExport(
            $data['start_date'],
            $data['end_date']
        ), 'invoices.pdf', \Maatwebsite\Excel\Excel::MPDF);
    }

    public function exportByTransaction(Transaction $transaction)
    {
        return Excel::download(new InvoiceExport(
            $transaction
        ), 'invoices.pdf', \Maatwebsite\Excel\Excel::MPDF);
    }
}
