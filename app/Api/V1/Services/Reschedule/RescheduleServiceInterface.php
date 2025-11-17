<?php

namespace App\Api\V1\Services\Reschedule;
use Illuminate\Http\Request;

interface RescheduleServiceInterface
{
    public function createMakeupSession(Request $request);
}