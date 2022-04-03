<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ScraperService;
use Illuminate\Support\Facades\Validator;

class UkraineWebScraperController extends Controller
{
    public function index(Request $request, ScraperService $scraperService)
    {

        $rules = [
            'lat'  => 'required',
            'long' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors()->all()
            ]);
        }

        $latitude  = $request->input('lat');
        $longitude = $request->input('long');

        $kyiv_inde_data = $scraperService->scrapKyivIndependent($latitude, $longitude);
        $ukrinform_data = $scraperService->scrapUkrinform($latitude, $longitude);
        $cbs_news_data  = $scraperService->scrapCBS($latitude, $longitude);
        $twitter_data = $scraperService->twitter($latitude, $longitude);

        $scraped_data = array_merge($kyiv_inde_data, $ukrinform_data, $cbs_news_data, $twitter_data);

        return response()->json($scraped_data);
    }
}
