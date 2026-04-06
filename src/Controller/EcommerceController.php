<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EcommerceController extends AbstractController
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $categories = $this->categoryRepository->findAllOrderedByDisplay();

        return $this->render('ecommerce/index.html.twig', [
            'categories' => $categories,
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

        return $this->render('ecommerce/products_by_category.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/cart', name: 'app_cart')]
    public function cart(): Response
    {
        return $this->render('ecommerce/cart.html.twig');
    }
}
