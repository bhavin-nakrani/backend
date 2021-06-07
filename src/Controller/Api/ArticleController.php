<?php

namespace App\Controller\Api;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleController.
 *
 * @Route("/api")
 */
class ArticleController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/article/list")
     */
    public function getArticle(EntityManagerInterface $entityManager)
    {
        $articles = $entityManager->getRepository(Article::class)->findAll();
        $articleList = [];
        if (!empty($articles)) {
            foreach ($articles as $article) {
                $articleList[] = [
                    'id' => $article->getId(),
                    'slug' => $article->getSlug(),
                    'title' => $article->getTitle(),
                    'description' => $article->getDescription(),
                    'shortDescription' => $article->getShortDescription(),
                    'category' => $article->getCategory()->getTitle(),
                    'isPublish' => $article->getIsPublish(),
                    'author' => $article->getAuthor(),
                    'createdAt' => $article->getCreatedAt()->format('Y-m-d H:i:s'),
                ];
            }
        }
        $view = $this->view(['success' => true, 'message' => !empty($articleList) ? 'Article List found' : 'Article list not found', 'articleList' => $articleList], 200);

        return $this->handleView($view);
    }
}
