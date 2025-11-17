<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $d = Http::get('https://provinces.open-api.vn/api/v1/d/')->collect()->map(function($item){
            unset($item['wards']);
            return $item;
        })->chunk(50)->toArray();
        DB::table('districts')->delete();
        foreach($d as $item){
            DB::table('districts')->insert($item);
        }
    }
}