<?php

namespace App\Tests\Unit;

use App\DTO\LowestPriceInquiry;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Filter\LowestPriceFilter;
use App\Tests\BaseTestCase;

class LowestPriceFilterTest extends BaseTestCase
{
    /** @test */
    public function lowestPricePromotionFilteringIsAppliedCorrectly(): void
    {
        $product = new Product();
        $product->setPrice(100);

        $inquiry = new LowestPriceInquiry();
        $inquiry->setProduct($product);
        $inquiry->setQuantity(5);
        $inquiry->setRequestDate('2022-11-27');
        $inquiry->setVoucherCode('OU812');

        $promotions = $this->promotionsDataProvider();
        $lowestPriceFilter = $this->container->get(LowestPriceFilter::class);

        $filteredInquiry = $lowestPriceFilter->apply($inquiry, ...$promotions);

        $this->assertSame(100, $filteredInquiry->getPrice());
        $this->assertSame(250, $filteredInquiry->getDiscountedPrice());
        $this->assertSame('Black Friday half price sale', $filteredInquiry->getPromotionName());
    }

    private function promotionsDataProvider(): array
    {
        $promotionOne = new Promotion();
        $promotionOne->setName('Black Friday half price sale');
        $promotionOne->setAdjustment(0.5);
        $promotionOne->setCriteria(["from" => "2022-11-25", "to" => "2022-11-28"]);
        $promotionOne->setType('date_range_multiplier');

        $promotionTwo = new Promotion();
        $promotionTwo->setName('Voucher OU812');
        $promotionTwo->setAdjustment(100);
        $promotionTwo->setCriteria(["code" => "OU812"]);
        $promotionTwo->setType('fixed_price_voucher');

        $promotionThree = new Promotion();
        $promotionThree->setName('Buy one get one free');
        $promotionThree->setAdjustment(0.5);
        $promotionThree->setCriteria(["minimum_quantity" => 2]);
        $promotionThree->setType('even_items_multiplier');

        return [$promotionOne, $promotionTwo, $promotionThree];
    }
}