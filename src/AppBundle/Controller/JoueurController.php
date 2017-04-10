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


        // Recup des cartes de 0 à 7 pour la main du J1
        $t = array();
        for($i = 0; $i<8; $i++)
        {
            $t[] = $cartes[$i]->getId();
        }
        $situation->setMainJ1(json_encode($t));

        // Recup des cartes de 8 à 15 pour la main du J2
        $t = array();
        for($i = 8; $i<16; $i++)
        {
            $t[] = $cartes[$i]->getId();
        }
        $situation->setMainJ2(json_encode($t));

        // Recup des cartes de 16 au reste pour la pioche
        $t = array();
        for($i = 16; $i<count($cartes); $i++)
        {
            $t[] = $cartes[$i]->getId();
        }
        $situation->setPioche(json_encode($t));

        // Actu BDD de situation
        $em = $this->getDoctrine()->getManager();
        $em->persist($situation);
        $em->flush();



        //        // pas besoin de commenter, lis le nom de la varriable
        //        $creationplateaujoueur = array('ecaille' => array(), 'plume' => array(), 'poil' => array(), 'alien' => array(), 'corne' => array());

        // Création d'une nouvelle partie
        $partie = new Parties();
        $partie->setJoueur1($user);
        $partie->setJoueur2($joueur);
        $partie->setSituation($situation);
        $partie->setTourde( $user->getId());
        //        $situation->setCartesPoseesJ1(json_encode($creationplateaujoueur));
        //        $situation->setCartesPoseesJ2(json_encode($creationplateaujoueur));

        // Actu BDD de partie
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

        // recup de la main du joueur 1 et 2
        $main_joueur1 = $situation->getMainJ1();
        $main_joueur2 = $situation->getMainJ2();

        // Décode des mains dans un plateai
        $plateau['mainJ1'] = json_decode($main_joueur1);
        $plateau['mainJ2'] = json_decode($main_joueur2);

        // recup tour de
        $tourde = $id->getTourde();

        return $this->render(':joueur:afficherpartie.html.twig', ['cartes' => $cartes, 'partie' => $id, 'user' => $user, 'plateau' => $plateau, 'tourde' => $tourde]);
    }

    /**
     * @param Parties $id
     * @Route("/piocher/{id}", name="piocher_carte")
     */
    public function piocherCarteAction(Parties $id)
    {
        // $id = partie

        $cartes = $this->getDoctrine()->getRepository('AppBundle:Cartes')->getAll();
        $user = $this->getUser();
        $situation = $id->getSituation();

        $pioche = $situation->getPioche();
        $piochetab = json_decode($pioche);

        // selectionner le dernier élément du tableau pioche dans dernier
        $dernier=array_pop($piochetab);

        // nouvelle pioche sans le $dernier
        $nouvellepioche = array_diff($piochetab, [$dernier]);

        // récuperer l'id des deux joueurs
        $j1=$id->getJoueur1();
        $idj1=$j1->getId();

        $j2=$id->getJoueur2();
        $idj2=$j2->getId();

        // joueur actif
        $jactif = $user->getId();

        // recup tour de
        $tourde = $id->getTourde();


        if ($tourde == $jactif){
            // Si je joueur actif = à l'id du joueur 1
            if ($jactif ==  $idj1 ){
                $plateau['mainJ1'] = json_decode($situation->getMainJ1());
                $mainj1 = $plateau['mainJ1'];

                //   ajout de dernier dans main du joueur 1
                $mainj1[]=$dernier;
                $situation->setMainJ1($mainj1);

                //  on remet les tableaux en json avec les nouvelles valeurs dans la bdd
                $em = $this->getDoctrine()->getManager();
                $situation->setMainJ1(json_encode($mainj1));
                $situation->setPioche(json_encode($nouvellepioche));
                $em->persist($situation);
                $em->flush();

                // gestion tour
                $em = $this->getDoctrine()->getManager();
                $nouveautour = $idj2;
                $id->setTourde($nouveautour);
                $em->persist($id);
                $em->flush();
            }


            // Si je joueur actif = à l'id du joueur 2
            if ($jactif ==  $idj2 ){
                $plateau['mainJ2'] = json_decode($situation->getMainJ2());
                $mainj2 = $plateau['mainJ2'];

                //   ajout de dernier dans main du joueur 2
                $mainj2[]=$dernier;
                $situation->setMainJ2($mainj2);

                //   on remet les tableaux en json avec les nouvelles valeurs dans la bdd
                $em = $this->getDoctrine()->getManager();
                $situation->setMainJ2(json_encode($mainj2));
                $situation->setPioche(json_encode($nouvellepioche));
                $em->persist($situation);
                $em->flush();

                // gestion tour
                $em = $this->getDoctrine()->getManager();
                $nouveautour = $idj1;
                $id->setTourde($nouveautour);
                $em->persist($id);
                $em->flush();
            }
        }



//        return $this->render(':joueur:pioche.html.twig', ['cartes' => $cartes, 'id' => $id, 'user' => $user, 'pioche' => $pioche,'partie' => $id, 'piochetab' => $piochetab, 'nouvellepioche' => $nouvellepioche, 'dernier' => $dernier]);
        return $this->redirectToRoute('afficher_partie', ['id' => $id->getId()]);
    }


    /**
     * @param Parties $id
     * @Route("/poser/{id}", name="poser_carte")
     */
    public function poserCartePartieAction(Parties $id, Request $request)
    {
        $cartes = $this->getDoctrine()->getRepository('AppBundle:Cartes')->getAll();
        $user = $this->getUser();
        $situation = $id->getSituation();

        // récuperer l'id des deux joueurs
        $j1=$id->getJoueur1();
        $idj1=$j1->getId();

        $j2=$id->getJoueur2();
        $idj2=$j2->getId();

        // joueur actif
        $jactif = $user->getId();

        // recup tour de
        $tourde = $id->getTourde();

        // recup du plateau des mains des joueurs
        $plateau['mainJ1'] = json_decode($situation->getMainJ1());
        $plateau['mainJ2'] = json_decode($situation->getMainJ2());

        // recup des cartes posées j1 & j2 : en decode si vide / en ajout tab si plein
        if (!empty($situation->getCartesPoseesJ1())){
            $pose_j1 = json_decode($situation->getCartesPoseesJ1());
        } else {
        //            $pose_j1 = json_decode($situation->getCartesPoseesJ1());
        //            array( "1" => []);
            $pose_j1 = array();
        }
        if (!empty($situation->getCartesPoseesJ2())){
            $pose_j2 = json_decode($situation->getCartesPoseesJ2());
        } else {
        //            $pose_j2 = json_decode($situation->getCartesPoseesJ2());
        //            array( "1" => []);
            $pose_j2 = array();
        }


        $pose_j1 = array();
        if ($jactif == $idj1){
            $main_j1 = $plateau['mainJ1'];

            // recup de la carte select
            $carteselect = $request->get('carteselect');

            // recup categorie
            $categoriepose = $request->get('categoriepose');

            // actualiser le plateau
            array_push( $pose_j1,$carteselect);
            $em = $this->getDoctrine()->getManager();

            // on refait le tab json
            $situation->setCartesPoseesJ1(json_encode($pose_j1));
            $partie=$situation->getId();

            $em->persist($situation);
            $em->flush();

            $main_j1 = array();
            $main_j1 = $plateau['mainJ1'];
            $new_main_j1 = $this->supprimeCarteMain($main_j1,$carteselect);

            $em = $this->getDoctrine()->getManager();
            $new_main_j1_encode = json_encode($new_main_j1);
            $situation->setMainJ1($new_main_j1_encode);
            $em->persist($situation);
            $em->flush();

        }

        $pose_j2 = array();
        if ($jactif == $idj2){
            $main_j2 = $plateau['mainJ2'];

            // recup de la carte select
            $carteselect = $request->get('carteselect');

            // recup categorie
            $categoriepose = $request->get('categoriepose');

            // actualiser le plateau
            array_push( $pose_j2,$carteselect);
            $em = $this->getDoctrine()->getManager();

            // on refait le tab json
            $situation->setCartesPoseesJ1(json_encode($pose_j2));
            $partie=$situation->getId();

            $em->persist($situation);
            $em->flush();

            $main_j2 = array();
            $main_j2 = $plateau['mainJ2'];
            $new_main_j2 = $this->supprimeCarteMain($main_j2,$carteselect);

            $em = $this->getDoctrine()->getManager();
            $new_main_j2_encode = json_encode($new_main_j2);
            $situation->setMainJ2($new_main_j2_encode);
            $em->persist($situation);
            $em->flush();

        }


//        return $this->render(':joueur:poser.html.twig', ['plateau' => $plateau, 'partie' => $id, 'carteselect' => $carteselect]);
        return $this->redirectToRoute('afficher_partie', ['id' => $id->getId()]);
    }

    private function supprimeCarteMain($mainj1,$cartecheck)
    {
        $t =array();
        foreach ($mainj1 as $m)
        {
            if ($m != $cartecheck)
            {
                $t[] = $m;
            }
        }

        return $t;
    }




}