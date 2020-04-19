<?php

namespace App\Repositories\Contracts;

interface EmergencylineCategoryInterface
{
    public function all();

    public function getEmergencylines($id);

    public function count(): int;

    public function find($id);
}
