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

        // recup des mains dans un plateau
        $plateau['mainJ1'] = json_decode($situation->getMainJ1());
        $plateau['mainJ2'] = json_decode($situation->getMainJ2());

//        // recup dans cartes J1 posées dans un tapis
//        $tapis['pose_j1cat1'] = json_decode($situation->getCartesPoseesJ1Cat1());
//        $tapis['pose_j1cat2'] = json_decode($situation->getCartesPoseesJ1Cat2());
//        $tapis['pose_j1cat3'] = json_decode($situation->getCartesPoseesJ1Cat3());
//        $tapis['pose_j1cat4'] = json_decode($situation->getCartesPoseesJ1Cat4());
//        $tapis['pose_j1cat5'] = json_decode($situation->getCartesPoseesJ1Cat5());
//
//        // recup dans cartes J2 posées dans un tapis
//        $tapis['pose_j2cat1'] = json_decode($situation->getCartesPoseesJ2Cat1());
//        $tapis['pose_j2cat2'] = json_decode($situation->getCartesPoseesJ2Cat2());
//        $tapis['pose_j2cat3'] = json_decode($situation->getCartesPoseesJ2Cat3());
//        $tapis['pose_j2cat4'] = json_decode($situation->getCartesPoseesJ2Cat4());
//        $tapis['pose_j2cat5'] = json_decode($situation->getCartesPoseesJ2Cat5());

                                    // recup des cartes posées j1 : en decode si vide / en ajout tab si plein
                                    if (!empty($situation->getCartesPoseesJ1Cat1())){
                                        $tapis['pose_j1cat1'] = json_decode($situation->getCartesPoseesJ1Cat1());
                                    }else {
                                        $tapis['pose_j1cat1'] = $situation->getCartesPoseesJ1Cat1();
                                        $tapis['pose_j1cat1'] = array();
                                    }
                                    if (!empty($situation->getCartesPoseesJ1Cat2())){
                                        $tapis['pose_j1cat2'] = json_decode($situation->getCartesPoseesJ1Cat2());
                                    }else {
                                        $tapis['pose_j1cat2'] = $situation->getCartesPoseesJ1Cat2();
                                        $tapis['pose_j1cat2'] = array();
                                    }
                                    if (!empty($situation->getCartesPoseesJ1Cat3())){
                                        $tapis['pose_j1cat3'] = json_decode($situation->getCartesPoseesJ1Cat3());
                                    }else {
                                        $tapis['pose_j1cat3'] = $situation->getCartesPoseesJ1Cat3();
                                        $tapis['pose_j1cat3'] = array();
                                    }
                                    if (!empty($situation->getCartesPoseesJ1Cat4())){
                                        $tapis['pose_j1cat4'] = json_decode($situation->getCartesPoseesJ1Cat4());
                                    }else {
                                        $tapis['pose_j1cat4'] = $situation->getCartesPoseesJ1Cat4();
                                        $tapis['pose_j1cat4'] = array();
                                    }
                                    if (!empty($situation->getCartesPoseesJ1Cat2())){
                                        $tapis['pose_j1cat5'] = json_decode($situation->getCartesPoseesJ1Cat5());
                                    }else {
                                        $tapis['pose_j1cat5'] = $situation->getCartesPoseesJ1Cat5();
                                        $tapis['pose_j1cat5'] = array();
                                    }

                                    // recup des cartes posées j2 : en decode si vide / en ajout tab si plein
                                    if (!empty($situation->getCartesPoseesJ2Cat1())){
                                        $tapis['pose_j2cat1'] = json_decode($situation->getCartesPoseesJ2Cat1());
                                    }else {
                                        $tapis['pose_j2cat1'] = $situation->getCartesPoseesJ2Cat1();
                                        $tapis['pose_j2cat1'] = array();
                                    }
                                    if (!empty($situation->getCartesPoseesJ2Cat2())){
                                        $tapis['pose_j2cat2'] = json_decode($situation->getCartesPoseesJ2Cat2());
                                    }else {
                                        $tapis['pose_j2cat2'] = $situation->getCartesPoseesJ2Cat2();
                                        $tapis['pose_j1cat2'] = array();
                                    }
                                    if (!empty($situation->getCartesPoseesJ2Cat3())){
                                        $tapis['pose_j2cat3'] = json_decode($situation->getCartesPoseesJ2Cat3());
                                    }else {
                                        $tapis['pose_j2cat3'] = $situation->getCartesPoseesJ2Cat3();
                                        $tapis['pose_j2cat3'] = array();
                                    }
                                    if (!empty($situation->getCartesPoseesJ2Cat4())){
                                        $tapis['pose_j2cat4'] = json_decode($situation->getCartesPoseesJ2Cat4());
                                    }else {
                                        $tapis['pose_j2cat4'] = $situation->getCartesPoseesJ2Cat4();
                                        $tapis['pose_j2cat4'] = array();
                                    }
                                    if (!empty($situation->getCartesPoseesJ2Cat2())){
                                        $tapis['pose_j2cat5'] = json_decode($situation->getCartesPoseesJ2Cat5());
                                    }else {
                                        $tapis['pose_j2cat5'] = $situation->getCartesPoseesJ2Cat5();
                                        $tapis['pose_j2cat5'] = array();
                                    }






// recup des cartes defaussées : en decode si vide / en ajout tab si plein
        if (!empty($situation->getcartesDefausseesCat1())){
            $tapisdef['def_cat1'] = json_decode($situation->getcartesDefausseesCat1());
        }else {
            $tapisdef['def_cat1'] = $situation->getcartesDefausseesCat1();
            $tapisdef['def_cat1'] = array();
        }

        if (!empty($situation->getcartesDefausseesCat2())){
            $tapisdef['def_cat2'] = json_decode($situation->getcartesDefausseesCat2());
        }else {
            $tapisdef['def_cat2'] = $situation->getcartesDefausseesCat2();
            $tapisdef['def_cat2'] = array();
        }

        if (!empty($situation->getcartesDefausseesCat3())){
            $tapisdef['def_cat3'] = json_decode($situation->getcartesDefausseesCat3());
        }else {
            $tapisdef['def_cat3'] = $situation->getcartesDefausseesCat3();
            $tapisdef['def_cat3'] = array();
        }

        if (!empty($situation->getcartesDefausseesCat4())){
            $tapisdef['def_cat4'] = json_decode($situation->getcartesDefausseesCat4());
        }else {
            $tapisdef['def_cat4'] = $situation->getcartesDefausseesCat4();
            $tapisdef['def_cat4'] = array();
        }

        if (!empty($situation->getcartesDefausseesCat5())){
            $tapisdef['def_cat5'] = json_decode($situation->getcartesDefausseesCat5());
        }else {
            $tapisdef['def_cat5'] = $situation->getcartesDefausseesCat5();
            $tapisdef['def_cat5'] = array();
        }


        // recup tour de
        $tourde = $id->getTourde();

        return $this->render(':joueur:afficherpartie.html.twig', ['cartes' => $cartes, 'partie' => $id, 'user' => $user, 'plateau' => $plateau, 'tourde' => $tourde, 'tapis' => $tapis, 'tapisdef' => $tapisdef]);
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


        // recup des cartes posées j1 : en decode si vide / en ajout tab si plein
        if (!empty($situation->getCartesPoseesJ1Cat1())){
            $tapis['pose_j1cat1'] = json_decode($situation->getCartesPoseesJ1Cat1());
        }else {
            $tapis['pose_j1cat1'] = $situation->getCartesPoseesJ1Cat1();
            $tapis['pose_j1cat1'] = array();
        }
        if (!empty($situation->getCartesPoseesJ1Cat2())){
            $tapis['pose_j1cat2'] = json_decode($situation->getCartesPoseesJ1Cat2());
        }else {
            $tapis['pose_j1cat2'] = $situation->getCartesPoseesJ1Cat2();
            $tapis['pose_j1cat2'] = array();
        }
        if (!empty($situation->getCartesPoseesJ1Cat3())){
            $tapis['pose_j1cat3'] = json_decode($situation->getCartesPoseesJ1Cat3());
        }else {
            $tapis['pose_j1cat3'] = $situation->getCartesPoseesJ1Cat3();
            $tapis['pose_j1cat3'] = array();
        }
        if (!empty($situation->getCartesPoseesJ1Cat4())){
            $tapis['pose_j1cat4'] = json_decode($situation->getCartesPoseesJ1Cat4());
        }else {
            $tapis['pose_j1cat4'] = $situation->getCartesPoseesJ1Cat4();
            $tapis['pose_j1cat4'] = array();
        }
        if (!empty($situation->getCartesPoseesJ1Cat2())){
            $tapis['pose_j1cat5'] = json_decode($situation->getCartesPoseesJ1Cat5());
        }else {
            $tapis['pose_j1cat5'] = $situation->getCartesPoseesJ1Cat5();
            $tapis['pose_j1cat5'] = array();
        }

        // recup des cartes posées j2 : en decode si vide / en ajout tab si plein
        if (!empty($situation->getCartesPoseesJ2Cat1())){
            $tapis['pose_j2cat1'] = json_decode($situation->getCartesPoseesJ2Cat1());
        }else {
            $tapis['pose_j2cat1'] = $situation->getCartesPoseesJ2Cat1();
            $tapis['pose_j2cat1'] = array();
        }
        if (!empty($situation->getCartesPoseesJ2Cat2())){
            $tapis['pose_j2cat2'] = json_decode($situation->getCartesPoseesJ2Cat2());
        }else {
            $tapis['pose_j2cat2'] = $situation->getCartesPoseesJ2Cat2();
            $tapis['pose_j1cat2'] = array();
        }
        if (!empty($situation->getCartesPoseesJ2Cat3())){
            $tapis['pose_j2cat3'] = json_decode($situation->getCartesPoseesJ2Cat3());
        }else {
            $tapis['pose_j2cat3'] = $situation->getCartesPoseesJ2Cat3();
            $tapis['pose_j2cat3'] = array();
        }
        if (!empty($situation->getCartesPoseesJ2Cat4())){
            $tapis['pose_j2cat4'] = json_decode($situation->getCartesPoseesJ2Cat4());
        }else {
            $tapis['pose_j2cat4'] = $situation->getCartesPoseesJ2Cat4();
            $tapis['pose_j2cat4'] = array();
        }
        if (!empty($situation->getCartesPoseesJ2Cat2())){
            $tapis['pose_j2cat5'] = json_decode($situation->getCartesPoseesJ2Cat5());
        }else {
            $tapis['pose_j2cat5'] = $situation->getCartesPoseesJ2Cat5();
            $tapis['pose_j2cat5'] = array();
        }


        // Joueur 1
        if ($jactif == $idj1){
            $main_j1 = $plateau['mainJ1'];

            // recup de la carte select
            $carteselect = $request->get('carteselect');
            $categorie_carteselect = $cartes[$carteselect]->getCategorie()->getId();

            // recup categorie
            $categoriepose = $request->get('categoriepose');

            // Actu le plateau avec la carte en fonction de la cat
            switch ($categorie_carteselect) {
                case 1:
                    array_push($tapis['pose_j1cat1'],$carteselect);
                    break;
                case 2:
                    array_push($tapis['pose_j1cat2'],$carteselect);
                    break;
                case 3:
                    array_push($tapis['pose_j1cat3'],$carteselect);
                    break;
                case 4:
                    array_push($tapis['pose_j1cat4'],$carteselect);
                    break;
                case 5:
                    array_push($tapis['pose_j1cat5'],$carteselect);
                    break;
            }
            $em = $this->getDoctrine()->getManager();

            $situation->setCartesPoseesJ1Cat1(json_encode($tapis['pose_j1cat1']));
            $situation->setCartesPoseesJ1Cat2(json_encode($tapis['pose_j1cat2']));
            $situation->setCartesPoseesJ1Cat3(json_encode($tapis['pose_j1cat3']));
            $situation->setCartesPoseesJ1Cat4(json_encode($tapis['pose_j1cat4']));
            $situation->setCartesPoseesJ1Cat5(json_encode($tapis['pose_j1cat5']));


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

        // Joueur 2
        if ($jactif == $idj2){
            $main_j2 = $plateau['mainJ2'];

            // recup de la carte select
            $carteselect = $request->get('carteselect');
            $categorie_carteselect = $cartes[$carteselect]->getCategorie()->getId();

            // recup categorie
            $categoriepose = $request->get('categoriepose');

            // Actu le plateau avec la carte en fonction de la cat
            switch ($categorie_carteselect) {
                case 1:
                    array_push($tapis['pose_j2cat1'],$carteselect);
                    break;
                case 2:
                    array_push($tapis['pose_j2cat2'],$carteselect);
                    break;
                case 3:
                    array_push($tapis['pose_j2cat3'],$carteselect);
                    break;
                case 4:
                    array_push($tapis['pose_j2cat4'],$carteselect);
                    break;
                case 5:
                    array_push($tapis['pose_j2cat5'],$carteselect);
                    break;
            }
            $em = $this->getDoctrine()->getManager();

            $situation->setCartesPoseesJ2Cat1(json_encode($tapis['pose_j2cat1']));
            $situation->setCartesPoseesJ2Cat2(json_encode($tapis['pose_j2cat2']));
            $situation->setCartesPoseesJ2Cat3(json_encode($tapis['pose_j2cat3']));
            $situation->setCartesPoseesJ2Cat4(json_encode($tapis['pose_j2cat4']));
            $situation->setCartesPoseesJ2Cat5(json_encode($tapis['pose_j2cat5']));


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


//        return $this->render(':joueur:poser.html.twig', ['plateau' => $plateau, 'partie' => $id, 'carteselect' => $carteselect, 'j2_cat4' => $tapis['pose_j2cat5'], 'j1_cat4' => $tapis['pose_j1cat5']]);
        return $this->redirectToRoute('afficher_partie', ['id' => $id->getId(), 'tapis' => $tapis]);
    }

    /**
     * @param Parties $id
     * @Route("/defausser/{id}", name="defausser_carte")
     */
    public function defausserCartePartieAction(Parties $id, Request $request)
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
        $main_j1=$plateau['mainJ1'];
        $main_j2=$plateau['mainJ2'];


        // recup des cartes defaussées : en decode si vide / en ajout tab si plein
        if (!empty($situation->getcartesDefausseesCat1())){
            $tapisdef['def_cat1'] = json_decode($situation->getcartesDefausseesCat1());
        }else {
            $tapisdef['def_cat1'] = $situation->getcartesDefausseesCat1();
            $tapisdef['def_cat1'] = array();
        }

        if (!empty($situation->getcartesDefausseesCat2())){
            $tapisdef['def_cat2'] = json_decode($situation->getcartesDefausseesCat2());
        }else {
            $tapisdef['def_cat2'] = $situation->getcartesDefausseesCat2();
            $tapisdef['def_cat2'] = array();
        }

        if (!empty($situation->getcartesDefausseesCat3())){
            $tapisdef['def_cat3'] = json_decode($situation->getcartesDefausseesCat3());
        }else {
            $tapisdef['def_cat3'] = $situation->getcartesDefausseesCat3();
            $tapisdef['def_cat3'] = array();
        }

        if (!empty($situation->getcartesDefausseesCat4())){
            $tapisdef['def_cat4'] = json_decode($situation->getcartesDefausseesCat4());
        }else {
            $tapisdef['def_cat4'] = $situation->getcartesDefausseesCat4();
            $tapisdef['def_cat4'] = array();
        }

        if (!empty($situation->getcartesDefausseesCat5())){
            $tapisdef['def_cat5'] = json_decode($situation->getcartesDefausseesCat5());
        }else {
            $tapisdef['def_cat5'] = $situation->getcartesDefausseesCat5();
            $tapisdef['def_cat5'] = array();
        }


        // recup de la carte select
        $carteselect = $request->get('carteselect');
        $categorie_carteselect = $cartes[$carteselect]->getCategorie()->getId();


        // Actu le plateau avec la carte en fonction de la cat
        switch ($categorie_carteselect) {
            case 1:
                array_push($tapisdef['def_cat1'],$carteselect);
                break;
            case 2:
                array_push($tapisdef['def_cat2'],$carteselect);
                break;
            case 3:
                array_push($tapisdef['def_cat3'],$carteselect);
                break;
            case 4:
                array_push($tapisdef['def_cat4'],$carteselect);
                break;
            case 5:
                array_push($tapisdef['def_cat5'],$carteselect);
                break;
        }
        $em = $this->getDoctrine()->getManager();


        $situation->setcartesDefausseesCat1(json_encode($tapisdef['def_cat1']));
        $situation->setcartesDefausseesCat2(json_encode($tapisdef['def_cat2']));
        $situation->setcartesDefausseesCat3(json_encode($tapisdef['def_cat3']));
        $situation->setcartesDefausseesCat4(json_encode($tapisdef['def_cat4']));
        $situation->setcartesDefausseesCat5(json_encode($tapisdef['def_cat5']));

        $partie=$situation->getId();
        $em->persist($situation);
        $em->flush();



        if ($jactif == $idj1){
            $main_j1=$plateau['mainJ1'];

            // recup de la carte select
            $carteselect = $request->get('carteselect');
            $categorie_carteselect = $cartes[$carteselect]->getCategorie()->getId();


            $main_j1 = array();
            $main_j1 = $plateau['mainJ1'];
            $new_main_j1 = $this->supprimeCarteMain($main_j1,$carteselect);

            $em = $this->getDoctrine()->getManager();
            $new_main_j1_encode = json_encode($new_main_j1);
            $situation->setMainJ1($new_main_j1_encode);
            $em->persist($situation);
            $em->flush();
        }

        if ($jactif == $idj2){
            $main_j2=$plateau['mainJ2'];

            // recup de la carte select
            $carteselect = $request->get('carteselect');
            $categorie_carteselect = $cartes[$carteselect]->getCategorie()->getId();


            $main_j2 = array();
            $main_j2 = $plateau['mainJ2'];
            $new_main_j2 = $this->supprimeCarteMain($main_j2,$carteselect);

            $em = $this->getDoctrine()->getManager();
            $new_main_j2_encode = json_encode($new_main_j2);
            $situation->setMainJ2($new_main_j2_encode);
            $em->persist($situation);
            $em->flush();
        }


//                return $this->render(':joueur:defausser.html.twig', ['plateau' => $plateau, 'partie' => $id, 'carteselect' => $carteselect, 'tapisdef' => $tapisdef, 'def_cat4' => $tapisdef['def_cat5']]);
        return $this->redirectToRoute('afficher_partie', ['id' => $id->getId(), 'tapisdef' => $tapisdef]);
    }

    /**
     * @param Parties $id
     * @Route("/piocher_def1/{id}", name="piocher_def1_carte")
     */
    public function piocherDef1CarteAction(Parties $id)
    {

        $cartes = $this->getDoctrine()->getRepository('AppBundle:Cartes')->getAll();
        $user = $this->getUser();
        $situation = $id->getSituation();


        $pioche_def1 = $situation->getcartesDefausseesCat1();
            $piochetab1 = json_decode($pioche_def1);

            // selectionner le dernier élément du tableau pioche dans dernier
            $dernier=array_pop($piochetab1);

            // nouvelle pioche sans le $dernier
            $nouvellepioche1 = array_diff($piochetab1, [$dernier]);

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
                    $situation->setcartesDefausseesCat1(json_encode($nouvellepioche1));
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
                    $situation->setcartesDefausseesCat1(json_encode($nouvellepioche1));
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

        return $this->redirectToRoute('afficher_partie', ['id' => $id->getId()]);
    }


    /**
     * @param Parties $id
     * @Route("/piocher_def2/{id}", name="piocher_def2_carte")
     */
    public function piocherDef2CarteAction(Parties $id)
    {

        $cartes = $this->getDoctrine()->getRepository('AppBundle:Cartes')->getAll();
        $user = $this->getUser();
        $situation = $id->getSituation();


        $pioche_def2 = $situation->getcartesDefausseesCat2();
        $piochetab2 = json_decode($pioche_def2);

        // selectionner le dernier élément du tableau pioche dans dernier
        $dernier=array_pop($piochetab2);

        // nouvelle pioche sans le $dernier
        $nouvellepioche2 = array_diff($piochetab2, [$dernier]);

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
                $situation->setcartesDefausseesCat2(json_encode($nouvellepioche2));
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
                $situation->setcartesDefausseesCat2(json_encode($nouvellepioche2));
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

        return $this->redirectToRoute('afficher_partie', ['id' => $id->getId()]);
    }

    /**
     * @param Parties $id
     * @Route("/piocher_def3/{id}", name="piocher_def3_carte")
     */
    public function piocherDef3CarteAction(Parties $id)
    {

        $cartes = $this->getDoctrine()->getRepository('AppBundle:Cartes')->getAll();
        $user = $this->getUser();
        $situation = $id->getSituation();


        $pioche_def3 = $situation->getcartesDefausseesCat3();
        $piochetab3 = json_decode($pioche_def3);

        // selectionner le dernier élément du tableau pioche dans dernier
        $dernier=array_pop($piochetab3);

        // nouvelle pioche sans le $dernier
        $nouvellepioche3 = array_diff($piochetab3, [$dernier]);

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
                $situation->setcartesDefausseesCat3(json_encode($nouvellepioche3));
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
                $situation->setcartesDefausseesCat3(json_encode($nouvellepioche3));
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

        return $this->redirectToRoute('afficher_partie', ['id' => $id->getId()]);
    }


    /**
     * @param Parties $id
     * @Route("/piocher_def4/{id}", name="piocher_def4_carte")
     */
    public function piocherDef4CarteAction(Parties $id)
    {

        $cartes = $this->getDoctrine()->getRepository('AppBundle:Cartes')->getAll();
        $user = $this->getUser();
        $situation = $id->getSituation();


        $pioche_def4 = $situation->getcartesDefausseesCat4();
        $piochetab4 = json_decode($pioche_def4);

        // selectionner le dernier élément du tableau pioche dans dernier
        $dernier=array_pop($piochetab4);

        // nouvelle pioche sans le $dernier
        $nouvellepioche4 = array_diff($piochetab4, [$dernier]);

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
                $situation->setcartesDefausseesCat4(json_encode($nouvellepioche4));
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
                $situation->setcartesDefausseesCat4(json_encode($nouvellepioche4));
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

        return $this->redirectToRoute('afficher_partie', ['id' => $id->getId()]);
    }

    /**
     * @param Parties $id
     * @Route("/piocher_def5/{id}", name="piocher_def5_carte")
     */
    public function piocherDef5CarteAction(Parties $id)
    {

        $cartes = $this->getDoctrine()->getRepository('AppBundle:Cartes')->getAll();
        $user = $this->getUser();
        $situation = $id->getSituation();


        $pioche_def5 = $situation->getcartesDefausseesCat5();
        $piochetab5 = json_decode($pioche_def5);

        // selectionner le dernier élément du tableau pioche dans dernier
        $dernier=array_pop($piochetab5);

        // nouvelle pioche sans le $dernier
        $nouvellepioche5 = array_diff($piochetab5, [$dernier]);

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
                $situation->setcartesDefausseesCat5(json_encode($nouvellepioche5));
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
                $situation->setcartesDefausseesCat5(json_encode($nouvellepioche5));
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

        return $this->redirectToRoute('afficher_partie', ['id' => $id->getId()]);
    }

    private function supprimeCarteMain($mainj1,$carteselect)
    {
        $t =array();
        foreach ($mainj1 as $m)
        {
            if ($m != $carteselect)
            {
                $t[] = $m;
            }
        }

        return $t;
    }


}