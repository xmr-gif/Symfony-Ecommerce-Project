<?php

/**
 * Etape 1 <?php 2 modifications remade by Oussama
 */

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EcommerceController extends AbstractController
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private ProductRepository $productRepository,
    ) {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $categories = $this->categoryRepository->findAllOrderedByDisplay();
        $featured = $this->productRepository->findFeatured(4);

        return $this->render('ecommerce/index.html.twig', [
            'categories' => $categories,
            'featured' => $featured,
        ]);
    }

    #[Route('/categories', name: 'app_browse_categories')]
    public function browseCategories(): Response
    {
        $categories = $this->categoryRepository->findAllOrderedByDisplay();

        return $this->render('ecommerce/browse_categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/category/{slug}', name: 'app_products_by_category')]
    public function productsByCategory(string $slug): Response
    {
        $category = $this->categoryRepository->findBySlug($slug);

        if (!$category) {
            throw $this->createNotFoundException('Category not found');
        }

        $products = $this->productRepository->findByCategory($category);

        return $this->render('ecommerce/products_by_category.html.twig', [
            'category' => $category,
            'products' => $products,
        ]);
    }

}
