<?php

namespace App\Filter\Modifier;

use App\DTO\PromotionInquiryInterface;
use App\Entity\Promotion;

class EvenItemsMultiplier implements PriceModifierInterface
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
        if ($quantity < 2) {
            return $price * $quantity;
        }

        $oddCount = $quantity % 2;
        $evenCount = $quantity - $oddCount;

        return (($evenCount * $price) * $promotion->getAdjustment()) + ($oddCount * $price);
    }
}