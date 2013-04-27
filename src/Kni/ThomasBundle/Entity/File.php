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
     * @ORM\Column(name="filename", type="string", length=128, unique=true)
     */
    private $filename;
    
    /**
     * @ORM\ManyToOne(targetEntity="Workshop", inversedBy="files")
     */
    protected $workshop;

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
     * Set filename
     *
     * @param string $filename
     * @return File
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    
        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set workshop
     *
     * @param \Kni\ThomasBundle\Entity\Workshop $workshop
     * @return File
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