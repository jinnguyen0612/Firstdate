<?php

declare(strict_types=1);

namespace App\Admin\Http\Controllers\Admin;

use App\Admin\Http\Controllers\BaseSearchSelectController;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Http\Resources\Admin\AdminSearchSelectResource;
use App\Admin\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminSearchSelectController extends BaseSearchSelectController
{
    public function __construct(
        AdminRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    protected function selectResponse(): void
    {
        $this->instance = [
            'results' => AdminSearchSelectResource::collection($this->instance)
        ];
    }

    /**
     * Tìm kiếm admin theo role
     */
    public function searchByRole(Request $request)
    {
        $search = $request->get('term');
        $role = $request->get('role');
        $query = Admin::query()
            ->whereHas('roles', function ($query) use ($role) {
                $query->where('name', $role);
            });

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $admins = $query->select('id', 'name', 'email')
            ->limit(10)
            ->get();

        return response()->json([
            'results' => $admins->map(function ($admin) {
                return [
                    'id' => $admin->id,
                    'text' => $admin->name . ' (' . $admin->email . ')'
                ];
            })
        ]);
    }
}
