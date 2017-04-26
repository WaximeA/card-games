<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Parties;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    //    HELLO WORLD
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


    //    JEU !
    /**
     *@route("/", name="jeu")
     */
    public function jeuAction()
    {
        return $this->render("AppBundle:Default:index.html.twig" , []);
    }

    /**
     *
     * @Route("/classement", name="classement")
     */
    public function partieClassement()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $joueurs = $this->getDoctrine()->getRepository('AppBundle:User')->findBy(array(), array('partiesGG'=>'desc'));

        $joueurspt = $this->getDoctrine()->getRepository('AppBundle:User')->findBy(array(), array('cumulPT'=>'desc'));


        return $this->render(':joueur:classement.html.twig', ['joueurs'=>$joueurs, 'joueurspt' => $joueurspt]);

    }

}
