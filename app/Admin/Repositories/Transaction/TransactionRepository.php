<?php

namespace App\Admin\Repositories\Transaction;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Admin\Traits\Setup;
use App\Enums\Transaction\TransactionType;
use App\Models\Partner;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class TransactionRepository extends EloquentRepository implements TransactionRepositoryInterface
{

    use Setup;

    protected $select = [];

    public function getModel(): string
    {
        return Transaction::class;
    }

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }

    public function findOrFailWithRelation($id, $relations = ['from', 'to'])
    {
        return $this->model->with($relations)->findOrFail($id);
    }

    public function getTransactionByPartner(Partner $partner, $limit = 10)
    {
        return $this->model->where(function ($query) use ($partner) {
            $query->where('from_id', $partner->id)
                ->where('from_type', Partner::class);
        })
            ->orWhere(function ($query) use ($partner) {
                $query->where('to_id', $partner->id)
                    ->where('to_type', Partner::class);
            })
            ->orderBy('created_at', 'DESC')
            ->simplePaginate($limit);
    }

    public function countTransactionByPartner(Partner $partner)
    {
        return $this->model->where(function ($query) use ($partner) {
            $query->where('from_id', $partner->id)
                ->where('from_type', Partner::class);
        })
            ->orWhere(function ($query) use ($partner) {
                $query->where('to_id', $partner->id)
                    ->where('to_type', Partner::class);
            })
            ->get()->count();
    }

    public function createTransaction($model_from = null, $model_to = null, $amount = 0, $type, $status, $image = null, $description = null)
    {
        try {
            if ($model_from) {
                $from_type = get_class($model_from);
                $from_id = $model_from->id;
            } else {
                $from_type = null;
                $from_id = null;
            }

            if ($model_to) {
                $to_type = get_class($model_to);
                $to_id = $model_to->id;
            } else {
                $to_type = null;
                $to_id = null;
            }

            return $this->model->create([
                'code' => $this->createCodeTransaction(),
                'from_id' => $from_id,
                'from_type' => $from_type,
                'from_name' => $model_from ? ($model_from->fullname ?? $model_from->name) : null,
                'to_id' => $to_id,
                'to_type' => $to_type,
                'to_name' => $model_to ? ($model_to->name ?? $model_to->fullname) : null,
                'amount' => $amount,
                'type' => $type,
                'status' => $status,
                'image' => $image,
                'description' => $description,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th);
            return false;
        }
    }

    public function getUserProfit()
    {
        $revenue = (float) $this->model->where('from_type', \App\Models\User::class)->where('type', TransactionType::Deposit->value)->sum('amount') ?? 0;
        $cost = (float) ($this->model->where('to_type', \App\Models\User::class)->where('type', TransactionType::Withdraw->value)->sum('amount') ?? 0) * 1000;

        return $revenue - $cost;
    }

    public function getPartnerProfit()
    {
        $revenue = (float) $this->model->where('from_type', \App\Models\Partner::class)->where('type', TransactionType::Deposit->value)->sum('amount') ?? 0;
        $cost = (float) ($this->model->where('to_type', \App\Models\Partner::class)->where('type', TransactionType::Withdraw->value)->sum('amount') ?? 0) * 1000;

        return $revenue - $cost;
    }
}
