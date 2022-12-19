<?php

namespace App\Filter\Modifier;

use App\DTO\PromotionInquiryInterface;
use App\Entity\Promotion;

interface PriceModifierInterface
{
    public function modify(int $price, int $quantity, Promotion $promotion, PromotionInquiryInterface $inquiry);
}