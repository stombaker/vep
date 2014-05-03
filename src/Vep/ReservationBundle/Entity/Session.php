<?php

namespace Vep\ReservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Session
 *
 * @ORM\Table(name="vep_session")
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
     * @Assert\NotBlank(message="Veuillez indiquer une date")
     * @Assert\DateTime(message="Veuillez indiquer une date valide")
     */
    private $date;
    
    /**
     * @ORM\ManyToOne(targetEntity="Vep\ReservationBundle\Entity\Production", inversedBy="sessions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $production;
    
    /**
     * @ORM\OneToMany(targetEntity="Vep\ReservationBundle\Entity\Reservation", mappedBy="session")
     */
    private $reservations;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \Vep\ReservationBundle\Entity\Reservation $reservation
     * @return Session
     */
    public function addReservation(\Vep\ReservationBundle\Entity\Reservation $reservation)
    {
        $this->reservations[] = $reservation;

        return $this;
    }

    /**
     * Remove reservations
     *
     * @param \Vep\ReservationBundle\Entity\Reservation $reservation
     */
    public function removeReservation(\Vep\ReservationBundle\Entity\Reservation $reservation)
    {
        $this->reservations->removeElement($reservation);
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
