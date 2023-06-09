<?php

namespace App\EventSubscriber;

use App\Event\AfterDtoCreatedEvent;
use App\Service\ServiceException;
use App\Service\ValidationExceptionData;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DtoSubscriber implements EventSubscriberInterface
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AfterDtoCreatedEvent::NAME => [
                ['validateDto', 100]
            ]
        ];
    }

    public function validateDto(AfterDtoCreatedEvent $event): void
    {
        $dto = $event->getDto();

        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {

            throw new ServiceException(
                new ValidationExceptionData(
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    'ConstraintViolationList',
                    $errors
                )
            );
        }
    }
}