<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Atymic\Twitter\Facade\Twitter;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;


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


    public function getTweetsByTrends (Request $request) {

        $response = NULL;

        $twitter = Twitter::forApiV1();

        $response = $twitter->getSearch([
            "q"=>'Bucha'
        ]);

        //$response = $twitter->getSearch([
        //    "q"=>"place_country: UA OR point_radius:[51.496372 31.298882 500km]"
        //]);

        return response()->json($response);
    }


    public function getTweetsByLocation (Request $request) {

        $twitter = Twitter::forApiV1();

    }

}
