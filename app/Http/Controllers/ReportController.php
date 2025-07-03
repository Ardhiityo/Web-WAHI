<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\InvoiceExport;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Report\StoreReportRequest;
use App\Services\Interfaces\TransactionInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;
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
            ), 'reports.pdf', \Maatwebsite\Excel\Excel::MPDF) :
            Excel::download(new TransactionExport(
                $data['start_date'],
                $data['end_date']
            ), 'reports.xlsx');
    }

    public function exportByTransaction(Transaction $transaction)
    {
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [58, 90], // 58mm width x 150mm height
            'margin_top' => 2,
            'margin_bottom' => 2,
            'margin_left' => 2,
            'margin_right' => 2,
        ]);

        $transaction = $transaction->load([
            'products' => fn(Builder $query) => $query->with('brand:id,name')->select('id', 'name', 'brand_id'),
            'user' => fn(Builder $query) => $query->select('id', 'name')
        ]);

        $html = view('exports.invoice.index', compact('transaction'))->render();

        $mpdf->WriteHTML($html);
        return response($mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="invoice-' . $transaction->transaction_code . '.pdf"');
    }
}
