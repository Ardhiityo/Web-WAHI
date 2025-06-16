<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\InvoiceExport;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Report\StoreReportRequest;
use App\Services\Interfaces\TransactionInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReportController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private TransactionInterface $transactionRepository) {}

    public function index(Request $request)
    {
        $this->authorize('report.index');

        $dates = $this->transactionRepository->getTransactionDates();

        return view('pages.report.index', compact('dates'));
    }

    public function exportByDate(StoreReportRequest $request)
    {
        $this->authorize('report.export');

        $data = $request->validated();

        return $data['report_type'] === 'pdf' ?
            Excel::download(new TransactionExport(
                $data['start_date'],
                $data['end_date']
            ), 'invoices.pdf', \Maatwebsite\Excel\Excel::MPDF) :
            Excel::download(new TransactionExport(
                $data['start_date'],
                $data['end_date']
            ), 'invoices.xlsx');
    }

    public function exportByTransaction(Transaction $transaction)
    {
        return Excel::download(new InvoiceExport(
            $transaction
        ), 'invoices.pdf', \Maatwebsite\Excel\Excel::MPDF);
    }
}
