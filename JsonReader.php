<?php
class JsonReader implements ReaderInterface
{
    public function read(string $json): OfferCollectionInterface
    {
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Invalid JSON: " . json_last_error_msg());
        }

        $offers = [];
        foreach ($data as $item) {
            $offers[] = new Offer(
                offerId: $item['offerId'],
                productTitle: $item['productTitle'],
                vendorId: $item['vendorId'],
                price: $item['price'],
                inStock: true // We assume all items are in stock as it's not provided in the JSON
            );
        }
        return new OfferCollection(offers: $offers);
    }
}
