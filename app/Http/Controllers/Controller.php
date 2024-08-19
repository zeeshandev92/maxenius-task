<?php

namespace App\Http\Controllers;

use Error;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Auth;
use \Symfony\Component\HttpFoundation\Response as SymfonyResponse;

abstract class Controller
{

    public function getShopifyProduct($productId)
    {
        $responseApi = Auth::user()->api()->rest("GET", "/admin/api/2021-01/products/{$productId}.json");

        $this->validateApiStatusCode($responseApi['response']);

        $this->validateApiResponse($responseApi['response']);

        return $responseApi['body']['product']->toArray();
    }

    public function getShopifyProducts()
    {
        $responseApi = Auth::user()->api()->rest("GET", "/admin/api/2021-01/products.json");

        $this->validateApiStatusCode($responseApi['response']);

        $this->validateApiResponse($responseApi['response']);

        return $responseApi['body']['products']->toArray();
    }

    public function validateApiStatusCode(Response $response): void
    {
        if ($response->getStatusCode() !== SymfonyResponse::HTTP_OK) {
            throw new Error('API returns a bad response: ' . $response->getReasonPhrase(), $response->getStatusCode());
        }
    }

    public function validateApiResponse(Response $response): void
    {
        if ($response->getStatusCode() !== SymfonyResponse::HTTP_OK) {
            throw new Error('API returns a bad response:' . $response->getReasonPhrase(), $response->getStatusCode());
        }
    }
}
