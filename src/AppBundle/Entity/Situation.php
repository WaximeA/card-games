<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Situation
 *
 * @ORM\Table(name="situation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SituationRepository")
 */
class Situation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\Column(name="main_j1", type="json_array")
     */
    private $mainJ1;

    /**
     * @var array
     *
     * @ORM\Column(name="main_j2", type="json_array")
     */
    private $mainJ2;

    /**
     * @var array
     *
     * @ORM\Column(name="pioche", type="json_array")
     */
    private $pioche;











//                   *--------- POSER DEBUT ---------*
//                                  *--------- POSER J1 DEBUT ---------*
//    /**
//     * @var array
//     *
//     * @ORM\Column(name="cartes_posees_j1", type="json_array", nullable=true)
//     */
//    private $cartesPoseesJ1;

    // Cartes posées -> 5 catégries -> J1
                    /**
                     * @var array
                     *
                     * @ORM\Column(name="cartes_posees_j1_cat1", type="json_array", nullable=true)
                     */
                    private $cartesPoseesJ1Cat1;

                                /**
                                 * Set cartesPoseesJ1Cat1
                                 *
                                 * @param array $cartesPoseesJ1Cat1
                                 *
                                 * @return Situation
                                 */
                                public function setcartesPoseesJ1Cat1($cartesPoseesJ1Cat1)
                                {
                                    $this->cartesPoseesJ1Cat1 = $cartesPoseesJ1Cat1;
                                    return $this;
                                }

                                /**
                                 * Get cartesPoseesJ1Cat1
                                 *
                                 * @return array
                                 */
                                public function getcartesPoseesJ1Cat1()
                                {
                                    return $this->cartesPoseesJ1Cat1;
                                }

                    /**
                     * @var array
                     *
                     * @ORM\Column(name="cartes_posees_j1_cat2", type="json_array", nullable=true)
                     */
                    private $cartesPoseesJ1Cat2;

                                /**
                                 * Set cartesPoseesJ1Cat2
                                 *
                                 * @param array $cartesPoseesJ1Cat2
                                 *
                                 * @return Situation
                                 */
                                public function setcartesPoseesJ1Cat2($cartesPoseesJ1Cat2)
                                {
                                    $this->cartesPoseesJ1Cat2 = $cartesPoseesJ1Cat2;
                                    return $this;
                                }

                                /**
                                 * Get cartesPoseesJ1Cat2
                                 *
                                 * @return array
                                 */
                                public function getcartesPoseesJ1Cat2()
                                {
                                    return $this->cartesPoseesJ1Cat2;
                                }


                    /**
                     * @var array
                     *
                     * @ORM\Column(name="cartes_posees_j1_cat3", type="json_array", nullable=true)
                     */
                    private $cartesPoseesJ1Cat3;

                                /**
                                 * Set cartesPoseesJ1Cat3
                                 *
                                 * @param array $cartesPoseesJ1Cat3
                                 *
                                 * @return Situation
                                 */
                                public function setcartesPoseesJ1Cat3($cartesPoseesJ1Cat3)
                                {
                                    $this->cartesPoseesJ1Cat3 = $cartesPoseesJ1Cat3;
                                    return $this;
                                }

                                /**
                                 * Get cartesPoseesJ1Cat3
                                 *
                                 * @return array
                                 */
                                public function getcartesPoseesJ1Cat3()
                                {
                                    return $this->cartesPoseesJ1Cat3;
                                }


                    /**
                     * @var array
                     *
                     * @ORM\Column(name="cartes_posees_j1_cat4", type="json_array", nullable=true)
                     */
                    private $cartesPoseesJ1Cat4;

                                /**
                                 * Set cartesPoseesJ1Cat4
                                 *
                                 * @param array $cartesPoseesJ1Cat4
                                 *
                                 * @return Situation
                                 */
                                public function setcartesPoseesJ1Cat4($cartesPoseesJ1Cat4)
                                {
                                    $this->cartesPoseesJ1Cat4 = $cartesPoseesJ1Cat4;
                                    return $this;
                                }

                                /**
                                 * Get cartesPoseesJ1Cat4
                                 *
                                 * @return array
                                 */
                                public function getcartesPoseesJ1Cat4()
                                {
                                    return $this->cartesPoseesJ1Cat4;
                                }


                    /**
                     * @var array
                     *
                     * @ORM\Column(name="cartes_posees_j1_cat5", type="json_array", nullable=true)
                     */
                    private $cartesPoseesJ1Cat5;

                                /**
                                 * Set cartesPoseesJ1Cat5
                                 *
                                 * @param array $cartesPoseesJ1Cat5
                                 *
                                 * @return Situation
                                 */
                                public function setcartesPoseesJ1Cat5($cartesPoseesJ1Cat5)
                                {
                                    $this->cartesPoseesJ1Cat5 = $cartesPoseesJ1Cat5;
                                    return $this;
                                }

                                /**
                                 * Get cartesPoseesJ1Cat5
                                 *
                                 * @return array
                                 */
                                public function getcartesPoseesJ1Cat5()
                                {
                                    return $this->cartesPoseesJ1Cat5;
                                }

//    /**
//     * Set cartesPoseesJ1
//     *
//     * @param array $cartesPoseesJ1
//     *
//     * @return Situation
//     */
//    public function setCartesPoseesJ1($cartesPoseesJ1)
//    {
//        $this->cartesPoseesJ1 = $cartesPoseesJ1;
//        return $this;
//    }
//
//    /**
//     * Get cartesPoseesJ1
//     *
//     * @return array
//     */
//    public function getCartesPoseesJ1()
//    {
//        return $this->cartesPoseesJ1;
//    }
//                                  *--------- POSER J1 FIN ---------*


//                                  *--------- POSER J2 DEBUT ---------*
//    /**
//     * @var array
//     *
//     * @ORM\Column(name="cartes_posees_j2", type="json_array", nullable=true)
//     */
//    private $cartesPoseesJ2;

                    /**
                     * @var array
                     *
                     * @ORM\Column(name="cartes_posees_j2_cat1", type="json_array", nullable=true)
                     */
                    private $cartesPoseesJ2Cat1;

                            /**
                             * Set cartesPoseesJ2Cat1
                             *
                             * @param array $cartesPoseesJ2Cat1
                             *
                             * @return Situation
                             */
                            public function setcartesPoseesJ2Cat1($cartesPoseesJ2Cat1)
                            {
                                $this->cartesPoseesJ2Cat1 = $cartesPoseesJ2Cat1;
                                return $this;
                            }

                            /**
                             * Get cartesPoseesJ2Cat1
                             *
                             * @return array
                             */
                            public function getcartesPoseesJ2Cat1()
                            {
                                return $this->cartesPoseesJ2Cat1;
                            }

                    /**
                     * @var array
                     *
                     * @ORM\Column(name="cartes_posees_j2_cat2", type="json_array", nullable=true)
                     */
                    private $cartesPoseesJ2Cat2;

                            /**
                             * Set cartesPoseesJ2Cat2
                             *
                             * @param array $cartesPoseesJ2Cat2
                             *
                             * @return Situation
                             */
                            public function setcartesPoseesJ2Cat2($cartesPoseesJ2Cat2)
                            {
                                $this->cartesPoseesJ2Cat2 = $cartesPoseesJ2Cat2;
                                return $this;
                            }

                            /**
                             * Get cartesPoseesJ2Cat2
                             *
                             * @return array
                             */
                            public function getcartesPoseesJ2Cat2()
                            {
                                return $this->cartesPoseesJ2Cat2;
                            }


                    /**
                     * @var array
                     *
                     * @ORM\Column(name="cartes_posees_j2_cat3", type="json_array", nullable=true)
                     */
                    private $cartesPoseesJ2Cat3;

                            /**
                             * Set cartesPoseesJ2Cat3
                             *
                             * @param array $cartesPoseesJ2Cat3
                             *
                             * @return Situation
                             */
                            public function setcartesPoseesJ2Cat3($cartesPoseesJ2Cat3)
                            {
                                $this->cartesPoseesJ2Cat3 = $cartesPoseesJ2Cat3;
                                return $this;
                            }

                            /**
                             * Get cartesPoseesJ2Cat3
                             *
                             * @return array
                             */
                            public function getcartesPoseesJ2Cat3()
                            {
                                return $this->cartesPoseesJ2Cat3;
                            }


                    /**
                     * @var array
                     *
                     * @ORM\Column(name="cartes_posees_j2_cat4", type="json_array", nullable=true)
                     */
                    private $cartesPoseesJ2Cat4;

                            /**
                             * Set cartesPoseesJ2Cat4
                             *
                             * @param array $cartesPoseesJ2Cat4
                             *
                             * @return Situation
                             */
                            public function setcartesPoseesJ2Cat4($cartesPoseesJ2Cat4)
                            {
                                $this->cartesPoseesJ2Cat4 = $cartesPoseesJ2Cat4;
                                return $this;
                            }

                            /**
                             * Get cartesPoseesJ2Cat4
                             *
                             * @return array
                             */
                            public function getcartesPoseesJ2Cat4()
                            {
                                return $this->cartesPoseesJ2Cat4;
                            }


                    /**
                     * @var array
                     *
                     * @ORM\Column(name="cartes_posees_j2_cat5", type="json_array", nullable=true)
                     */
                    private $cartesPoseesJ2Cat5;

                            /**
                             * Set cartesPoseesJ2Cat5
                             *
                             * @param array $cartesPoseesJ2Cat5
                             *
                             * @return Situation
                             */
                            public function setcartesPoseesJ2Cat5($cartesPoseesJ2Cat5)
                            {
                                $this->cartesPoseesJ2Cat5 = $cartesPoseesJ2Cat5;
                                return $this;
                            }

                            /**
                             * Get cartesPoseesJ2Cat5
                             *
                             * @return array
                             */
                            public function getcartesPoseesJ2Cat5()
                            {
                                return $this->cartesPoseesJ2Cat5;
                            }

//    /**
//     * Set cartesPoseesJ2
//     *
//     * @param array $cartesPoseesJ2
//     *
//     * @return Situation
//     */
//    public function setCartesPoseesJ2($cartesPoseesJ2)
//    {
//        $this->cartesPoseesJ2 = $cartesPoseesJ2;
//        return $this;
//    }
//
//    /**
//     * Get cartesPoseesJ2
//     *
//     * @return array
//     */
//    public function getCartesPoseesJ2()
//    {
//        return $this->cartesPoseesJ2;
//    }

    //                                  *--------- POSER J2 FIN ---------*

//                   *--------- POSER FIN ---------*






//                   *--------- DEFAUSSE DEBUT ---------*
//
//    /**
//     * @var array
//     *
//     * @ORM\Column(name="defausse", type="array", nullable=true)
//     */
//    private $defausse;

    // Cartes defaussées -> 5 catégries
                    /**
                     * @var array
                     *
                     * @ORM\Column(name="cartes_defaussees_cat1", type="json_array", nullable=true)
                     */
                    private $cartesDefausseesCat1;

                                /**
                                 * Set cartesDefausseesCat1
                                 *
                                 * @param array $cartesDefausseesCat1
                                 *
                                 * @return Situation
                                 */
                                public function setcartesDefausseesCat1($cartesDefausseesCat1)
                                {
                                    $this->cartesDefausseesCat1 = $cartesDefausseesCat1;
                                    return $this;
                                }

                                /**
                                 * Get cartesDefausseesCat1
                                 *
                                 * @return array
                                 */
                                public function getcartesDefausseesCat1()
                                {
                                    return $this->cartesDefausseesCat1;
                                }


                    /**
                     * @var array
                     *
                     * @ORM\Column(name="cartes_defaussees_cat2", type="json_array", nullable=true)
                     */
                    private $cartesDefausseesCat2;

                                /**
                                 * Set cartesDefausseesCat2
                                 *
                                 * @param array $cartesDefausseesCat2
                                 *
                                 * @return Situation
                                 */
                                public function setcartesDefausseesCat2($cartesDefausseesCat2)
                                {
                                    $this->cartesDefausseesCat2 = $cartesDefausseesCat2;
                                    return $this;
                                }

                                /**
                                 * Get cartesDefausseesCat2
                                 *
                                 * @return array
                                 */
                                public function getcartesDefausseesCat2()
                                {
                                    return $this->cartesDefausseesCat2;
                                }


                    /**
                     * @var array
                     *
                     * @ORM\Column(name="cartes_defaussees_cat3", type="json_array", nullable=true)
                     */
                    private $cartesDefausseesCat3;

                                /**
                                 * Set cartesDefausseesCat3
                                 *
                                 * @param array $cartesDefausseesCat3
                                 *
                                 * @return Situation
                                 */
                                public function setcartesDefausseesCat3($cartesDefausseesCat3)
                                {
                                    $this->cartesDefausseesCat3 = $cartesDefausseesCat3;
                                    return $this;
                                }

                                /**
                                 * Get cartesDefausseesCat3
                                 *
                                 * @return array
                                 */
                                public function getcartesDefausseesCat3()
                                {
                                    return $this->cartesDefausseesCat3;
                                }



                    /**
                     * @var array
                     *
                     * @ORM\Column(name="cartes_defaussees_cat4", type="json_array", nullable=true)
                     */
                    private $cartesDefausseesCat4;

                                /**
                                 * Set cartesDefausseesCat4
                                 *
                                 * @param array $cartesDefausseesCat4
                                 *
                                 * @return Situation
                                 */
                                public function setcartesDefausseesCat4($cartesDefausseesCat4)
                                {
                                    $this->cartesDefausseesCat4 = $cartesDefausseesCat4;
                                    return $this;
                                }

                                /**
                                 * Get cartesDefausseesCat4
                                 *
                                 * @return array
                                 */
                                public function getcartesDefausseesCat4()
                                {
                                    return $this->cartesDefausseesCat4;
                                }


                    /**
                     * @var array
                     *
                     * @ORM\Column(name="cartes_defaussees_cat5", type="json_array", nullable=true)
                     */
                    private $cartesDefausseesCat5;
                                /**
                                 * Set cartesDefausseesCat5
                                 *
                                 * @param array $cartesDefausseesCat5
                                 *
                                 * @return Situation
                                 */
                                public function setcartesDefausseesCat5($cartesDefausseesCat5)
                                {
                                    $this->cartesDefausseesCat5 = $cartesDefausseesCat5;
                                    return $this;
                                }

                                /**
                                 * Get cartesDefausseesCat5
                                 *
                                 * @return array
                                 */
                                public function getcartesDefausseesCat5()
                                {
                                    return $this->cartesDefausseesCat5;
                                }



//    /**
//     * Set defausse
//     *
//     * @param array $defausse
//     *
//     * @return Situation
//     */
//    public function setDefausse($defausse)
//    {
//        $this->defausse = $defausse;
//        return $this;
//    }
//
//    /**
//     * Get defausse
//     *
//     * @return array
//     */
//    public function getDefausse()
//    {
//        return $this->defausse;
//    }

//                   *--------- DEFAUSSE FIN ---------*








    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Parties", mappedBy="situation")
     */
    private $partie;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mainJ1
     *
     * @param array $mainJ1
     *
     * @return Situation
     */
    public function setMainJ1($mainJ1)
    {
        $this->mainJ1 = $mainJ1;
        return $this;
    }

    /**
     * Get mainJ1
     *
     * @return array
     */
    public function getMainJ1()
    {
        return $this->mainJ1;
    }

    /**
     * Set mainJ2
     *
     * @param array $mainJ2
     *
     * @return Situation
     */
    public function setMainJ2($mainJ2)
    {
        $this->mainJ2 = $mainJ2;
        return $this;
    }

    /**
     * Get mainJ2
     *
     * @return array
     */
    public function getMainJ2()
    {
        return $this->mainJ2;
    }

    /**
     * Set pioche
     *
     * @param array $pioche
     *
     * @return Situation
     */
    public function setPioche($pioche)
    {
        $this->pioche = $pioche;
        return $this;
    }

    /**
     * Get pioche
     *
     * @return array
     */
    public function getPioche()
    {
        return $this->pioche;
    }


    /**
     * Set partie
     *
     * @param \AppBundle\Entity\Parties $partie
     *
     * @return Situation
     */
    public function setPartie(\AppBundle\Entity\Parties $partie = null)
    {
        $this->partie = $partie;
        return $this;
    }

    /**
     * Get partie
     *
     * @return \AppBundle\Entity\Parties
     */
    public function getPartie()
    {
        return $this->partie;
    }


}

