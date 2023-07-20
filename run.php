#!/usr/bin/env php
<?php

require_once 'vendor/autoload.php'; // Composer's autoloader
require_once 'ReaderInterface.php';
require_once 'JsonReader.php';
require_once 'Offer.php';
require_once 'OfferCollection.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Create a log channel
$log = new Logger('cli-app');
$log->pushHandler(new StreamHandler(__DIR__.'/app.log', Logger::INFO));

try {
    $reader = new JsonReader();
    $json = '[
                {
                    "offerId": 123,
                    "productTitle": "Coffee machine",
                    "vendorId": 35,
                    "price": 390.4
                },
                {
                    "offerId": 124,
                    "productTitle": "Napkins",
                    "vendorId": 35,
                    "price": 15.5
                },
                {
                    "offerId": 125,
                    "productTitle": "Chair",
                    "vendorId": 84,
                    "price": 230.0
                }
            ]';

//    $collection = $reader->read('external url where we can json data like "https://metro.com/"');
    $collection = $reader->read($json);

    $command = $argv[1] ?? null;
    if ($command === 'find_by_price_range') {
        $results = $collection->findByPriceRange(from: floatval($argv[2]), to: floatval($argv[3]));
        $log->info('find_by_price_range command executed', ['from' => $argv[2], 'to' => $argv[3]]);
    } elseif ($command === 'find_by_vendor_id') {
        $results = $collection->findByVendorId(vendorId: intval($argv[2]));
        $log->info('find_by_vendor_id command executed', ['vendorId' => $argv[2]]);
    } elseif ($command === 'count_by_vendor_id') {
        $count = $collection->countByVendorId(vendorId: intval($argv[2]));
        $log->info('count_by_vendor_id command executed', ['vendorId' => $argv[2]]);
        echo "Count: " . $count . "\n";
    }elseif ($command === 'count_by_price_range') {
        if (!isset($argv[2]) || !is_numeric($argv[2]) || !isset($argv[3]) || !is_numeric($argv[3])) {
            echo "Both price range values must be numbers.\n";
            exit(1);
        }
        $count = $collection->countByPriceRange(from: floatval($argv[2]), to: floatval($argv[3]));
        $log->info('count_by_price_range command executed', ['from' => $argv[2], 'to' => $argv[3]]);
        echo "Count: " . $count . "\n";
    } else {
        $log->error('Invalid command', ['command' => $command]);
        throw new Exception("Invalid command");
    }


    if (isset($results)) {
        echo "Results:\n";
        foreach ($results as $offer) {
            echo "Offer ID: " . $offer->getOfferId() . "\n";
            echo "Product Title: " . $offer->getProductTitle() . "\n";
            echo "Vendor ID: " . $offer->getVendorId() . "\n";
            echo "Price: " . $offer->getPrice() . "\n";
            echo "In Stock: " . ($offer->isInStock() ? "Yes" : "No") . "\n";
            echo "-----------------\n";
        }
    }
} catch (Exception $e) {
    $log->error('Exception caught', ['exception' => $e]);
    fwrite(STDERR, $e->getMessage() . "\n");
    exit(1);
}
