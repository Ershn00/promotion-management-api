<?php

namespace App\Tests\Unit;

use App\DTO\LowestPriceInquiry;
use App\Event\AfterDtoCreatedEvent;
use App\Tests\BaseTestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class DtoSubscriberTest extends BaseTestCase
{
    /** @test */
    public function DtoValidatedAfterCreated()
    {
        $dto = new LowestPriceInquiry();
        $dto->setQuantity(-5);

        $event = new AfterDtoCreatedEvent($dto);

        /** @var EventDispatcher $eventDispatcher */
        $eventDispatcher = $this->container->get('debug.event_dispatcher');

        $this->expectException(ValidationFailedException::class);
        $this->expectExceptionMessage('This value should be positive');

        $eventDispatcher->dispatch($event, $event::NAME);
    }
}