<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Services\DataTableManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleController.
 *
 * @Route("/article")
 */
class ArticleController extends BaseController
{
    /**
     * @Route("/", name="article_index", options={"expose"=true})
     */
    public function index(Request $request, ArticleRepository $articleRepository, PaginatorInterface $paginator, DataTableManager $dataTableManager)
    {
        if ($request->isXmlHttpRequest()) {
            return $this->json($dataTableManager->renderDataTable($request, $articleRepository, $paginator));
        }

        return $this->render('article/index.html.twig');
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $setting = $this->getSetting();
        $isPublish = ($setting->getIsArticlePublish()) ? $setting->getIsArticlePublish() : false;
        $isAuthor = ($setting->getIsLoginUserAuthor()) ? $this->getUser()->getName() : '';
        $article = new Article();
        $article->setIsPublish($isPublish);
        $article->setAuthor($isAuthor);
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/_form.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"}, options={"expose"=true})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/_form.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"}, options={"expose"=true})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete-item', $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }
}
