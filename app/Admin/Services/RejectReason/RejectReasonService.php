<?php

namespace App\Admin\Services\RejectReason;

use App\Admin\Services\RejectReason\RejectReasonServiceInterface;
use  App\Admin\Repositories\RejectReason\RejectReasonRepositoryInterface;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use App\Traits\UseLog;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RejectReasonService implements RejectReasonServiceInterface
{
    use Setup, UseLog;
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    public function __construct(RejectReasonRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function update(Request $request)
    {
        $data = $request->validated();
        foreach ($data['reasons'] as $item) {
            if (empty($item['id'])) {
                $reason = $this->repository->create([
                    'reason' => $item['reason'],
                ]);
            } else {
                $this->repository->update($item['id'],[
                    'reason' => $item['reason'],
                    'updated_at' => now(),
                ]);
            }
        }
        return true;
    }
}
