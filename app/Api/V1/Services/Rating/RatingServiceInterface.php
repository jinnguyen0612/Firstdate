<?php

namespace App\Api\V1\Services\Rating;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface RatingServiceInterface
{
    public function create(Request $data);
    public function update(Request $data);
}
