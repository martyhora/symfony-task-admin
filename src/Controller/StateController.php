<?php

namespace App\Controller;

use App\Entity\State;
use App\Entity\User;
use App\Form\StateForm;
use App\Repository\StateRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class StateController extends Controller
{
    /**
     * @Route("/state", name="state")
     */
    public function index(StateRepository $stateRepository): Response
    {
        $states = $stateRepository->findAll();

        return $this->render('state/list.html.twig', [
            'states' => $states
        ]);
    }

    /**
     * @Route("/state/add", name="addState")
     */
    public function add(Request $request): Response
    {
        $state = new State();
        $form = $this->createForm(StateForm::class, $state);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($state);

            $em->flush();

            return $this->redirectToRoute('state');
        }

        return $this->render('state/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/state/edit/{id}", requirements={"id": "\d+"}, name="editState")
     */
    public function edit(Request $request, State $state): Response
    {
        $form = $this->createForm(StateForm::class, $state);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('state');
        }

        return $this->render('state/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
