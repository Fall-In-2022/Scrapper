<?php

namespace App\Services;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use App\Models\UkraineCity;
use Illuminate\Support\Str;

class ScraperService
{
    public function scrapKyivIndependent($latitude, $longitude)
    {
        $client  = new Client(HttpClient::create(['timeout' => 60]));
        $url     = 'https://kyivindependent.com/tag/russias-war';
        $crawler = $client->request('GET', $url);

        $titles = $crawler->filter('section.recent-posts article.post section.entry-body h3.entry-title a')->each(function ($node) {
            return $node->text();
        });

        $links = $crawler->filter('section.recent-posts article.post section.entry-body h3.entry-title a')->each(function($node){
            return $node->attr('href');
        });

        $time = $crawler->filter('section.recent-posts article.post section.entry-body div.entry-meta time.entry-date')->each(function ($node) {
            return $node->attr('datetime');
        });

        $images = $crawler->filter('section.recent-posts article.post div.post-thumb img')->each(function ($node) {
            return $node->attr('src');
        });

        // determin location based on title
        $scraped_data   = [];
        $ukraine_cities = UkraineCity::all()
            ->map
            ->only('city_name', 'latitude', 'longitude')
            ->toArray();
        foreach ($titles as $key => $title) {
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
                array_push($scraped_data, [
                    'title'        => $title,
                    'link'         => $links[$key],
                    'time'         => $time[$key],
                    'image'        => $images[$key],
                    'has_location' => true,
                    'latitude'     => $ukraine_cities[$city_key]['latitude'],
                    'longitude'    => $ukraine_cities[$city_key]['longitude'],
                ]);
                continue;
            }
        }

        return $scraped_data;
    }

    public function scrapUkrinform($latitude, $longitude)
    {
        $client  = new Client(HttpClient::create(['timeout' => 60]));
        $url     = 'https://www.ukrinform.net/rubric-ato';
        $crawler = $client->request('GET', $url);

        // article title
        $titles = $crawler->filter('.restList article section h2')->each(function ($node) {
            return $node->text();
        });
        
        // link to view a specific article details
        $links = $crawler->filter('.restList article section h2 a')->each(function($node){
            return 'https://www.ukrinform.net' . $node->attr('href');
        });

        // time of post
        $time = $crawler->filter('.restList article section time')->each(function ($node) {
            return $node->attr('datetime');
        });

        // article image
        $images = $crawler->filter('.restList article figure img ')->each(function ($node) {
            return $node->attr('src');
        });

        // determin location based on title
        $scraped_data   = [];
        $ukraine_cities = UkraineCity::all()
            ->map
            ->only('city_name', 'latitude', 'longitude')
            ->toArray();
        foreach ($titles as $key => $title) {
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
                array_push($scraped_data, [
                    'title'        => $title,
                    'link'         => $links[$key],
                    'time'         => $time[$key],
                    'image'        => $images[$key],
                    'has_location' => true,
                    'latitude'     => $ukraine_cities[$city_key]['latitude'],
                    'longitude'    => $ukraine_cities[$city_key]['longitude'],
                ]);
                continue;
            }

            // DO NOT include articles that does not have a coordinate
            /*array_push($scraped_data, [
                'title'        => $title,
                'link'         => $links[$key],
                'time'         => $time[$key],
                'image'        => $images[$key],
                'has_location' => false,
                'latitude'     => 0,
                'longitude'    => 0,
            ]);*/
        }

        return $scraped_data;
    }
    public function scrapCBS($latitude, $longitude)
    {
        $client  = new Client(HttpClient::create(['timeout' => 60]));
        $url     = 'https://www.cbsnews.com/ukraine-crisis/';
        $crawler = $client->request('GET', $url);

        $titles = $crawler->filter('section.list-river article.item h4.item__hed')->each(function ($node) {
            return $node->text();
        });

        $links = $crawler->filter('section.list-river article.item a.item__anchor')->each(function($node){
            return $node->attr('href');
        });

        $images = $crawler->filter('section.list-river article.item span.item__thumb img')->each(function ($node) {
            return $node->attr('src');
        });

        // determin location based on title
        $scraped_data   = [];
        $ukraine_cities = UkraineCity::all()
            ->map
            ->only('city_name', 'latitude', 'longitude')
            ->toArray();
        foreach ($titles as $key => $title) {
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
                array_push($scraped_data, [
                    'title'        => $title,
                    'link'         => $links[$key],
                    'image'        => $images[$key],
                    'has_location' => true,
                    'latitude'     => $ukraine_cities[$city_key]['latitude'],
                    'longitude'    => $ukraine_cities[$city_key]['longitude'],
                ]);
                continue;
            }
        }

        return $scraped_data;
    }
}