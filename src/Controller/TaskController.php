<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\Type\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;

class TaskController extends AbstractController
{
    #[Route('/task', name: 'task')]
    public function new(Request $request):Response{
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));
        $task->setDescription("Write a description");

        $form = $this->createForm(TaskType::class, $task,[
            'method' => 'POST',
        ]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $task = $form->getData();
            $user = $this->getUser();        
            $toFind = $user->getId();
            $task->setUserId($toFind);
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($task);
            $entitymanager->flush();
            
            $this->addFlash('taskSuccessNotice', 'Wow! Your task has been created');            
        }

        return $this->render('task/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // #[Route('/task/display', name: 'display_task')]
    // public function successfulTask():Response{
    //     $listOfTask = $this->getDoctrine()->getRepository(Task::class)->findAll();
    //     return $this->render('task/task_display.html.twig', [
    //         'ListOfTask' => $listOfTask
    //     ]);
    // }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function updateData(Request $request, $id){
        $task = $this->getDoctrine()->getRepository(Task::class)->find($id);
        // $task->setTask('Write a blog post');
        // $task->setDueDate(new \DateTime('tomorrow'));
        // $task->setDescription("Write a description");

        $form = $this->createForm(TaskType::class, $task,[
            'method' => 'POST',
        ]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $task = $form->getData();
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($task);
            $entitymanager->flush();
            
            $this->addFlash('taskUpdateNotice', 'Updated Successfully');
            return $this->redirectToRoute('try');            
        }

        return $this->render('task/update.html.twig', [
            'form' => $form->createView(),
        ]);                        
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteData($id): Response{
        $data = $this->getDoctrine()->getRepository(Task::class)->find($id);
        $entitymanager = $this->getDoctrine()->getManager();
        $entitymanager->remove($data);
        $entitymanager->flush();
        
        $this->addFlash('taskUpdateNotice', 'Deleted Successfully');
        return $this->redirectToRoute('try'); 
    }

    /**
     * @Route("/try", name="try")
     */
    public function trying():Response{
        $user = $this->getUser();        
        $toFind = $user->getId();
        $repository = $this->getDoctrine()->getRepository(Task::class);
        $listOfTask = $repository->findBy(['userID' => $toFind]);
        return $this->render('task/task_display.html.twig', [
            'ListOfTask' => $listOfTask
        ]);
    }
}
