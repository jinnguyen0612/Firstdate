<?php

namespace App\Admin\Services\Partner;

use App\Admin\Repositories\District\DistrictRepositoryInterface;
use App\Admin\Services\Partner\PartnerServiceInterface;
use App\Admin\Repositories\Partner\PartnerRepositoryInterface;
use App\Admin\Repositories\Province\ProvinceRepositoryInterface;
use App\Admin\Traits\AuthService;
use App\Admin\Traits\Roles;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;

class PartnerService implements PartnerServiceInterface
{
    use Setup, AuthService, Roles;
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    public function __construct(
        PartnerRepositoryInterface $repository,
        protected ProvinceRepositoryInterface $provinceRepository,
        protected DistrictRepositoryInterface $districtRepository
    ) {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        $this->data = $request->validated();
        $this->data['gallery'] = $this->data['gallery'] ? explode(",", $this->data['gallery']) : null;

        $this->data['password'] = bcrypt($this->data['password']);

        if (isset($this->data['gallery'])) {
            $this->data['gallery'] = array_values($this->data['gallery']);
        }

        $this->data['email_verified_at'] = now();

        $province = $this->provinceRepository->getByName($this->data['province']);
        unset($this->data['province']);
        $this->data['province_id'] = $province->id;

        $district = $this->districtRepository->getByName($this->data['district'], $province->code);
        unset($this->data['district']);
        $this->data['district_id'] = $district->id;

        $partner = $this->repository->create($this->data);

        $roles = $this->getRolePartner();
        $this->repository->assignRoles($partner, [$roles]);

        return $partner;
    }

    public function update(Request $request)
    {
        $this->data = $request->validated();

        $this->data['gallery'] = $this->data['gallery'] ? explode(",", $this->data['gallery']) : null;

        if (isset($this->data['gallery'])) {
            $this->data['gallery'] = array_values($this->data['gallery']);
        }

        if (isset($this->data['password'])) {
            $this->data['password'] = bcrypt($this->data['password']);
        }else{
            unset($this->data['password']);
        }

        if (isset($this->data['province'])) {
            $province = $this->provinceRepository->getByName($this->data['province']);
            unset($this->data['province']);
            $this->data['province_id'] = $province->id;
        }

        if (isset($this->data['district'])) {
            $district = $this->districtRepository->getByName($this->data['district'], $province->code);
            unset($this->data['district']);
            $this->data['district_id'] = $district->id;
        }

        $partner = $this->repository->findOrFail($this->data['id']);
        if(isset($this->data['province_id']) && isset($this->data['district_id']) &&
            $this->data['province_id'] == $partner->province_id && $this->data['district_id'] == $partner->district_id &&
            $this->data['address'] == $partner->address){
            $this->data['lng'] = $partner->lng;
            $this->data['lat'] = $partner->lat;
        }

        return $this->repository->update($this->data['id'], $this->data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
