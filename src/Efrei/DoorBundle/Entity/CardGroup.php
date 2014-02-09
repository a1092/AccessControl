<?php

namespace Efrei\DoorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CardGroup
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Efrei\DoorBundle\Entity\CardGroupRepository")
 */
class CardGroup
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
	* @var string
	*
	* @ORM\Column(name="name", type="string", length=255, unique=true, nullable=false)
	*/
    private $name;
	
	/**
	* @var string
	*
	* @ORM\Column(name="description", type="string", length=255, nullable=true)
	*/
    private $description;
	
	/**
	* @ORM\ManyToMany(targetEntity="Efrei\UserBundle\Entity\User", cascade={"persist"})
	*/
	private $users;

	
	/**
	* @ORM\ManyToOne(targetEntity="Efrei\DoorBundle\Entity\Door")
	* @ORM\JoinColumn(nullable=false)
	*/
	private $door;

	
	/**
	* @ORM\OneToMany(targetEntity="Efrei\DoorBundle\Entity\Access", cascade={"persist"}, mappedBy="group")
	*/
	private $accesses;
	
	

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
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cards = new \Doctrine\Common\Collections\ArrayCollection();
        $this->accesses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add users
     *
     * @param \Efrei\UserBundle\Entity\User $users
     * @return CardGroup
     */
    public function addUser(\Efrei\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Efrei\UserBundle\Entity\User $users
     */
    public function removeUser(\Efrei\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
	
	 public function allowManage(\Efrei\UserBundle\Entity\User $user)
    {
		if($this->users->contains($user))
			return true;
		else
			return false;
		
	}
	

    /**
     * Add cards
     *
     * @param \Efrei\DoorBundle\Entity\Card $cards
     * @return CardGroup
     */
    public function addCard(\Efrei\DoorBundle\Entity\Card $cards)
    {
        $this->cards[] = $cards;

        return $this;
    }

    /**
     * Remove cards
     *
     * @param \Efrei\DoorBundle\Entity\Card $cards
     */
    public function removeCard(\Efrei\DoorBundle\Entity\Card $cards)
    {
        $this->cards->removeElement($cards);
    }

    /**
     * Get cards
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCards()
    {
        return $this->cards;
    }


    /**
     * Add accesses
     *
     * @param \Efrei\DoorBundle\Entity\Access $accesses
     * @return CardGroup
     */
    public function addAccess(\Efrei\DoorBundle\Entity\Access $accesses)
    {
		$accesses->setDoor($this->door);
		
        $this->accesses[] = $accesses;

        return $this;
    }

    /**
     * Remove accesses
     *
     * @param \Efrei\DoorBundle\Entity\Access $accesses
     */
    public function removeAccess(\Efrei\DoorBundle\Entity\Access $accesses)
    {
        $this->accesses->removeElement($accesses);
    }

    /**
     * Get accesses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAccesses()
    {
        return $this->accesses;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return CardGroup
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return CardGroup
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
	
	public function __toString() {
		return $this->name;
	}

    /**
     * Set door
     *
     * @param \Efrei\DoorBundle\Entity\Door $door
     * @return CardGroup
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
}
