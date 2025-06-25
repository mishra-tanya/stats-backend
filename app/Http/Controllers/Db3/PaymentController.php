<?php

namespace App\Http\Controllers\Db3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\Db3\Payment;

class PaymentController extends Controller
{
    public function getPayment()
    {
        $payments = Payment::with('user:id,id,name,email')->get();

        return $this->handleSuccess($payments, 'Payments fetched successfully');
    }



    public function paymentStats(Request $request)
    {
        $range = $request->query('range', '7');
        $days = match ($range) {
            '7' => 7,
            '15' => 15,
            '30' => 30,
            '90' => 90,
            '180' => 180,
            '365' => 365,
            default => 7
        };

        $fromDate = Carbon::now()->subDays($days)->startOfDay();

        $results = DB::connection('mysql3')
            ->table('payments')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as payments')
            ->where('created_at', '>=', $fromDate)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $data = collect($results)->map(function ($item) {
            return [
                'name' => $item->date,
                'payments' => $item->payments,
            ];
        });

        return $this->handleSuccess($data, 'Payment stats fetched successfully');
    }

}
