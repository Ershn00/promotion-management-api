<?php

namespace App\Tests\Unit;

use App\DTO\LowestPriceInquiry;
use App\Entity\Promotion;
use App\Filter\Modifier\DateRangeMultiplier;
use App\Filter\Modifier\EvenItemsMultiplier;
use App\Tests\BaseTestCase;

class PriceModifierTest extends BaseTestCase
{
    /** @test */
    public function DateRangeMultiplierReturnsModifiedPrice(): void
    {
        $promotion = new Promotion();
        $promotion->setName('Black Friday half price sale');
        $promotion->setAdjustment(0.5);
        $promotion->setCriteria(["from" => "2022-11-25", "to" => "2022-11-28"]);
        $promotion->setType('date_range_multiplier');

        $inquiry = new LowestPriceInquiry();
        $inquiry->setQuantity(5);
        $inquiry->setRequestDate('2022-11-27');

        $dateRangeMultiplier = new DateRangeMultiplier();
        $modifiedPrice = $dateRangeMultiplier->modify(100, 5, $promotion, $inquiry);

        $this->assertEquals(250, $modifiedPrice);
    }

    /** @test */
    public function EvenItemsMultiplierReturnsModifiedPrice(): void
    {
        $promotion = new Promotion();
        $promotion->setName('Buy one get one free');
        $promotion->setAdjustment(0.5);
        $promotion->setCriteria(["minimum_quantity" => 2]);
        $promotion->setType('even_items_multiplier');

        $inquiry = new LowestPriceInquiry();
        $inquiry->setQuantity(5);

        $evenItemsMultiplier = new EvenItemsMultiplier();
        $modifiedPrice = $evenItemsMultiplier->modify(100, 5, $promotion, $inquiry);

        $this->assertEquals(300, $modifiedPrice);
    }
}