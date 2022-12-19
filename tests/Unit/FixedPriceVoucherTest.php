<?php

namespace App\Tests\Unit;

use App\DTO\LowestPriceInquiry;
use App\Entity\Promotion;
use App\Filter\Modifier\FixedPriceVoucher;
use App\Tests\BaseTestCase;

class FixedPriceVoucherTest extends BaseTestCase
{
    /** @test */
    public function FixedPriceVoucherReturnsModifiedPrice()
    {
        $promotion = new Promotion();
        $promotion->setName('Voucher OU812');
        $promotion->setAdjustment(100);
        $promotion->setCriteria(["code" => "OU812"]);
        $promotion->setType('fixed_price_voucher');

        $inquiry = new LowestPriceInquiry();
        $inquiry->setQuantity(5);
        $inquiry->setVoucherCode('OU812');

        $fixedPriceVoucher = new FixedPriceVoucher();
        $modifiedPrice = $fixedPriceVoucher->modify(150, 5, $promotion, $inquiry);

        $this->assertEquals(500, $modifiedPrice);
    }
}