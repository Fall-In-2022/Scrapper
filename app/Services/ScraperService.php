<?php

namespace App\Services;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use App\Models\UkraineCity;
use Illuminate\Support\Str;

class ScraperService
{
    public function scrapUkrinform($latitude, $longitude)
    {
        $client  = new Client(HttpClient::create(['timeout' => 60]));
        $url     = 'https://www.ukrinform.net/rubric-ato';
        $crawler = $client->request('GET', $url);

        // article title
        $titles = $crawler->filter('.restList article section h2')->each(function ($node) {
            return $node->text();
        });

        // determin location based on title
        $locations = [];
        $ukraine_cities = UkraineCity::all()
            ->map
            ->only('city_name', 'latitude', 'longitude')
            ->toArray();
        foreach ($titles as $title) {
            $has_location = false;
            $city_key = 0;
            foreach ($ukraine_cities as $index => $city) {
                $contains_ukraine_city = Str::contains($title, $city['city_name']);

                if ($contains_ukraine_city) {
                    $has_location = true;
                    $city_key     = $index;
                }
            }

            if ($has_location && $city_key) {
                array_push($locations, [
                    'title'        => $title, 
                    'has_location' => true,
                    'latitude'     => $ukraine_cities[$city_key]['latitude'],
                    'longitude'    => $ukraine_cities[$city_key]['longitude']
                ]);
                continue;
            }

            array_push($locations, [
                'title'        => $title, 
                'has_location' => false
            ]);
        }
        
        // link to view a specific article details
        $links = $crawler->filter('.restList article section h2 a')->each(function($node){
            $href  = 'https://www.ukrinform.net' . $node->attr('href');
            $text  = $node->text();

            return compact('href', 'text');
        });

        // time of post
        $time = $crawler->filter('.restList article section time')->each(function ($node) {
            return $node->attr('datetime');
        });

        // article image
        $images = $crawler->filter('.restList article figure img ')->each(function ($node) {
            return $node->attr('src');
        });

        return compact('titles', 'locations', 'links', 'time', 'images');
    }
}