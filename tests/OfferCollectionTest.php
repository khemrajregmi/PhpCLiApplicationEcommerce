<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

final class OfferCollectionTest extends TestCase
{
    private $logger;

    protected function setUp(): void
    {
        $this->logger = new Logger('offer-collection-test');
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/offer-collection-test.log', Logger::DEBUG));
    }

    public function testFindByPriceRange(): void
    {
        $this->logger->info('Test findByPriceRange started');

        try {
            $offer1 = new Offer(
                offerId: 1,
                productTitle: 'A',
                vendorId: 10,
                price: 100,
                inStock: true
            );
            $offer2 = new Offer(
                offerId: 2,
                productTitle: 'B',
                vendorId: 20,
                price: 200,
                inStock: true
            );
            $offer3 = new Offer(
                offerId: 3,
                productTitle: 'C',
                vendorId: 30,
                price: 300,
                inStock: true
            );

            $collection = new OfferCollection(
                offers: [$offer1, $offer2, $offer3]
            );

            $results = $collection->findByPriceRange(from: 150, to: 250);

            $this->assertCount(1, $results);
            $this->assertSame($offer2, $results[0]);

        } catch (\Exception $e) {
            $this->logger->error('Exception caught in testFindByPriceRange', ['exception' => $e]);
            $this->fail('Exception thrown: ' . $e->getMessage());
        }

        $this->logger->info('Test findByPriceRange completed');
    }

    public function testFindByVendorId(): void
    {
        $this->logger->info('Test findByVendorId started');

        try {
            $offer1 = new Offer(
                offerId: 1,
                productTitle: 'A',
                vendorId: 10,
                price: 100,
                inStock: true
            );
            $offer2 = new Offer(
                offerId: 2,
                productTitle: 'B',
                vendorId: 20,
                price: 200,
                inStock: true
            );
            $offer3 = new Offer(
                offerId: 3,
                productTitle: 'C',
                vendorId: 30,
                price: 300,
                inStock: true
            );

            $collection = new OfferCollection(
                offers: [$offer1, $offer2, $offer3]
            );

            $results = $collection->findByVendorId(vendorId: 20);

            $this->assertCount(1, $results);
            $this->assertSame($offer2, $results[0]);

        } catch (\Exception $e) {
            $this->logger->error('Exception caught in testFindByVendorId', ['exception' => $e]);
            $this->fail('Exception thrown: ' . $e->getMessage());
        }

        $this->logger->info('Test findByVendorId completed');
    }
}
