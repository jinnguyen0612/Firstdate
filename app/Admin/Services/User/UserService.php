<?php

namespace App\Admin\Services\User;

use App\Admin\Repositories\District\DistrictRepositoryInterface;
use App\Admin\Repositories\Province\ProvinceRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Traits\Roles;
use Exception;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use App\Enums\User\ZodiacSign;
use App\Traits\UseLog;
use Illuminate\Support\Facades\DB;

class UserService implements UserServiceInterface
{
    use Setup, Roles, UseLog;

    protected array $data;

    protected UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository,
                                protected ProvinceRepositoryInterface $provinceRepository,
                                protected DistrictRepositoryInterface $districtRepository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request): object|false
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['thumbnails'] = $data['thumbnails'] ? explode(",", $data['thumbnails']) : null;
            $data['code'] = uniqid_real();
            $data['zodiac_sign'] = ZodiacSign::getZodiacSign($data['birthday']);
            $province = $this->provinceRepository->getByName($data['province']);
            unset($data['province']);
            $data['province_id'] = $province->id;

            $district = $this->districtRepository->getByName($data['district'],$province->code);
            unset($data['district']);
            $data['district_id'] = $district->id;

            if(isset($data['thumbnails'])){
                $data['thumbnails'] = array_values($data['thumbnails']);
            }

            $datingTimes = $data['dating_time'];
            unset($data['dating_time']);

            $relationship = $data['relationship'];
            unset($data['relationship']);

            $user = $this->repository->create($data);
            $roles = $this->getRoleUser();
            $this->repository->assignRoles($user, [$roles]);

            foreach ($datingTimes as $value) {
                $user->userDatingTimes()->create(['dating_time'=>$value]);
            }

            foreach ($relationship as $value) {
                $user->userRelationship()->create(['relationship'=>$value]);
            }

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process create user', $e);
            return false;
        }
    }

    public function update(Request $request): object|bool
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();

            // Xử lý thumbnails
            if (!empty($data['thumbnails'])) {
                $data['thumbnails'] = array_values(explode(',', $data['thumbnails']));
            } else {
                $data['thumbnails'] = null;
            }

            // Xử lý province & district
            $province = $this->provinceRepository->getByName($data['province']);
            $data['province_id'] = $province->id;
            unset($data['province']);

            $district = $this->districtRepository->getByName($data['district'], $province->code);
            $data['district_id'] = $district->id;
            unset($data['district']);

            // Lấy và loại bỏ các giá trị đặc biệt
            $datingTimes = $data['dating_time'] ?? [];
            unset($data['dating_time']);

            $relationships = $data['relationship'] ?? [];
            unset($data['relationship']);

            // Cập nhật thông tin chính
            $user = $this->repository->update($data['id'], $data);

            // Đồng bộ userDatingTimes
            $existingDatingTimes = $user->userDatingTimes->pluck('dating_time')->toArray();

            if (empty($datingTimes)) {
                $user->userDatingTimes()->delete();
            } else {
                $toDelete = array_diff($existingDatingTimes, $datingTimes);
                $toAdd = array_diff($datingTimes, $existingDatingTimes);

                if (!empty($toDelete)) {
                    $user->userDatingTimes()->whereIn('dating_time', $toDelete)->delete();
                }

                foreach ($toAdd as $dt) {
                    $user->userDatingTimes()->create(['dating_time' => $dt]);
                }
            }

            // Đồng bộ userRelationShip
            $existingRelationships = $user->userRelationShip->pluck('relationship')->toArray();

            if (empty($relationships)) {
                $user->userRelationShip()->delete();
            } else {
                $toDelete = array_diff($existingRelationships, $relationships);
                $toAdd = array_diff($relationships, $existingRelationships);

                if (!empty($toDelete)) {
                    $user->userRelationShip()->whereIn('relationship', $toDelete)->delete();
                }

                foreach ($toAdd as $rel) {
                    $user->userRelationShip()->create(['relationship' => $rel]);
                }
            }

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process update user', $e);
            return false;
        }
    }


    public function delete($id): object|bool
    {
        return $this->repository->delete($id);
    }

    // public function confirm($id): object|bool
    // {
    //     return $this->repository->confirm($id);
    // }

    // public function disable($id): object|bool
    // {
    //     return $this->repository->disable($id);
    // }
}
