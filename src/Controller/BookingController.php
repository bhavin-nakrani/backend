<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use App\Services\DataTableManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/booking")
 */
class BookingController extends AbstractController
{
    /**
     * @Route("/calendar", name="booking_calendar", methods={"GET"})
     */
    public function calendar(): Response
    {
        return $this->render('booking/calendar.html.twig');
    }

    /**
     * @Route("/", name="booking_index", options={"expose"=true})
     */
    public function index(Request $request, BookingRepository $bookingRepository, PaginatorInterface $paginator, DataTableManager $dataTableManager): Response
    {
        if ($request->isXmlHttpRequest()) {
            return $this->json($dataTableManager->renderDataTable($request, $bookingRepository, $paginator));
        }

        return $this->render('booking/index.html.twig');
    }

    /**
     * @Route("/new", name="booking_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('booking_index');
        }

        return $this->render('booking/_form.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="booking_show", methods={"GET"}, options={"expose"=true})
     */
    public function show(Booking $booking): Response
    {
        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="booking_edit", methods={"GET","POST"}, options={"expose"=true})
     */
    public function edit(Request $request, Booking $booking): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('booking_index');
        }

        return $this->render('booking/_form.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="booking_delete", methods={"DELETE"}, options={"expose"=true})
     */
    public function delete(Request $request, Booking $booking): Response
    {
        if ($this->isCsrfTokenValid('delete-item', $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('booking_index');
    }
}
