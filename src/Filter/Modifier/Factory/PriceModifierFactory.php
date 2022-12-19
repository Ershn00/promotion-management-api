<?php

namespace App\Filter\Modifier\Factory;

use App\Filter\Modifier\PriceModifierInterface;
use Laminas\Code\Generator\Exception\ClassNotFoundException;

class PriceModifierFactory implements PriceModifierFactoryInterface
{
    /**
     * Convert type (snake_case) to ClassName (PascalCase)
     * @param string $modifierType
     * @return PriceModifierInterface
     */
    public function create(string $modifierType): PriceModifierInterface
    {
        $modifierClassName = str_replace('_', '', ucwords($modifierType, '_'));

        $modifier = self::PRICE_MODIFIER_NAMESPACE . $modifierClassName;

        if (!class_exists($modifier)) {

            throw new ClassNotFoundException($modifier);
        }

        return new $modifier();
    }
}