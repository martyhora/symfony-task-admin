<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Project;
use App\Entity\Task;
use App\Form\CommentForm;
use App\Form\TaskForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class TaskController extends Controller
{
    /**
     * @Route("/task/{projectId}", requirements={"projectId": "\d+"}, name="task")
     */
    public function index(int $projectId): Response
    {
        $project = $this->getDoctrine()
            ->getRepository(Project::class)
            ->find($projectId);

        return $this->render('task/list.html.twig', [
            'tasks' => $project->getTasks(),
            'project' => $project,
        ]);
    }

    /**
     * @Route("/task/add/{projectId}", name="addTask")
     */
    public function add(Request $request, int $projectId): Response
    {
        $project = $this->getDoctrine()
            ->getRepository(Project::class)
            ->find($projectId);

        $task = new Task();
        $task->setProject($project);
        $task->setUser($this->getUser());
        $form = $this->createForm(TaskForm::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($task);

            $em->flush();

            return $this->redirectToRoute('task', ['projectId' => $task->getProject()->getId()]);
        }

        return $this->render('task/add.html.twig', [
            'form' => $form->createView(),
            'project' => $project,
        ]);
    }

    /**
     * @Route("/task/edit/{id}", requirements={"id": "\d+"}, name="editTask")
     */
    public function edit(Request $request, Task $task): Response
    {
        $form = $this->createForm(TaskForm::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('task', ['projectId' => $task->getProject()->getId()]);
        }

        return $this->render('task/add.html.twig', [
            'form' => $form->createView(),
            'project' => $task->getProject(),
        ]);
    }

    /**
     * @Route("/task/detail/{id}", requirements={"id": "\d+"}, name="taskDetail")
     */
    public function detail(Request $request, Task $task): Response
    {
        $comment = new Comment();
        $comment->setTask($task);
        $comment->setUser($this->getUser());
        $form = $this->createForm(CommentForm::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($comment);

            $em->flush();

            return $this->redirectToRoute('taskDetail', ['id' => $task->getId()]);
        }

        return $this->render('task/detail.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }
}
