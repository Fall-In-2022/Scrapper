<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RedditAPI;

class RedditController extends Controller
{
    public function index(Request $request) {

        //fetch top Reddit posts
        $top = RedditAPI::getTop();

        //fetch top picture posts of Margot Robbie, limit to 100
        $reditData = RedditAPI::search('Margot Robbie ', null, 'top', null, 'pics', 100);

        return response()->json([
            "data" => "testing data"
        ]);
    }
}
