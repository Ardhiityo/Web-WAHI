<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        } else {
            $profit = Transaction::where('transaction_status', 'paid')->sum('total_amount');
        }


        return view('pages.profit.index', compact('profit', 'dates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
