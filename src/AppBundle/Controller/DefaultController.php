<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    //    HELLO WORL
    /**
     * @Route("/hello", name="hello_world")
     */
    public function helloAction()
    {
        return $this->render("AppBundle:Default:hello.html.twig");
    }


    //    PAGE
    /**
     *@route("/page", name="page")
     */
    public function pageAction()
    {
        $var1="Maxime AVELINE";
        return $this->render("AppBundle:Default:page.html.twig",array('maVariable'=>$var1));
    }

    //    PAGE2
    /**
     *@route("/page2", name="page2")
     */
    public function page2Action()
    {
        return $this->render("AppBundle:Default:page2.html.twig");
    }

    //    INDEX
    /**
     *@route("/index/{nom}", name="index")
     */
    public function indexAction($nom = '')
    {
        $tableau = array(
            array('prenom' => "Maxime", 'nom' => "aveline"),
            array('prenom' => "Anthony", 'nom' => "hengy"),
            array('prenom' => "David", 'nom' => "annebicque"),
        );

        return $this->render("AppBundle:Default:index.html.twig", ['tab' => $tableau,'nom'=>$nom ]);


    }
}
