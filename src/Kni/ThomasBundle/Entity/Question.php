<?php

namespace Kni\ThomasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="questions")
 * @ORM\Entity
 */
class Question
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
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="questions")
     */

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=45)
     */
    private $content;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;
    
    /**
     * @ORM\OneToMany(targetEntity="UsersAnswers", mappedBy="question")
     */
    protected $usersAnswers;


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
     * Set type
     *
     * @param integer $type
     * @return Question
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Question
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
     * Set position
     *
     * @param integer $position
     * @return Question
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
        $this->usersAnswers = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add usersAnswers
     *
     * @param \Kni\ThomasBundle\Entity\UsersAnswers $usersAnswers
     * @return Question
     */
    public function addUsersAnswer(\Kni\ThomasBundle\Entity\UsersAnswers $usersAnswers)
    {
        $this->usersAnswers[] = $usersAnswers;
    
        return $this;
    }

    /**
     * Remove usersAnswers
     *
     * @param \Kni\ThomasBundle\Entity\UsersAnswers $usersAnswers
     */
    public function removeUsersAnswer(\Kni\ThomasBundle\Entity\UsersAnswers $usersAnswers)
    {
        $this->usersAnswers->removeElement($usersAnswers);
    }

    /**
     * Get usersAnswers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsersAnswers()
    {
        return $this->usersAnswers;
    }
}