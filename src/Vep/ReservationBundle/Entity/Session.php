<?php

namespace Vep\ReservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Session
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Vep\ReservationBundle\Entity\SessionRepository")
 */
class Session
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    /**
     * @ORM\ManyToOne(targetEntity="Vep\ReservationBundle\Entity\Production", inversedBy="sessions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $production;
    
    /**
     * @ORM\OneToMany(targetEntity="Vep\ReservationBundle\Entity\Reservations", mappedBy="session")
     */
    private $reservations;


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
     * Set date
     *
     * @param \DateTime $date
     * @return Session
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
     * Constructor
     */
    public function __construct()
    {
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set production
     *
     * @param \Vep\ReservationBundle\Entity\Production $production
     * @return Session
     */
    public function setProduction(\Vep\ReservationBundle\Entity\Production $production)
    {
        $this->production = $production;

        return $this;
    }

    /**
     * Get production
     *
     * @return \Vep\ReservationBundle\Entity\Production 
     */
    public function getProduction()
    {
        return $this->production;
    }

    /**
     * Add reservations
     *
     * @param \Vep\ReservationBundle\Entity\Reservations $reservations
     * @return Session
     */
    public function addReservation(\Vep\ReservationBundle\Entity\Reservations $reservations)
    {
        $this->reservations[] = $reservations;

        return $this;
    }

    /**
     * Remove reservations
     *
     * @param \Vep\ReservationBundle\Entity\Reservations $reservations
     */
    public function removeReservation(\Vep\ReservationBundle\Entity\Reservations $reservations)
    {
        $this->reservations->removeElement($reservations);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReservations()
    {
        return $this->reservations;
    }
}
