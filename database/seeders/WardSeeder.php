<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class WardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $p = Http::get('https://provinces.open-api.vn/api/w/')->collect()->chunk(100)->toArray();
        DB::table('wards')->delete();
        foreach($p as $item){
            DB::table('wards')->insert($item);
        }
    }
}