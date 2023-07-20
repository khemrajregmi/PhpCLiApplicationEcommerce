<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Create a log channel
$log = new Logger('cli-app');
$log->pushHandler(new StreamHandler(__DIR__.'/app.log', Logger::INFO));
class OfferCollection implements OfferCollectionInterface {
    public function __construct(
        private array $offers
    ) {}

    public function get(int $index): ?OfferInterface {
        return $this->offers[$index] ?? null;
    }

    public function getIterator(): Iterator {
        return new ArrayIterator($this->offers);
    }

    public function findByPriceRange(float $from, float $to): array {
        if($from <= $to){
            return array_filter($this->offers, fn($offer) => $offer->isInStock() && $offer->getPrice() >= $from && $offer->getPrice() <= $to);
        }
        else{
            return array_filter($this->offers, fn($offer) => $offer->isInStock() && $offer->getPrice() >= $to && $offer->getPrice() <= $from);
        }
    }

    public function findByVendorId(int $vendorId): array {
        return array_filter($this->offers, fn($offer) => $offer->isInStock() && $offer->getVendorId() == $vendorId);
    }

    public function countByVendorId(int $vendorId): int
    {
        return count(array_filter($this->offers, function($offer) use ($vendorId) {
            return $offer->getVendorId() === $vendorId && $offer->isInStock();
        }));
    }

    public function countByPriceRange(float $from, float $to): int
    {
        return count($this->findByPriceRange($from, $to));
    }
}
