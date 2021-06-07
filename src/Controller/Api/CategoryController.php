<?php

namespace App\Controller\Api;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController.
 *
 * @Route("/api")
 */
class CategoryController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/category/list")
     */
    public function getCategory(EntityManagerInterface $entityManager)
    {
        $categories = $entityManager->getRepository(Category::class)->findAll();

        if (false === empty($categories)) {
            $categoryList = [];
            foreach ($categories as $category) {
                array_push($categoryList, [
                    'id' => $category->getId(),
                    'slug' => $category->getSlug(),
                    'name' => $category->getTitle(),
                ]);
            }
            $view = $this->view(['success' => true, 'message' => 'Category List found', 'categoryList' => $categoryList], 200);
        } else {
            $view = $this->view(['success' => true, 'message' => 'No category list found', 'categoryList' => []], 200);
        }

        return $this->handleView($view);
    }
}
