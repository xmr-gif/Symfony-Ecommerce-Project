<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EcommerceController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function showHome(CategoryRepository $categoryRepo, ProductRepository $productRepo): Response
    {
        // Re-implemented fetching logic
        $allCategories = $categoryRepo->findAllOrderedByDisplay();
        $featuredItems = $productRepo->findFeatured(4);

        return $this->render('ecommerce/index.html.twig', [
            'categories' => $allCategories,
            'featured' => $featuredItems,
        ]);
    }

    #[Route('/categories', name: 'app_browse_categories')]
    public function viewAllCategories(CategoryRepository $categoryRepo): Response
    {
        return $this->render('ecommerce/browse_categories.html.twig', [
            'categories' => $categoryRepo->findAllOrderedByDisplay(),
        ]);
    }

    #[Route('/category/{slug}', name: 'app_products_by_category')]
    public function viewCategoryProducts(string $slug, CategoryRepository $categoryRepo, ProductRepository $productRepo): Response
    {
        $targetCategory = $categoryRepo->findBySlug($slug);

        if (!$targetCategory) {
            throw $this->createNotFoundException('The requested category does not exist.');
        }

        $categoryProducts = $productRepo->findByCategory($targetCategory);

        return $this->render('ecommerce/products_by_category.html.twig', [
            'category' => $targetCategory,
            'products' => $categoryProducts,
        ]);
    }
}
