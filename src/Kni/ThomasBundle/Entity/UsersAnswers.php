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
}
