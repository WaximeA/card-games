<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jeux
 *
 * @ORM\Table(name="jeux")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JeuxRepository")
 */
class Jeux
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
     * @var string
     *
     * @ORM\Column(name="jeu_joueur1", type="string", length=255)
     */
    private $jeuJoueur1;

    /**
     * @var string
     *
     * @ORM\Column(name="jeu_joueur2", type="string", length=255)
     */
    private $jeuJoueur2;

    /**
     * @var string
     *
     * @ORM\Column(name="jeu_score_j1", type="string", length=255)
     */
    private $jeuScoreJ1;

    /**
     * @var string
     *
     * @ORM\Column(name="jeu_score_j2", type="string", length=255)
     */
    private $jeuScoreJ2;

    /**
     * @var string
     *
     * @ORM\Column(name="jeu_gagnant", type="string", length=255)
     */
    private $jeuGagnant;

    /**
     * @var string
     *
     * @ORM\Column(name="jeu_perdant", type="string", length=255)
     */
    private $jeuPerdant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="jeu_date", type="datetime")
     */
    private $jeuDate;


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
     * Set jeuJoueur1
     *
     * @param string $jeuJoueur1
     *
     * @return Jeux
     */
    public function setJeuJoueur1($jeuJoueur1)
    {
        $this->jeuJoueur1 = $jeuJoueur1;

        return $this;
    }

    /**
     * Get jeuJoueur1
     *
     * @return string
     */
    public function getJeuJoueur1()
    {
        return $this->jeuJoueur1;
    }

    /**
     * Set jeuJoueur2
     *
     * @param string $jeuJoueur2
     *
     * @return Jeux
     */
    public function setJeuJoueur2($jeuJoueur2)
    {
        $this->jeuJoueur2 = $jeuJoueur2;

        return $this;
    }

    /**
     * Get jeuJoueur2
     *
     * @return string
     */
    public function getJeuJoueur2()
    {
        return $this->jeuJoueur2;
    }

    /**
     * Set jeuScoreJ1
     *
     * @param string $jeuScoreJ1
     *
     * @return Jeux
     */
    public function setJeuScoreJ1($jeuScoreJ1)
    {
        $this->jeuScoreJ1 = $jeuScoreJ1;

        return $this;
    }

    /**
     * Get jeuScoreJ1
     *
     * @return string
     */
    public function getJeuScoreJ1()
    {
        return $this->jeuScoreJ1;
    }

    /**
     * Set jeuScoreJ2
     *
     * @param string $jeuScoreJ2
     *
     * @return Jeux
     */
    public function setJeuScoreJ2($jeuScoreJ2)
    {
        $this->jeuScoreJ2 = $jeuScoreJ2;

        return $this;
    }

    /**
     * Get jeuScoreJ2
     *
     * @return string
     */
    public function getJeuScoreJ2()
    {
        return $this->jeuScoreJ2;
    }

    /**
     * Set jeuGagnant
     *
     * @param string $jeuGagnant
     *
     * @return Jeux
     */
    public function setJeuGagnant($jeuGagnant)
    {
        $this->jeuGagnant = $jeuGagnant;

        return $this;
    }

    /**
     * Get jeuGagnant
     *
     * @return string
     */
    public function getJeuGagnant()
    {
        return $this->jeuGagnant;
    }

    /**
     * Set jeuPerdant
     *
     * @param string $jeuPerdant
     *
     * @return Jeux
     */
    public function setJeuPerdant($jeuPerdant)
    {
        $this->jeuPerdant = $jeuPerdant;

        return $this;
    }

    /**
     * Get jeuPerdant
     *
     * @return string
     */
    public function getJeuPerdant()
    {
        return $this->jeuPerdant;
    }

    /**
     * Set jeuDate
     *
     * @param \DateTime $jeuDate
     *
     * @return Jeux
     */
    public function setJeuDate($jeuDate)
    {
        $this->jeuDate = $jeuDate;

        return $this;
    }

    /**
     * Get jeuDate
     *
     * @return \DateTime
     */
    public function getJeuDate()
    {
        return $this->jeuDate;
    }
}

