<?php

namespace App\Api\V1\Services\Booking;
use Illuminate\Http\Request;

interface BookingServiceInterface 
{
    public function payDeposit($dealId);	
}