<?php

namespace App\Api\V1\Repositories\Reschedule;

use App\Admin\Repositories\Reschedule\RescheduleRepository as AdminRescheduleRepository;
use App\Api\V1\Repositories\Reschedule\RescheduleRepositoryInterface;
use App\Traits\UseLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RescheduleRepository extends AdminRescheduleRepository implements RescheduleRepositoryInterface
{

}
