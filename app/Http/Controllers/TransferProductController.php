<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class TransferProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render("TransferProduct");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'shopify_product_id' => 'required',
            ]);

            $result = $this->getShopifyProduct($request->shopify_product_id);

            $client = new Client();
            $url = env('EBAY_URL') . 'sell/inventory/v1/inventory_item/' . $result['id'];
            $token = env('EBAY_OAUTH_TOKEN');
            $headers = [
                'Content-Language' => 'en-US',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer {$token}"
            ];
            $payload = $this->formatForEbay($result);
            // dd($payload);
            $response = $client->put($url, [
                'headers' => $headers,
                'json' => $payload
            ]);
            // $response = Http::withHeaders($headers)->put($url, $payload);

            // dd($response);

            return Inertia::render("TransferProduct", [
                "success" => true,
                "message" => "Product saved on ebay!."
            ]);
        } catch (\Throwable $th) {
            return Inertia::render("TransferProduct", [
                "success" => false,
                "code" => $th->getCode(),
                "message" => $th->getMessage()
            ]);
        }
    }

    // public function formatForEbay($shopifyProduct) {
    //     return [
    //         'title' => $shopifyProduct['title'],
    //         'description' => $shopifyProduct['body_html'],
    //         'price' => $shopifyProduct['variants'][0]['price'],
    //         'quantity' => $shopifyProduct['variants'][0]['inventory_quantity'],
    //         // Map other required fields as per eBay's API requirements.
    //     ];
    // }

    function formatForEbay($shopifyProduct)
    {
        $inventoryQuantity = array_sum(array_column($shopifyProduct['variants'], 'inventory_quantity'));
        $aspects = [
            'Brand' => [$shopifyProduct['vendor']],
            'Type' => [$shopifyProduct['product_type']],
            'Size' => array_column($shopifyProduct['variants'], 'title')
        ];
        $imageUrls = array_map(function ($image) {
            return $image['src'];
        }, $shopifyProduct['images']);

        // Creating the eBay payload
        $payload = [
            "availability" => [
                "shipToLocationAvailability" => [
                    "quantity" => $inventoryQuantity
                ]
            ],
            "condition" => "NEW",
            "product" => [
                "title" => $shopifyProduct['title'],
                "description" => strip_tags($shopifyProduct['body_html']),
                "aspects" => $aspects,
                "imageUrls" => $imageUrls
            ]
        ];
        return $payload;
    }
}
