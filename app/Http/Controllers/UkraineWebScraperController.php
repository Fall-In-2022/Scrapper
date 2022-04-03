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

        $ukrinform_data = $scraperService->scrapUkrinform($latitude, $longitude);

        return response()->json($ukrinform_data);
    }
}
