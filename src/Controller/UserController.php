<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Services\DataTableManager;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 * @IsGranted("ROLE_ADMIN")
 */
class UserController extends BaseController
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->encoder = $encoder;
    }

    /**
     * @Route("/", name="user_index", options={"expose"=true})
     */
    public function index(Request $request, UserRepository $userRepository, PaginatorInterface $paginator, DataTableManager $dataTableManager): Response
    {
        if ($request->isXmlHttpRequest()) {
            return $this->json($dataTableManager->renderDataTable($request, $userRepository, $paginator));
        }

        return $this->render('user/index.html.twig');
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $setting = $this->getSetting();
        $role = ($setting->getUserRole()) ? $setting->getUserRole() : [];

        $user = new User();
        if (!empty($role)) {
            $user->setUserRole($role);
            $user->setRoles([$role->getName()]);
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if ($data->getUserRole()) {
                $user->setRoles([$data->getUserRole()->getName()]);
            }

            if ($data->getPassword()) {
                $password = $this->encoder->encodePassword($user, $data->getPassword());
                $user->setPassword($password);
            }

            $image = $form['photo']->getData();
            if ($image) {
                $imageFileName = $fileUploader->upload(
                    $this->getParameter('USER_IMAGE_DIR'),
                    $image
                );
                $user->setPhoto($imageFileName);
            } else {
                $user->setPhoto(null);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/_form.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"}, options={"expose"=true})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"}, options={"expose"=true})
     */
    public function edit(Request $request, User $user, FileUploader $fileUploader, EntityManagerInterface $entityManager): Response
    {
        $oldPassword = $user->getPassword();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if ($data->getUserRole()) {
                $user->setRoles([$data->getUserRole()->getName()]);
            }

            if ($data->getPassword()) {
                $password = $this->encoder->encodePassword($user, $data->getPassword());
                $user->setPassword($password);
            } else {
                $user->setPassword($oldPassword);
            }

            $image = $form['photo']->getData();
            if ($image) {
                $imageFileName = $fileUploader->upload(
                    $this->getParameter('USER_IMAGE_DIR'),
                    $image
                );
                $user->setPhoto($imageFileName);
            }
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/_form.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"}, options={"expose"=true})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete-item', $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
