<?php

namespace App\Http\Controllers\Db4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\FinanceEmissionService;

class EmissionController extends Controller
{
    protected $service;

    public function __construct(FinanceEmissionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->getAllEmissions();
        return $this->handleSuccess($data, 'Finance Emission fetched successfully');
    }

    public function show($userId)
    {
        $data = $this->service->getEmissionByUser($userId);
        return $this->handleSuccess($data, 'Finance emission for user fetched successfully');
    }
}
