<?php

namespace Vep\ReservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Production
 *
 * @ORM\Table(name="vep_production")
 * @ORM\Entity(repositoryClass="Vep\ReservationBundle\Entity\ProductionRepository")
 * @ORM\HasLifecycleCallbacks
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
     * @Assert\NotBlank(message="Veuillez indiquer un titre")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank(message="Veuillez indiquer un contenu")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="poster", type="string", length=255)
     */
    private $poster;
    
    /**
     * @var updated
     * 
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;
    
    
    /**
     * @ORM\OneToMany(targetEntity="Vep\ReservationBundle\Entity\Session", mappedBy="production", cascade={"persist", "merge"})
     */
    private $sessions;
    
    private $removedSessions;
    
    /**
     * @Assert\File(maxSize="10M",
     *              mimeTypes = {"image/png", "image/jpeg", "image/gif"},
     *              mimeTypesMessage = "Choisissez une image valide")
     */
    public $file;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sessions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->removedSessions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set update
     *
     * @param Datetime $update
     * @return Production
     */
    public function setUpdated(\Datetime $updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return Datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add sessions
     *
     * @param \Vep\ReservationBundle\Entity\Session $session
     * @return Production
     */
    public function addSession(\Vep\ReservationBundle\Entity\Session $session)
    {
        $this->sessions[] = $session;
        $session->setProduction($this);

        return $this;
    }

    /**
     * Remove session
     *
     * @param \Vep\ReservationBundle\Entity\Session $session
     */
    public function removeSession(\Vep\ReservationBundle\Entity\Session $session)
    {
        $this->removedSessions[] = $session;
        $this->sessions->removeElement($session);
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
    
    public function getRemovedSessions() {
        return $this->removedSessions;
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
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            $this->poster = sha1(uniqid(mt_rand(), true)) . '.' . $this->file->guessExtension();
        } else {
            $this->poster = 'default.png';
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }
        $this->file->move($this->getUploadRootDir(), $this->poster);
        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }
    
    public function getAbsolutePath()
    {
        return null === $this->poster ? null : $this->getUploadRootDir().'/'.$this->poster;
    }

    public function getWebPath()
    {
        return null === $this->poster ? null : $this->getUploadDir().'/'.$this->poster;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'bundles/reservation/img/posters';
    }
}
