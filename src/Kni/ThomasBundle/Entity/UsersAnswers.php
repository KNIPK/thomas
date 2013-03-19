<?php

namespace Kni\ThomasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersAnswers
 *
 * @ORM\Table(name="users_answers")
 * @ORM\Entity
 */
class UsersAnswers
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="answers")
     */
    protected $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="usersAnswers")
     */
    protected $question;
    
    /**
     * @ORM\ManyToOne(targetEntity="Answer", inversedBy="usersAnswers")
     */
    protected $answer;

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
     * Set user
     *
     * @param \Kni\ThomasBundle\Entity\User $user
     * @return UsersAnswers
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
     * Set question
     *
     * @param \Kni\ThomasBundle\Entity\Question $question
     * @return UsersAnswers
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
     * Set answer
     *
     * @param \Kni\ThomasBundle\Entity\Answer $answer
     * @return UsersAnswers
     */
    public function setAnswer(\Kni\ThomasBundle\Entity\Answer $answer = null)
    {
        $this->answer = $answer;
    
        return $this;
    }

    /**
     * Get answer
     *
     * @return \Kni\ThomasBundle\Entity\Answer 
     */
    public function getAnswer()
    {
        return $this->answer;
    }
}