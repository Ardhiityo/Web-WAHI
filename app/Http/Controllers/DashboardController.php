<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Transaction;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboardService) {}

    public function index()
    {
        $data = $this->dashboardService->getDashboardData();

        return view('dashboard', compact('data'));
    }
}
