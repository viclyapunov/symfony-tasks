<?php
// src/AppBundle/Controller/DefaultController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\TaskType;

class FormController extends Controller
{
    /**
     * @Route("/create", name="formpage")
     */
    public function newAction(Request $request)
    {
        // just setup a fresh $task object (remove the dummy data)
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $em = $this->getDoctrine()->getManager();
             $em->persist($task);
             $em->flush();

            return $this->redirectToRoute('task_success');
        }

        return $this->render('AppBundle::new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

   /**
     * @Route("/formok", name="task_success")
     */
    public function successAction()
    {
        return $this->render('AppBundle::created.html.twig', array());
    }

    /**
     * @Route("/list", name="task_list")
     */
    public function listAction()
    {
        $tasks = $this->GetDoctrine()->GetRepository(Task::class)->findAll();
        return $this->render('AppBundle::list.html.twig', array(
            'tasks' => $tasks
        ));
    }

    /**
     * @Route("/tasks/{task_id}", name="task_show")
     */
    public function showAction(Request $request, $task_id)
    {

        $task = $this->GetDoctrine()->GetRepository(Task::class)->findOneById($task_id);

        $form = $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $em = $this->getDoctrine()->getManager();
             $em->persist($task);
             $em->flush();

            return $this->redirectToRoute('task_success');
        }

        return $this->render('AppBundle::show.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{task_id}/delete", name="task_delete")
     */
    public function deleteAction(Request $request, $task_id)
    {
        $task = $this->GetDoctrine()->GetRepository(Task::class)->findOneById($task_id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('task_list');
    }
}
