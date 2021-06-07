<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Services\DataTableManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController.
 *
 * @Route("/category")
 */
class CategoryController extends BaseController
{
    /**
     * @Route("/", name="category_index", options={"expose"=true})
     */
    public function index(Request $request, CategoryRepository $categoryRepository, PaginatorInterface $paginator, DataTableManager $dataTableManager)
    {
        if ($request->isXmlHttpRequest()) {
            return $this->json($dataTableManager->renderDataTable($request, $categoryRepository, $paginator));
        }

        return $this->render('category/index.html.twig');
    }

    /**
     * @Route("/new", name="category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/_form.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="category_edit", methods={"GET","POST"}, options={"expose"=true})
     */
    public function edit(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/_form.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_delete", methods={"DELETE"}, options={"expose"=true})
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete-item', $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            foreach ($category->getArticles() as $article) {
                $article->setCategory(null);
            }

            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_index');
    }
}
