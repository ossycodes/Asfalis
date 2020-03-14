<?php

namespace App\Http\Controllers\API;

use App\Repositories\Contracts\EmergencylineInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmergencylineController extends  \App\Http\Controllers\Controller
{
    public $emergencyAgencyRepo;

    public function __construct(EmergencylineInterface $emergencyAgencyRepo)
    {
        $this->emergencyAgencyRepo = $emergencyAgencyRepo;
    }

    public function index()
    {
        return $this->emergencyAgencyRepo->getAllEmergencyAgencies();
    }
}
