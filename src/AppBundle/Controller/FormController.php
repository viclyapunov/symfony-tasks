<?php
// src/AppBundle/Controller/DefaultController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FormController extends Controller
{
    /**
     * @Route("/create", name="formpage")
     */
    public function newAction(Request $request)
    {
        // just setup a fresh $task object (remove the dummy data)
        $task = new Task();

        $form = $this->createFormBuilder($task)
            ->add('task', TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();

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
        return new Response('<h4>task created ok.</h4>');
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
}
