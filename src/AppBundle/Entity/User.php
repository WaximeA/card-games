<?php
namespace AppBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Parties", mappedBy="joueur1")
     */
    private $parties_1;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Parties", mappedBy="joueur2")
     */
    private $parties_2;
    private $parties;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->parties_1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parties_2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parties = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getParties()
    {
        $this->parties[] = $this->parties_1;
        $this->parties[] = $this->parties_2;
        return $this->parties;
    }



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
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * Add parties1
     *
     * @param \AppBundle\Entity\Parties $parties1
     *
     * @return User
     */
    public function addParties1(\AppBundle\Entity\Parties $parties1)
    {
        $this->parties_1[] = $parties1;
        return $this;
    }

    /**
     * Remove parties1
     *
     * @param \AppBundle\Entity\Parties $parties1
     */
    public function removeParties1(\AppBundle\Entity\Parties $parties1)
    {
        $this->parties_1->removeElement($parties1);
    }

    /**
     * Get parties1
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParties1()
    {
        return $this->parties_1;
    }

    /**
     * Add parties2
     *
     * @param \AppBundle\Entity\Parties $parties2
     *
     * @return User
     */
    public function addParties2(\AppBundle\Entity\Parties $parties2)
    {
        $this->parties_2[] = $parties2;
        return $this;
    }

    /**
     * Remove parties2
     *
     * @param \AppBundle\Entity\Parties $parties2
     */
    public function removeParties2(\AppBundle\Entity\Parties $parties2)
    {
        $this->parties_2->removeElement($parties2);
    }

    /**
     * Get parties2
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParties2()
    {
        return $this->parties_2;
    }
}


