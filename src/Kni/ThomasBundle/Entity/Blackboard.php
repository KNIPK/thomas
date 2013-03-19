<?php

namespace Kni\ThomasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Blackboard
 *
 * @ORM\Table(name="blackboards")
 * @ORM\Entity
 */
class Blackboard
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
     * @ORM\OneToOne(targetEntity="Workshop", mappedBy="blackboard")
     */
    private $workshop;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;


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
     * Set content
     *
     * @param string $content
     * @return Blackboard
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
     * Set workshop
     *
     * @param \Kni\ThomasBundle\Entity\Workshop $workshop
     * @return Blackboard
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