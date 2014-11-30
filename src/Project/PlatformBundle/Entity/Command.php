<?php

namespace Project\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Command
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Project\PlatformBundle\Entity\CommandRepository")
 */
class Command
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Project\UserBundle\entity\User" ,cascade={"remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Project\PlatformBundle\entity\Contact" ,cascade={"remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="command_number", type="string", length=255)
     */
    private $commandNumber;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="commande_date", type="datetime")
     */
    private $commandDate;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="send_date", type="datetime", nullable=true)
     */
    private $sendDate;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="shipping_date", type="datetime", nullable=true)
     */
    private $shippingDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="real_shipping_date", type="datetime", nullable=true)
     */
    private $realShipping;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;


    public function __construct()
    {
        $this->setStatus("New");
        $this->setCommandNumber();
        $this->setCommandDate(new \DateTime);
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set commandNumber
     *
     * @return Command
     */
    public function setCommandNumber()
    {
        $commandNumber=uniqid();

        $this->commandNumber = $commandNumber;

        return $this;
    }

    /**
     * Get commandNumber
     *
     * @return string 
     */
    public function getCommandNumber()
    {
        return $this->commandNumber;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Command
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param mixed $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return \DateTime
     */
    public function getCommandDate()
    {
        return $this->commandDate;
    }

    /**
     * @param \DateTime $commandDate
     */
    public function setCommandDate($commandDate)
    {
        $this->commandDate = $commandDate;
    }

    /**
     * @return \DateTime
     */
    public function getSendDate()
    {
        return $this->sendDate;
    }

    /**
     * @param \DateTime $sendDate
     */
    public function setSendDate($sendDate)
    {
        $this->sendDate = $sendDate;
    }

    /**
     * @return \DateTime
     */
    public function getRealShipping()
    {
        return $this->realShipping;
    }

    /**
     * @param \DateTime $realShipping
     */
    public function setRealShipping($realShipping)
    {
        $this->realShipping = $realShipping;
    }

    /**
     * @return \DateTime
     */
    public function getShippingdate()
    {
        return $this->shippingDate;
    }

    /**
     * @param \DateTime $shippingDate
     */
    public function setShippingdate($shippingDate)
    {
        $this->shippingDate = $shippingDate;
    }
}
