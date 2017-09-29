<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/blog/{name}")
     *
     */
    public function indexAction($name = '')
    {
        return $this->render('BlogBundle::layout.html.twig',
    						['name' => $name]);
    }
}
