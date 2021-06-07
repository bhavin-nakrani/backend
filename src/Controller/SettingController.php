<?php

namespace App\Controller;

use App\Entity\Setting;
use App\Form\SettingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SettingController.
 *
 * @Route("/setting")
 */
class SettingController extends AbstractController
{
    /**
     * @Route("/", name="setting_index")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $setting = $entityManager->getRepository(Setting::class)->findOneBy([], ['id' => 'desc']);

        $form = $this->createForm(SettingType::class, $setting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('setting_index');
        }

        return $this->render('setting/index.html.twig', [
            'setting' => $setting,
            'form' => $form->createView(),
        ]);
    }
}
