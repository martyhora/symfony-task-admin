<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    /**
     * @Route("/", name="project")
     */
    public function index(): Response
    {
        $projects = $this->getDoctrine()
                         ->getRepository(Project::class)
                         ->findAll();

        return $this->render('project/list.html.twig', [
            'projects' => $projects
        ]);
    }

    /**
     * @Route("/project/add", name="addProject")
     */
    public function add(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectForm::class, $project);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($project);

            $em->flush();

            return $this->redirectToRoute('project');
        }

        return $this->render('project/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/project/edit/{id}", requirements={"id": "\d+"}, name="editProject")
     */
    public function edit(Request $request, Project $project): Response
    {
        $form = $this->createForm(ProjectForm::class, $project);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('project');
        }

        return $this->render('project/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
