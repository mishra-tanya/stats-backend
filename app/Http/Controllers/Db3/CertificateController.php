<?php

namespace App\Http\Controllers\Db3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Db3\Certificate;

class CertificateController extends Controller
{
    public function getCertificate()
    {
        return $this->fetchAll(Certificate::class, 'Certificate fetched successfully');
    }
}
