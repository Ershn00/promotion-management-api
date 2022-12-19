<?php

namespace App\Cache;

use App\Entity\Product;
use App\Repository\PromotionRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class PromotionCache
{
    public function __construct(
        private readonly CacheInterface $cache,
        private readonly PromotionRepository $repository
    )
    {
    }

    /**
     * @param Product $product
     * @param string $requestDate
     * @return array
     * @throws InvalidArgumentException
     */
    public function findValidForProduct(Product $product, string $requestDate): array
    {
        $key = sprintf("valid-for-product-%d", $product->getId());

        return $this->cache->get($key, function (ItemInterface $item) use ($product, $requestDate) {

            $item->expiresAfter(5);

            var_dump('miss');

            return $this->repository->findValidForProduct($product, date_create_immutable($requestDate));
        });
    }
}