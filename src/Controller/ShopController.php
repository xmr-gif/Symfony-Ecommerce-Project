<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShopController extends AbstractController
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    #[Route('/shop', name: 'app_shop')]
    public function index(\Symfony\Component\HttpFoundation\Request $request): Response
    {
        $filters = [
            'origin' => $request->query->get('origin'),
            'roastLevel' => $request->query->get('roastLevel'),
        ];

        $products = $this->productRepository->findByFilters($filters);

        return $this->render('shop/index.html.twig', [
            'products' => $products,
            'currentFilters' => $filters,
        ]);
    }

    #[Route('/product/{slug}', name: 'app_product_detail')]
    public function detail(string $slug): Response
    {
        $product = $this->productRepository->findBySlug($slug);

        if (!$product) {
            throw $this->createNotFoundException('Product not found.');
        }

        $recommended = $this->productRepository->findFeatured(4);

        // Exclude the current product from recommendations
        $recommended = array_filter(
            $recommended,
            fn ($p) => $p->getId() !== $product->getId()
        );

        return $this->render('shop/product_detail.html.twig', [
            'product' => $product,
            'recommended' => $recommended,
        ]);
    }
}
