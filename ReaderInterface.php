<?php
interface ReaderInterface {
    public function read(string $input): OfferCollectionInterface;
}

interface OfferInterface {
    public function getOfferId(): int;
    public function getProductTitle(): string;
    public function getVendorId(): int;
    public function getPrice(): float;
    public function isInStock(): bool;
}

interface OfferCollectionInterface {
    public function get(int $index): ?OfferInterface;
    public function getIterator(): Iterator;
    public function findByPriceRange(float $from, float $to): array;
    public function findByVendorId(int $vendorId): array;
}
