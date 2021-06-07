<?php

namespace App\Controller;

use App\Entity\Role;
use App\Form\RoleType;
use App\Repository\RoleRepository;
use App\Services\DataTableManager;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/role")
 * @IsGranted("ROLE_ADMIN")
 */
class RoleController extends BaseController
{
    /**
     * @Route("/", name="role_index", options={"expose"=true})
     */
    public function index(Request $request, RoleRepository $roleRepository, PaginatorInterface $paginator, DataTableManager $dataTableManager): Response
    {
        if ($request->isXmlHttpRequest()) {
            return $this->json($dataTableManager->renderDataTable($request, $roleRepository, $paginator));
        }

        return $this->render('role/index.html.twig');
    }

    /**
     * @Route("/new", name="role_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $role = new Role();
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($role);
            $entityManager->flush();

            return $this->redirectToRoute('role_index');
        }

        return $this->render('role/_form.html.twig', [
            'role' => $role,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="role_show", methods={"GET"}, options={"expose"=true})
     */
    public function show(Role $role): Response
    {
        return $this->render('role/show.html.twig', [
            'role' => $role,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="role_edit", methods={"GET","POST"}, options={"expose"=true})
     */
    public function edit(Request $request, Role $role): Response
    {
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('role_index');
        }

        return $this->render('role/_form.html.twig', [
            'role' => $role,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="role_delete", methods={"DELETE"}, options={"expose"=true})
     */
    public function delete(Request $request, Role $role): Response
    {
        if ($this->isCsrfTokenValid('delete-item', $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            foreach ($role->getUsers() as $user) {
                $user->setUserRole(null);
                $user->setRoles([]);
            }

            $entityManager->remove($role);
            $entityManager->flush();
        }

        return $this->redirectToRoute('role_index');
    }
}
