<?php

namespace App\Admin\Services\AppTitle;
use Illuminate\Http\Request;

interface AppTitleServiceInterface
{
    public function update(Request $request);
}