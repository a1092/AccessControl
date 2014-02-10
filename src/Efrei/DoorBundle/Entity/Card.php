<?php

namespace Efrei\DoorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Card
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Efrei\DoorBundle\Entity\CardRepository")
 */
class Card
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
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var integer
     *
     * @ORM\Column(name="cardcode", type="integer")
     */
    private $cardcode;
	
	/**
     * @var string
     *
     * @ORM\Column(name="studentid", type="string", length=100, nullable=true)
     */
    private $studentid;

	/**
     * @var string
     *
     * @ORM\Column(name="promotion", type="string", length=100, nullable=true)
     */
    private $promotion;

    /**
     * @var integer
     *
     * @ORM\Column(name="facilitycode", type="integer")
     */
    private $facilitycode;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;
	
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=150, nullable=true)
     */
    private $type;

	/**
	* @ORM\OneToMany(targetEntity="Efrei\DoorBundle\Entity\Access", mappedBy="card")
	*/
	private $accesses;
	
	/**
	* @ORM\OneToMany(targetEntity="Efrei\DoorBundle\Entity\Log", mappedBy="card")
	*/
	private $logs;

	
	
	public function __construct()
	{
		$this->accesses = new \Doctrine\Common\Collections\ArrayCollection();
		$this->logs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set firstname
     *
     * @param string $firstname
     * @return Card
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Card
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set cardcode
     *
     * @param integer $cardcode
     * @return Card
     */
    public function setCardcode($cardcode)
    {
        $this->cardcode = $cardcode;

        return $this;
    }

    /**
     * Get cardcode
     *
     * @return integer 
     */
    public function getCardcode()
    {
        return $this->cardcode;
    }

    /**
     * Set facilitycode
     *
     * @param integer $facilitycode
     * @return Card
     */
    public function setFacilitycode($facilitycode)
    {
        $this->facilitycode = $facilitycode;

        return $this;
    }

    /**
     * Get facilitycode
     *
     * @return integer 
     */
    public function getFacilitycode()
    {
        return $this->facilitycode;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Card
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
		return $this->lastname.' '.$this->firstname.' ('.$this->cardcode.')';
	}

    /**
     * Set studentid
     *
     * @param string $studentid
     * @return Card
     */
    public function setStudentid($studentid)
    {
        $this->studentid = $studentid;

        return $this;
    }

    /**
     * Get studentid
     *
     * @return string 
     */
    public function getStudentid()
    {
        return $this->studentid;
    }

    /**
     * Set promotion
     *
     * @param string $promotion
     * @return Card
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;

        return $this;
    }

    /**
     * Get promotion
     *
     * @return string 
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Card
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add logs
     *
     * @param \Efrei\DoorBundle\Entity\Log $logs
     * @return Card
     */
    public function addLog(\Efrei\DoorBundle\Entity\Log $logs)
    {
        $this->logs[] = $logs;

        return $this;
    }

    /**
     * Remove logs
     *
     * @param \Efrei\DoorBundle\Entity\Log $logs
     */
    public function removeLog(\Efrei\DoorBundle\Entity\Log $logs)
    {
        $this->logs->removeElement($logs);
    }

    /**
     * Get logs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLogs()
    {
        return $this->logs;
    }
}
