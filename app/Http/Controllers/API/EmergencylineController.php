<?php

namespace App\Http\Controllers\API;

use App\Repositories\Contracts\EmergencylineInterface;

class EmergencylineController extends  \App\Http\Controllers\Controller
{
    public $emergencyAgencyRepo;

    public function __construct(EmergencylineInterface $emergencyAgencyRepo)
    {
        $this->emergencyAgencyRepo = $emergencyAgencyRepo;
    }

    public function index()
    {
        if ($this->emergencyAgencyRepo->count() === 0) {
            return $this->errorNotFound("no emergencyline available at the moment");
        }
        return $this->emergencyAgencyRepo->getAllEmergencyAgencies();
    }
}
