<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\Http\Requests\Report\StoreReportRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $transactionDates = Transaction::select('created_at')->where('transaction_status', 'paid')->orderBy('id', 'desc')->get();
        $dates = [];

        foreach ($transactionDates as $transactionDate) {
            $date = $transactionDate->created_at;
            if (!in_array($date, $dates)) {
                $dates[] = $date;
            }
        }

        if ($request->query('start_date') && $request->query('end_date')) {
            $start_date = $request->query('start_date');
            $end_date = $request->query('end_date');

            $profit = Transaction::where('transaction_status', 'paid')
                ->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('total_amount');
        }

        return view('pages.report.index', compact('dates'));
    }

    public function export(StoreReportRequest $request)
    {
        $data = $request->validated();

        return Excel::download(new TransactionExport(
            $data['start_date'],
            $data['end_date']
        ), 'invoices.pdf', \Maatwebsite\Excel\Excel::MPDF);
    }
}
