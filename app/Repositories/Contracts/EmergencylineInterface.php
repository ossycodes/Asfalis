<?php

namespace App\Repositories\Contracts;

interface EmergencylineInterface
{
    public function count();
    
    public function getAllEmergencyAgencies();
}
