<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chats
 *
 * @ORM\Table(name="chats")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChatsRepository")
 */
class Chats
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
     * @ORM\Column(name="chat_message", type="string", length=255)
     */
    private $chatMessage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="chat_message_heure", type="datetime")
     */
    private $chatMessageHeure;


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
     * Set chatMessage
     *
     * @param string $chatMessage
     *
     * @return Chats
     */
    public function setChatMessage($chatMessage)
    {
        $this->chatMessage = $chatMessage;

        return $this;
    }

    /**
     * Get chatMessage
     *
     * @return string
     */
    public function getChatMessage()
    {
        return $this->chatMessage;
    }

    /**
     * Set chatMessageHeure
     *
     * @param \DateTime $chatMessageHeure
     *
     * @return Chats
     */
    public function setChatMessageHeure($chatMessageHeure)
    {
        $this->chatMessageHeure = $chatMessageHeure;

        return $this;
    }

    /**
     * Get chatMessageHeure
     *
     * @return \DateTime
     */
    public function getChatMessageHeure()
    {
        return $this->chatMessageHeure;
    }
}

