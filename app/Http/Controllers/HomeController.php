<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $products = $this->getShopifyProducts();
        return Inertia::render("Welcome", [
            "user" => Auth::user(),
            "products" => collect($products)->map(function ($product) {
                return [
                    'id' => $product['id'],
                    'title' => $product['title'],
                    'vendor' => $product['vendor'],
                    'category' => $product['product_type'],
                    'price' => $product['variants'][0]['price'], // Adjust as needed based on your structure
                    'status' => $product['status']
                ];
            })->toArray()
        ]);
    }

    public function ebayProducts()
    {
        try {
            //code...
            $client = new Client();
            $url = env('EBAY_URL') . 'sell/inventory/v1/inventory_item';
            $token = env('EBAY_OAUTH_TOKEN');
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ]
            ]);
            // Decode the response body
            $responseBody = json_decode($response->getBody(), true);

            return Inertia::render("EbayProducts", [
                "success" => true,
                "user" => Auth::user(),
                "products" => collect($responseBody['inventoryItems'])->map(function ($product) {
                    return [
                        'id' => $product['sku'],
                        'title' => $product['product']['title'],
                    ];
                })->toArray()
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return Inertia::render("EbayProducts", [
                "success" => false,
                "code" => $th->getCode(),
                "message" => $th->getMessage()
            ]);
        }
    }


}
