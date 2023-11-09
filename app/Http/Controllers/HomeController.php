<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
use App\Models\Quote;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {   

        $numOfInvoices = Invoice::all()->count();
        $numPaidInvoices = Invoice::where('status', 'Paid')->count();
        $numOfQuotes = Quote::all()->count();
        $totalSumPaidInvoices = Invoice::where('status', 'Paid')->sum('total');

        $invoicesChartData = Invoice::groupBy('created_at')
        ->orderBy('created_at')
        ->get([
            \DB::raw('Date(created_at) as date'),
            \DB::raw('count(*) as count')
        ]);


        $months = collect([
            'January', 'February', 'March', 'April', 'May', 'June', 'July',
            'August', 'September', 'October', 'November', 'December',
        ]);
        
        $paidInvoicesChartData = $months->map(function ($month) {
            return [
                'month' => $month,
                'total_amount' => 0,
            ];
        });
        
        $realData = Invoice::where('status', 'Paid')
            ->select(
                \DB::raw('MONTHNAME(updated_at) as month'),
                \DB::raw('SUM(total) as total_amount')
            )
            ->groupBy(\DB::raw('MONTH(updated_at)'), \DB::raw('MONTHNAME(updated_at)'))
            ->get();
        
        $realData = $realData->pluck('total_amount', 'month');
        
        // Merge the real data into the generated data
        $result = $paidInvoicesChartData->map(function ($data) use ($realData) {
            $totalAmount = $realData->has($data['month']) ? $realData[$data['month']] : 0;
            return [
                'month' => $data['month'],
                'total_amount' => $totalAmount,
            ];
        });
        
        
        



        
        $quotesChartData = Quote::groupBy('created_at')
        ->orderBy('created_at')
        ->get([
            \DB::raw('Date(created_at) as date'),
            \DB::raw('count(*) as count')
        ]);



    

        return view('dashboard', compact('numOfInvoices', 'numPaidInvoices', 'numOfQuotes', 'totalSumPaidInvoices', 'invoicesChartData', 'quotesChartData', 'result'));
    }
}
