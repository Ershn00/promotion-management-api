<?php

namespace App\Filter;

use App\DTO\PriceInquiryInterface;
use App\Entity\Promotion;
use App\Filter\Modifier\Factory\PriceModifierFactoryInterface;

class LowestPriceFilter implements PriceFilterInterface
{
    public function __construct(private readonly PriceModifierFactoryInterface $priceModifierFactory)
    {
    }

    public function apply(PriceInquiryInterface $inquiry, Promotion ...$promotions): PriceInquiryInterface
    {
        $price = $inquiry->getProduct()->getPrice();
        $inquiry->setPrice($price);

        $quantity = $inquiry->getQuantity();
        $lowestPrice = $quantity * $price;

        foreach ($promotions as $promotion) {
            $priceModifier = $this->priceModifierFactory->create($promotion->getType());
            $modifiedPrice = $priceModifier->modify($price, $quantity, $promotion, $inquiry);
            if ($modifiedPrice < $lowestPrice) {
                $inquiry->setDiscountedPrice($modifiedPrice);
                $inquiry->setPromotionId($promotion->getId());
                $inquiry->setPromotionName($promotion->getName());

                $lowestPrice = $modifiedPrice;
            }
        }

        return $inquiry;
    }
}