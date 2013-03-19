<?php

namespace Kni\ThomasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table(name="answers")
 * @ORM\Entity
 */
class Answer
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
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers")
     */
    protected $question;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=200)
     */
    private $content;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_correct", type="boolean")
     */
    private $isCorrect;
    
    /**
     * @ORM\OneToMany(targetEntity="UsersAnswers", mappedBy="answer")
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
     * Set content
     *
     * @param string $content
     * @return Answer
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
     * Set isCorrect
     *
     * @param boolean $isCorrect
     * @return Answer
     */
    public function setIsCorrect($isCorrect)
    {
        $this->isCorrect = $isCorrect;
    
        return $this;
    }

    /**
     * Get isCorrect
     *
     * @return boolean 
     */
    public function getIsCorrect()
    {
        return $this->isCorrect;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usersAnswers = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set question
     *
     * @param \Kni\ThomasBundle\Entity\Question $question
     * @return Answer
     */
    public function setQuestion(\Kni\ThomasBundle\Entity\Question $question = null)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return \Kni\ThomasBundle\Entity\Question 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Add usersAnswers
     *
     * @param \Kni\ThomasBundle\Entity\UsersAnswers $usersAnswers
     * @return Answer
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