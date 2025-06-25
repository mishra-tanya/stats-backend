<?php

namespace App\Http\Controllers\Db3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Db3\Certificate;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CertificateController extends Controller
{
    public function getCertificate()
    {
        $data = Certificate::with('user:id,id,email')->get();

        return $this->handleSuccess($data, 'Certificates fetched successfully');
    }

    public function certificateStats(Request $request)
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
            ->table('certificate') 
            ->selectRaw('DATE(created_at) as date, COUNT(*) as certificates')
            ->where('created_at', '>=', $fromDate)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $data = collect($results)->map(function ($item) {
            return [
                'name' => $item->date,
                'certificates' => $item->certificates,
            ];
        });

        return $this->handleSuccess($data, 'Certificate stats fetched successfully');
    }
}
