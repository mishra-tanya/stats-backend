<?php

namespace App\Http\Controllers\Db3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Db3\Payment;

class PaymentController extends Controller
{
    public function getPayment()
    {
        return $this->fetchAll(Payment::class, 'Payments fetched successfully');
    }
}
