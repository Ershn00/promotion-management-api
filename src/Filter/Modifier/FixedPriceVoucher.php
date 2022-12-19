<?php

namespace App\Filter\Modifier;

use App\DTO\PromotionInquiryInterface;
use App\Entity\Promotion;

class FixedPriceVoucher implements PriceModifierInterface
{
    /**
     * @param int $price
     * @param int $quantity
     * @param Promotion $promotion
     * @param PromotionInquiryInterface $inquiry
     * @return int
     */
    public function modify(int $price, int $quantity, Promotion $promotion, PromotionInquiryInterface $inquiry): int
    {
        if (!($inquiry->getVoucherCode() === $promotion->getCriteria()['code'])) {

            return $price * $quantity;
        }

        return $promotion->getAdjustment() * $quantity;
    }
}