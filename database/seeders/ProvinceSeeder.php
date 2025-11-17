<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $p = Http::get('https://provinces.open-api.vn/api/v1/')->collect()->map(function($item){
            unset($item['districts']);
            return $item;
        })->chunk(50)->toArray();
        DB::table('provinces')->delete();
        foreach($p as $item){
            DB::table('provinces')->insert($item);
        }
    }
}