<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ukraine_cities_path = public_path('ukraine_cities.json');
        $ukraine_cities_data = json_decode(file_get_contents($ukraine_cities_path), true);

        foreach ($ukraine_cities_data as $ukraine_city) {
            DB::table('ukraine_cities')->insert([
                'city_name'  => $ukraine_city['city'],
                'latitude'   => $ukraine_city['lat'],
                'longitude'  => $ukraine_city['lng'],
                'population' => $ukraine_city['population'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('ukraine_cities')->truncate();
    }
};
