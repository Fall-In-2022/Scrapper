<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Atymic\Twitter\Facade\Twitter;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UkraineCity;
use Illuminate\Support\Facades\DB;
use App\Helpers\LocationHelper;

class TwitterController extends BaseController
{


    public function trends(Request $request) {

        $response = [];

        //Get Contry info
        $_Ukranine= $this->getContryInfo();

        //Twitter API
        $twitter = Twitter::forApiV1();

        //Ukraine WOEID
        $WOEIDs = [
            "id"=> $_Ukranine->woeid //Ukraine
        ];

        array_push($response, [
            "name"   => "Ukraine",
            "trends" => $twitter->getTrendsPlace($WOEIDs)[0]->trends
        ]);

        /*
        foreach($_Ukranine->places as $town) {

            $name = $town->name;
            $woeid = $town->woeid;

            array_push($response, [
                "name"   => $name,
                "trends" => $twitter->getTrendsPlace(array("id"=>$woeid))[0]->trends
            ]);
        }
        */
        return response()->json($response);
    }

    private function getContryInfo() {

            $filepath = app_path() . "/Twitter/ukraine_woeid.json";

            $content = File::get($filepath);

            return json_decode($content);
    }

    public function getTweetsByCities(Request $request) {

        $response = NULL;

        $this->getCity();

        $rules = [
            'city' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return response()->json([
                "error" => $validator->errors()->all()
            ]);

        }

        $city = $request->get("city");

        $cityDB = UkraineCity::where("city_name", "ilike", $city)->get();

        if($cityDB == []) {
            return response()->json([
                "error" => "No city found in out database"
            ]);
        }

        //Next we do a call to the twitter api trying to find information about that city
        $twitter = Twitter::forApiV1();

        $responseTwitter = $twitter->getSearch([
            "q"=> $cityDB[0]->city_name
        ]);


        $response = (object) [
            "city_name" => $cityDB[0]->city_name,
            "latitude"  => $cityDB[0]->latitude,
            "longitude" => $cityDB[0]->longitude,
            "tweets"    => $responseTwitter
        ];

        return response()->json($response);

    }

    public function getTweetsByGeo(Request $request) {

        $response = [];

        $rules = [
            'latitude'  => 'required',
            'longitude' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors()->all()
            ]);
        }

        $latitude  = $request->get("latitude");
        $longitude = $request->get("longitude");

        $cities = LocationHelper::getNearestCity($latitude, $longitude);

        //Next we do a call to the twitter api trying to find information about that city
        $twitter = Twitter::forApiV1();

        foreach($cities as $city) {

            $responseTwitter = $twitter->getSearch([
                "q"=> $city->city_name
            ]);

            $data = [
                "city_info" => $city,
                "tweets" => $responseTwitter
            ];

            array_push($response, $data);
        }

        return response()->json($response);

    }

    public function getTweetsByTrends (Request $request) {

        $response = NULL;

        $rules = [
            'trend' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return response()->json([
                "error" => $validator->errors()->all()
            ]);

        }

        $trend = $request->get("trend");
        $coord = NULL;

        if($request->has("lat") && $request->has("long") && $request->has("rad") ) {
            $coord = (object) [
                "lat"  => $request->get("lat"),
                "long" => $request->get("long"),
                "rad"  => $request->get("rad")
            ];
        }

        $twitter = Twitter::forApiV1();

        if($coord != NULL) {
            $lat  = $coord->lat;
            $long = $coord->long;
            $rad  = $coord->rad;
            $response = $twitter->getSearch([
                "q"=>"$trend place_country:UA OR point_radius:[$lat $long $rad]"
            ]);
        } else {
            $response = $twitter->getSearch([
                "q"=>"$trend has:geo place_country: UA"
            ]);
        }

        return response()->json($response);
    }

    public function geoDecoder(Request $request) {

        $rules = [
            'lat' => 'required',
            'long' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors()->all()
            ]);
        }

        $response = NULL;

        $twitter = Twitter::forApiV1();

        $params = [
            "lat"=> $request->get('lat'),
            "long"=>  $request->get('long')
        ];

        $response = $twitter->getGeoReverse($params);

        return response()->json($response);

    }

}
