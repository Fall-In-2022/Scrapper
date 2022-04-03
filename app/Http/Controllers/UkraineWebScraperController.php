<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ScraperService;

class UkraineWebScraperController extends Controller
{
    public function index(Request $request, ScraperService $scraperService)
    {
        $latitude  = $request->input('lat');
        $longitude = $request->input('long');

        $kyiv_inde_data = $scraperService->scrapKyivIndependent($latitude, $longitude);
        $ukrinform_data = $scraperService->scrapUkrinform($latitude, $longitude);
        $cbs_news_data  = $scraperService->scrapCBS($latitude, $longitude);

        return response()->json($cbs_news_data);
    }
}
