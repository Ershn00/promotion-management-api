<?php

namespace App\DTO;

use App\Entity\Product;

interface PromotionInquiryInterface
{
    public function getProduct(): ?Product;

    public function setPromotionId(int $promotionId);

    public function setPromotionName(string $promotionName);
}