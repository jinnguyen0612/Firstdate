<?php

namespace App\Traits;

trait CalculateShippingFee
{
    use HasRepositoryFromAdmin;

    public function calculateShippingFee(int $provinceId, int $districtId, int $wardId, int $total)
    {
        $shippingRateRepository = $this->getShippingRateRepository();
        $settingRepository = $this->getSettingRepository();

        // Ưu tiên tìm theo province_id, district_id, ward_id
        $shippingRate = $shippingRateRepository->getBy([
            'province_id' => $provinceId,
            'district_id' => $districtId,
            'ward_id' => $wardId
        ]);

        if (!isset($shippingRate[0])) {
            $shippingRate = $shippingRateRepository->getBy([
                'province_id' => $provinceId,
                'district_id' => $districtId,
                'ward_id' => null
            ]);
        }

        if (!isset($shippingRate[0])) {
            $shippingRate = $shippingRateRepository->getBy([
                'province_id' => $provinceId,
                'district_id' => null,
                'ward_id' => null
            ]);
        }

        $object = $settingRepository->findByField('setting_key', 'object')->plain_value;
        $isValid = $settingRepository->findByField('setting_key', 'is_object_valid')->plain_value;
        if (!isset($shippingRate[0])) {
            $shippingFee = $settingRepository->findByField('setting_key', 'shipping_fee')->plain_value;
            if ($isValid) {
                return $object > $total ? (int) $shippingFee : 0;
            } else {
                return $shippingFee;
            }
        }
        if ($isValid) {
            return $isValid && ($object > $total) ? $shippingRate[0]->price : 0;
        } else {
            return $shippingRate[0]->price;
        }
    }
}
