<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

if (!function_exists('xwdoge_price')) {
    function xwdoge_price()
    {
        $cacheKey = 'xwdoge_price';
        $cachedPrice = Cache::get($cacheKey);

        if ($cachedPrice) {
            return $cachedPrice;
        }

        $response = Http::post('https://unielon.com/v3/swap/price', ['headers' => ['X-Requested-With' => 'XMLHttpRequest']]);
        $html = $response->body();
        $html = json_decode($html);
        $data  = collect($html->data);
        $filteredData = $data->where('tick', 'XWDOGE');
        $tickData = $filteredData->first();
        $lastPrice = $tickData->last_price;

        // Cache the price for 5 minutes
        Cache::put($cacheKey, $lastPrice, 300);

        return $lastPrice;
    }
}
if (!function_exists('dogestar_price')) {
    function Fexa_price()
    {
        $cacheKey = 'dogestar_price';
        $cachedPrice = Cache::get($cacheKey);

        if ($cachedPrice) {
            return $cachedPrice;
        }

        $response = Http::post('https://unielon.com/v3/swap/price', ['headers' => ['X-Requested-With' => 'XMLHttpRequest']]);
        $html = $response->body();
        $html = json_decode($html);
        $data  = collect($html->data);
        $filteredData = $data->where('tick', 'DOGESTAR');
        $tickData = $filteredData->first();
        $lastPrice = $tickData->last_price;

        // Cache the price for 5 minutes
        Cache::put($cacheKey, $lastPrice, 300);

        return $lastPrice;
    }
}
if (!function_exists('doge_price')) {
    function doge_price()
    {
        $cacheKey = 'doge_price';
        $cachedPrice = Cache::get($cacheKey);

        if ($cachedPrice) {
            return $cachedPrice;
        }

        $response = Http::get('https://dogechain.info/');
        $html = $response->body();
        $crawler = new \Symfony\Component\DomCrawler\Crawler($html);
        $price = $crawler->filter('#current_price > h3')->text();
        $price = str_replace(['USD', 'DOGE'], '', $price);
        $price = floatval($price);

        // Cache the price for 5 minutes
        Cache::put($cacheKey, $price, 300);

        return $price;
    }
}






if (!function_exists('comvers')) {
    function convers($number)
    {
        if ($number < 1000) {
            if (floor($number) == $number) {
                return $number;
            }
            return number_format($number, 1);
        } elseif ($number < 1000000) {
            $result = $number / 1000;
            if (floor($result) == $result) {
                return floor($result) . 'k';
            }
            return number_format($result, 1) . 'k';
        } elseif ($number < 1000000000) {
            $result = $number / 1000000;
            if (floor($result) == $result) {
                return floor($result) . 'm';
            }
            return number_format($result, 1) . 'm';
        } else {
            $result = $number / 1000000000;
            if (floor($result) == $result) {
                return floor($result) . 'b';
            }
            return number_format($result, 1) . 'b';
        }
    }
}

if (!function_exists('profit_per_hours')) {
    function profit_per_hours($hours, $profit)
    {
        return $profit / $hours;
    }
}

if (!function_exists('phone_to_whatsapp_link')) {
    function phone_to_whatsapp_link($phoneNumber)
    {
        $formattedNumber = preg_replace('/\D+/', '', $phoneNumber); // Menghapus semua karakter non-digit
        if (substr($formattedNumber, 0, 2) === '08') {
            $formattedNumber = '62' . substr($formattedNumber, 1);
        }
        return "https://wa.me/$formattedNumber"; // Mengembalikan link WhatsApp
    }
}
