<?php

namespace App\Admin\Services\RejectReason;
use Illuminate\Http\Request;

interface RejectReasonServiceInterface
{
    public function update(Request $request);
}