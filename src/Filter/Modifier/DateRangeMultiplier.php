<?php

namespace App\Filter\Modifier;

use App\DTO\PromotionInquiryInterface;
use App\Entity\Promotion;

class DateRangeMultiplier implements PriceModifierInterface
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
        $requestDate = date_create($inquiry->getRequestDate());
        $from = date_create($promotion->getCriteria()['from']);
        $to = date_create($promotion->getCriteria()['to']);
        if (!($requestDate >= $from && $requestDate < $to)) {

            return $price * $quantity;
        }

        return ($price * $quantity) * $promotion->getAdjustment();
    }
}