<?php

namespace App\Controller;

use App\Cache\PromotionCache;
use App\DTO\LowestPriceInquiry;
use App\Filter\PromotionFilterInterface;
use App\Repository\ProductRepository;
use App\Service\Serializer\DTOSerializer;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/product/promotions', name: 'app_products_promotions', methods: 'POST')]
    public function promotions(Request $request): JsonResponse
    {
        $productId = $request->request->get('product_id');

        return $this->json([
            'message' => 'ProductId: ' . $productId,
            'path' => 'src/Controller/ProductsController.php',
        ]);
    }

    /**
     * @param Request $request
     * @param DTOSerializer $serializer
     * @param PromotionFilterInterface $promotionFilter
     * @param PromotionCache $promotionCache
     * @return Response
     * @throws InvalidArgumentException
     */
    #[Route('/product/lowest-price', name: 'app_lowest_price', methods: 'POST')]
    public function lowestPrice(
        Request $request,
        DTOSerializer $serializer,
        PromotionFilterInterface $promotionFilter,
        PromotionCache $promotionCache
    ): Response
    {
        $params = json_decode($request->getContent(), true);
        $productId = $params['product_id'];

        $lowestPriceInquiry = $serializer->deserialize(
            $request->getContent(),
            LowestPriceInquiry::class,
            'json'
        );

        $product = $this->productRepository->findOrFail($productId);

        $lowestPriceInquiry->setProduct($product);

        $promotions = $promotionCache->findValidForProduct($product, $lowestPriceInquiry->getRequestDate());

        $modifiedInquiry = $promotionFilter->apply($lowestPriceInquiry, ...$promotions);

        $response = $serializer->serialize($modifiedInquiry, 'json');

        return new Response(
            $response,
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }
}
