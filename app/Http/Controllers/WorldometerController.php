<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class WorldometerController extends Controller
{
    public function scrape()
    {
        // Create a new Guzzle client
        $client = new Client();

        // Send a GET request to the Worldometer website
        $response = $client->request('GET', 'https://www.worldometers.info/coronavirus/');

        // Get the body of the response
        $body = $response->getBody()->getContents();

        // Create a new DOM Crawler instance
        $crawler = new Crawler($body);

        // Extract the desired data using CSS selectors
        $totalCases = $crawler->filter('#maincounter-wrap span')->eq(0)->text();
        $totalDeaths = $crawler->filter('#maincounter-wrap span')->eq(1)->text();
        $totalRecovered = $crawler->filter('#maincounter-wrap span')->eq(2)->text();

        // Return the scraped data as a JSON response
        // return response()->json([
        //     'total_cases' => $totalCases,
        //     'total_deaths' => $totalDeaths,
        //     'total_recovered' => $totalRecovered,
        // ]);

        // Generate the HTML response
        $html = "
           <!DOCTYPE html>
           <html lang='en'>
           <head>
               <meta charset='UTF-8'>
               <meta name='viewport' content='width=device-width, initial-scale=1.0'>
               <title> Victor Worldometer Scrape Data</title>
           </head>
           <body style='text-align: center;'>
               <h1>Victor Worldometer COVID-19 Data</h1>
               <ul>
                   <li>Total Cases: {$totalCases}</li>
                   <li>Total Deaths: {$totalDeaths}</li>
                   <li>Total Recovered: {$totalRecovered}</li>
               </ul>
           </body>
           </html>
           ";

        return response($html, 200)
            ->header('Content-Type', 'text/html');
    }
}
