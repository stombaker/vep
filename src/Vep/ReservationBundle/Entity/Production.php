<?php

namespace Vep\ReservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Production
 *
 * @ORM\Table(name="vep_production")
 * @ORM\Entity(repositoryClass="Vep\ReservationBundle\Entity\ProductionRepository")
 */
class Production
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="poster", type="string", length=255)
     */
    private $poster;
    
    /**
     * @ORM\OneToMany(targetEntity="Vep\ReservationBundle\Entity\Session", mappedBy="production")
     */
    private $sessions;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sessions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Production
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Production
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set poster
     *
     * @param string $poster
     * @return Production
     */
    public function setPoster($poster)
    {
        $this->poster = $poster;

        return $this;
    }

    /**
     * Get poster
     *
     * @return string 
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * Add sessions
     *
     * @param \Vep\ReservationBundle\Entity\Session $sessions
     * @return Production
     */
    public function addSession(\Vep\ReservationBundle\Entity\Session $sessions)
    {
        $this->sessions[] = $sessions;

        return $this;
    }

    /**
     * Remove sessions
     *
     * @param \Vep\ReservationBundle\Entity\Session $sessions
     */
    public function removeSession(\Vep\ReservationBundle\Entity\Session $sessions)
    {
        $this->sessions->removeElement($sessions);
    }

    /**
     * Get sessions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSessions()
    {
        return $this->sessions;
    }
    
    public function getSortedSessions() {
        $sessions = $this->getSessions()->toArray();
        usort($sessions, function($s1, $s2){
            return $s1->getDate()->getTimestamp() - $s2->getDate()->getTimestamp();
        });
        return $sessions;
    }
    
    public function getComingSessions() {
        $sessions = $this->getSortedSessions();
        $result = array();
        foreach ($sessions as $session) {
            if ($session->getDate()->getTimestamp() > time()) {
                $result[] = $session;
            }
        }
        return $result;
    }
}
