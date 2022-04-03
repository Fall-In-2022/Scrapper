<?php


namespace App\Helpers;

use Illuminate\Support\Facades\DB;

/**
 * Location Helper Class
 */
class LocationHelper
{
    /**
     * Get Nearest City function
     *
     * @param float $latitude
     * @param float $longitude
     * @return array with cites near by given a latitude and longitude with miles distance
     */
    public static function getNearestCity(float $latitude, float $longitude) {

        $sql = "SELECT city_name, latitude, longitude,
        (DEGREES(ACOS(SIN(RADIANS($latitude)) * SIN(RADIANS(latitude)) +
        COS(RADIANS($latitude)) * COS(RADIANS(latitude)) * COS(RADIANS((($longitude) - (longitude)))))) * 69 ) as miles_away FROM ukraine_cities
        WHERE  (DEGREES(ACOS(SIN(RADIANS($latitude)) * SIN(RADIANS(latitude)) +
        COS(RADIANS($latitude)) * COS(RADIANS(latitude)) * COS(RADIANS((($longitude) - (longitude)))))) * 69 ) <= 20 ORDER BY miles_away ASC";

        return DB::select(DB::raw($sql));

    }
}
