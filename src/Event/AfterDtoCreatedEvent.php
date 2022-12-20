<?php

namespace App\Event;

use App\DTO\PromotionInquiryInterface;
use Symfony\Contracts\EventDispatcher\Event;

class AfterDtoCreatedEvent extends Event
{
    public  const NAME = 'dto.created';
    
    public function __construct(protected PromotionInquiryInterface $dto)
    {
    }

    public function getDto(): PromotionInquiryInterface
    {
        return $this->dto;
    }
}