<?php

namespace Efrei\DoorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Log
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Efrei\DoorBundle\Entity\LogRepository")
 */
class Log
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
		
	/**
	* @ORM\ManyToOne(targetEntity="Efrei\DoorBundle\Entity\Door")
	* @ORM\JoinColumn(nullable=false)
	*/
	private $door;
	
	/**
	* @ORM\ManyToOne(targetEntity="Efrei\DoorBundle\Entity\Card")
	* @ORM\JoinColumn(nullable=false)
	*/
	private $card;
	
	
	/**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
	private $statut;
	
	/**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
	private $date;
	
	public function __construct()
	{
		//$this->date = \DateTime();
	}
	
    /**
     * Set statut
     *
     * @param integer $statut
     * @return Log
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return integer 
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Log
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set door
     *
     * @param \Efrei\DoorBundle\Entity\Door $door
     * @return Log
     */
    public function setDoor(\Efrei\DoorBundle\Entity\Door $door)
    {
        $this->door = $door;

        return $this;
    }

    /**
     * Get door
     *
     * @return \Efrei\DoorBundle\Entity\Door 
     */
    public function getDoor()
    {
        return $this->door;
    }

    /**
     * Set card
     *
     * @param \Efrei\DoorBundle\Entity\Card $card
     * @return Log
     */
    public function setCard(\Efrei\DoorBundle\Entity\Card $card)
    {
        $this->card = $card;

        return $this;
    }

    /**
     * Get card
     *
     * @return \Efrei\DoorBundle\Entity\Card 
     */
    public function getCard()
    {
        return $this->card;
    }
}
