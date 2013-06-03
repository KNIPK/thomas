<?php

namespace Kni\ThomasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WorkshopProgress
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class WorkshopProgress
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="workshopsProgress")
     */
    protected $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="Workshop", inversedBy="usersProgress")
     */
    protected $workshop;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime")
     */
    private $time;


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
     * Set time
     *
     * @param \DateTime $time
     * @return WorkshopProgress
     */
    public function setTime($time)
    {
        $this->time = $time;
    
        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set user
     *
     * @param \Kni\ThomasBundle\Entity\User $user
     * @return WorkshopProgress
     */
    public function setUser(\Kni\ThomasBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Kni\ThomasBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set workshop
     *
     * @param \Kni\ThomasBundle\Entity\Workshop $workshop
     * @return WorkshopProgress
     */
    public function setWorkshop(\Kni\ThomasBundle\Entity\Workshop $workshop = null)
    {
        $this->workshop = $workshop;
    
        return $this;
    }

    /**
     * Get workshop
     *
     * @return \Kni\ThomasBundle\Entity\Workshop 
     */
    public function getWorkshop()
    {
        return $this->workshop;
    }
}