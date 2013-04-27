<?php

namespace Kni\ThomasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Step
 *
 * @ORM\Table(name="steps")
 * @ORM\Entity
 */
class Step
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     * @ORM\ManyToOne(targetEntity="Workshop", inversedBy="steps")
     */
    protected $workshop;
    
    

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;


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
     * @return Step
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
     * @return Step
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
     * Set position
     *
     * @param integer $position
     * @return Step
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
    }
    

    /**
     * Add files
     *
     * @param \Kni\ThomasBundle\Entity\File $files
     * @return Step
     */
    public function addFile(\Kni\ThomasBundle\Entity\File $files)
    {
        $this->files[] = $files;
    
        return $this;
    }


    /**
     * Set workshop
     *
     * @param \Kni\ThomasBundle\Entity\Workshop $workshop
     * @return Step
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