<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseTestCase extends WebTestCase
{
    protected ContainerInterface $container;

    protected function setup(): void
    {
        parent::setUp();

        $this->container = static::createClient()->getContainer();
    }
}