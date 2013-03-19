<?php

namespace Kni\ThomasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * File
 *
 * @ORM\Table(name="files")
 * @ORM\Entity
 */
class File
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
     * @ORM\Column(name="name", type="string", length=45)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="src", type="string", length=145)
     */
    private $src;
    
    /**
     * @ORM\ManyToOne(targetEntity="Step", inversedBy="files")
     */
    protected $step;

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
     * Set name
     *
     * @param string $name
     * @return File
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
     * Set src
     *
     * @param string $src
     * @return File
     */
    public function setSrc($src)
    {
        $this->src = $src;
    
        return $this;
    }

    /**
     * Get src
     *
     * @return string 
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set step
     *
     * @param \Kni\ThomasBundle\Entity\Step $step
     * @return File
     */
    public function setStep(\Kni\ThomasBundle\Entity\Step $step = null)
    {
        $this->step = $step;
    
        return $this;
    }

    /**
     * Get step
     *
     * @return \Kni\ThomasBundle\Entity\Step 
     */
    public function getStep()
    {
        return $this->step;
    }
}