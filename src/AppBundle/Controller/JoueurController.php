<?php
namespace AppBundle\Controller;
use AppBundle\Entity\User;
use AppBundle\Entity\Parties;
use AppBundle\Entity\Situation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 * @Route("joueur")
 */
class JoueurController extends Controller
{
    /**
     * @Route("/", name="joueur_homepage")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        return $this->render("joueur/index.html.twig", ['user' => $user]);
    }

    /**
     * @Route("/parties/", name="joueur_parties")
     */
    public function mesPartiesAction()
    {
        $user = $this->getUser();
        $parties = $this->getDoctrine()->getRepository('AppBundle:Parties')->findAll();
        return $this->render("joueur/mesparties.html.twig", ['user' => $user, 'parties' => $parties]);
    }

    /**
     * @Route("/parties/add", name="joueur_parties_add")
     */
    public function addPartieAction()
    {
        $user = $this->getUser();
        // récupérer tous les joueurs existants
        $joueurs = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        return $this->render("joueur/addPartie.html.twig", ['user' => $user, 'joueurs' => $joueurs]);
    }

    /**
     * @param User $id
     * @Route("/inviter/{joueur}", name="creer_partie")
     */
    public function creerPartieAction(User $joueur)
    {
        $user = $this->getUser();
        $situation = new Situation();


        // récupérer les cartes
        $cartes = $this->getDoctrine()->getRepository('AppBundle:Cartes')->findAll();

        //on mélange les cartes
        shuffle($cartes);

        $t = array();
        for($i = 0; $i<8; $i++)
        {
            $t[] = $cartes[$i]->getId();
        }

        $situation->setMainJ1(json_encode($t));

        $t = array();
        for($i = 8; $i<16; $i++)
        {
            $t[] = $cartes[$i]->getId();
        }

        $situation->setMainJ2(json_encode($t));

        $t = array();
        for($i = 16; $i<count($cartes); $i++)
        {
            $t[] = $cartes[$i]->getId();
        }

        $situation->setPioche(json_encode($t));

        $em = $this->getDoctrine()->getManager();

        $em->persist($situation);
        $em->flush();

        $partie = new Parties();
        $partie->setJoueur1($user);
        $partie->setJoueur2($joueur);
        $partie->setSituation($situation);

        $em->persist($partie);
        $em->flush();

//        return $this->render('joueur/partie.html.twig', ['partie' => $partie]);
        return $this->redirectToRoute('afficher_partie', ['id' => $partie->getId()]);
    }

    /**
     * @param Parties $id
     * @Route("/afficher/{id}", name="afficher_partie")
     */
    public function afficherPartieAction(Parties $id)
    {
        $cartes = $this->getDoctrine()->getRepository('AppBundle:Cartes')->getAll();
        $user = $this->getUser();

        $situation = $id->getSituation();

        $main_joueur1 = $situation->getMainJ1();
        $main_joueur2 = $situation->getMainJ2();

        $plateau['mainJ1'] = json_decode($main_joueur1);
        $plateau['mainJ2'] = json_decode($main_joueur2);

//        $defausse = $situation->getDefausse();
//        $defausse['defausse'] = json_decode($defausse);

        return $this->render(':joueur:afficherpartie.html.twig', ['cartes' => $cartes, 'partie' => $id, 'user' => $user, 'plateau' => $plateau]);
    }


    /**
     * @param Parties $id
     * @Route("/piocher/{id}", name="piocher_carte")
     */
    public function piocherCarteAction(Parties $id)
    {
        $cartes = $this->getDoctrine()->getRepository('AppBundle:Cartes')->getAll();
        $user = $this->getUser();


        $situation = $id->getSituation();

        $pioche = $situation->getPioche();
        $piochetab = json_decode($pioche);

        // selectionner le dernier élément du tableau pioche dans dernier
        $dernier=array_pop($piochetab);

        // nouvelle pioche sans le $dernier
        $nouvellepioche = array_diff($piochetab, [$dernier]);

        if ('1'=='1'){
            $main_joueur1 = $situation->getMainJ1();
            $plateau['mainJ1'] = json_decode($main_joueur1);
            $mainj1 = $plateau['mainJ1'];

            // ajout de dernier dans main du joueur 1
            $mainj1[]=$dernier;
            $situation->setMainJ1($mainj1);

            // on remet les tableaux en json avec les nouvelles valeurs dans la bdd
            $em = $this->getDoctrine()->getManager();
            $situation->setMainJ1(json_encode($mainj1));
            $situation->setPioche(json_encode($nouvellepioche));
//            $em->persist($situation);
//            $em->flush();

        }


        return $this->render(':joueur:pioche.html.twig', ['cartes' => $cartes, 'id' => $id, 'user' => $user, 'pioche' => $pioche,'partie' => $id, 'piochetab' => $piochetab, 'nouvellepioche' => $nouvellepioche, 'dernier' => $dernier]);
    }

}