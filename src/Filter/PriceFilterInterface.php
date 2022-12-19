<?php

namespace App\Filter;

use App\DTO\PriceInquiryInterface;
use App\Entity\Promotion;

interface PriceFilterInterface extends PromotionFilterInterface
{
    public function apply(PriceInquiryInterface $inquiry, Promotion ...$promotions): PriceInquiryInterface;
}