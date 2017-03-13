<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cartes
 *
 * @ORM\Table(name="cartes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CartesRepository")
 */
class Cartes
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
     * @ORM\Column(name="carte_famille", type="string", length=255)
     */
    private $carteFamille;

    /**
     * @var string
     *
     * @ORM\Column(name="carte_nom", type="string", length=255)
     */
    private $carteNom;

    /**
     * @var int
     *
     * @ORM\Column(name="carte_valeur", type="integer")
     */
    private $carteValeur;

    /**
     * @var bool
     *
     * @ORM\Column(name="carte_extra", type="boolean")
     */
    private $carteExtra;

    /**
     * @var string
     *
     * @ORM\Column(name="carte_image", type="string", length=255)
     */
    private $carteImage;


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
     * Set carteFamille
     *
     * @param string $carteFamille
     *
     * @return Cartes
     */
    public function setCarteFamille($carteFamille)
    {
        $this->carteFamille = $carteFamille;

        return $this;
    }

    /**
     * Get carteFamille
     *
     * @return string
     */
    public function getCarteFamille()
    {
        return $this->carteFamille;
    }

    /**
     * Set carteNom
     *
     * @param string $carteNom
     *
     * @return Cartes
     */
    public function setCarteNom($carteNom)
    {
        $this->carteNom = $carteNom;

        return $this;
    }

    /**
     * Get carteNom
     *
     * @return string
     */
    public function getCarteNom()
    {
        return $this->carteNom;
    }

    /**
     * Set carteValeur
     *
     * @param integer $carteValeur
     *
     * @return Cartes
     */
    public function setCarteValeur($carteValeur)
    {
        $this->carteValeur = $carteValeur;

        return $this;
    }

    /**
     * Get carteValeur
     *
     * @return int
     */
    public function getCarteValeur()
    {
        return $this->carteValeur;
    }

    /**
     * Set carteExtra
     *
     * @param boolean $carteExtra
     *
     * @return Cartes
     */
    public function setCarteExtra($carteExtra)
    {
        $this->carteExtra = $carteExtra;

        return $this;
    }

    /**
     * Get carteExtra
     *
     * @return bool
     */
    public function getCarteExtra()
    {
        return $this->carteExtra;
    }

    /**
     * Set carteImage
     *
     * @param string $carteImage
     *
     * @return Cartes
     */
    public function setCarteImage($carteImage)
    {
        $this->carteImage = $carteImage;

        return $this;
    }

    /**
     * Get carteImage
     *
     * @return string
     */
    public function getCarteImage()
    {
        return $this->carteImage;
    }
}

