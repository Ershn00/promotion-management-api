<?php

namespace App\DTO;

interface PriceInquiryInterface extends PromotionInquiryInterface
{
    public function setPrice(int $price);

    public function setDiscountedPrice(int $discountedPrice);

    public function getQuantity(): ?int;
}