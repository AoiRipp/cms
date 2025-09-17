<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;
use App\Models\Regency;

class RegencySeeder extends Seeder
{
    public function run(): void
    {
        $regencies = [
            'DKI Jakarta' => [
                'Kabupaten Kepulauan Seribu',
                'Kota Jakarta Barat',
                'Kota Jakarta Pusat',
                'Kota Jakarta Selatan',
                'Kota Jakarta Timur',
                'Kota Jakarta Utara',
            ],
            'Jawa Barat' => [
                'Kabupaten Bogor',
                'Kota Bogor',
                'Kota Depok',
                'Kabupaten Bekasi',
                'Kota Bekasi',
            ],
            'Banten' => [
                'Kabupaten Tangerang',
                'Kota Tangerang',
                'Kota Tangerang Selatan',
            ],
        ];

        foreach ($regencies as $provinceName => $cities) {
            $province = Province::where('name', $provinceName)->first();
            if ($province) {
                foreach ($cities as $city) {
                    Regency::updateOrCreate(
                        [
                            'province_id' => $province->id,
                            'name' => $city,
                        ],
                        [
                            'status' => true
                        ]
                    );
                }
            }
        }
    }
}
