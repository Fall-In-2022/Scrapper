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

        $sql = "SELECT *,
        (DEGREES(ACOS(SIN(RADIANS($latitude)) * SIN(RADIANS(latitude)) +
        COS(RADIANS($latitude)) * COS(RADIANS(latitude)) * COS(RADIANS((($longitude) - (longitude)))))) * 69 ) as MI FROM ukraine_cities
        WHERE  (DEGREES(ACOS(SIN(RADIANS($latitude)) * SIN(RADIANS(latitude)) +
        COS(RADIANS($latitude)) * COS(RADIANS(latitude)) * COS(RADIANS((($longitude) - (longitude)))))) * 69 ) <= 20 ORDER BY MI ASC";

        return DB::select( DB::raw($sql));

    }
}
