<?php

namespace Efrei\DoorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Door
 *
 * @ORM\Table(name="efrei_door")
 * @ORM\Entity(repositoryClass="Efrei\DoorBundle\Entity\DoorRepository")
 */
class Door
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
     * @ORM\Column(name="location", type="string", length=255, unique=true, nullable=false)
     */
    private $location;
	
	/**
     * @var string
     *
     * @ORM\Column(name="batiment", type="string", length=50, unique=false, nullable=false)
     */
    private $batiment;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

	/**
	* @ORM\OneToMany(targetEntity="Efrei\DoorBundle\Entity\Access", mappedBy="door")
	*/
	private $accesses;
	
	
	/**
	* @ORM\OneToMany(targetEntity="Efrei\DoorBundle\Entity\CardGroup", mappedBy="door")
	*/
	private $group;

	
	
	public function __construct()
	{
		$this->accesses = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set location
     *
     * @param string $location
     * @return Door
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Door
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

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Door
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

  

    /**
     * Set batiment
     *
     * @param string $batiment
     * @return Door
     */
    public function setBatiment($batiment)
    {
        $this->batiment = $batiment;

        return $this;
    }

    /**
     * Get batiment
     *
     * @return string 
     */
    public function getBatiment()
    {
        return $this->batiment;
    }

    /**
     * Add accesses
     *
     * @param \Efrei\DoorBundle\Entity\Access $accesses
     * @return Card
     */
    public function addAccess(\Efrei\DoorBundle\Entity\Access $accesses)
    {
        $this->accesses[] = $accesses;
		$accesses->setCard($this);
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
	
	public function __toString() {
		return $this->location.' ['.$this->batiment.']';
	}

    /**
     * Add group
     *
     * @param \Efrei\DoorBundle\Entity\CardGroup $group
     * @return Door
     */
    public function addGroup(\Efrei\DoorBundle\Entity\CardGroup $group)
    {
        $this->group[] = $group;

        return $this;
    }

    /**
     * Remove group
     *
     * @param \Efrei\DoorBundle\Entity\CardGroup $group
     */
    public function removeGroup(\Efrei\DoorBundle\Entity\CardGroup $group)
    {
        $this->group->removeElement($group);
    }

    /**
     * Get group
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroup()
    {
        return $this->group;
    }
}
