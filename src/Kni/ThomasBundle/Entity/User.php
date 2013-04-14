<?php

namespace Kni\ThomasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class User implements UserInterface, \Serializable
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
     * @ORM\ManyToOne(targetEntity="Language", inversedBy="users")
     */
    protected $language;
    
    /**
     * @ORM\OneToMany(targetEntity="Course", mappedBy="user")
     */
    protected $courses;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=20, unique=true)
     * @Assert\Length(
     *      min = "3",
     *      max = "20",
     *      minMessage = "Login musi mieć minimum 3 znaki",
     *      maxMessage = "Login może mieć maksymalnie 20 znaków"
     * )
     */
    private $username;
    
    /**
     * @ORM\Column(type="string", length=32)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=40)
     * @Assert\Length(
     *      min = "3",
     *      minMessage = "Hasło musi mieć minimum 3 znaki"
     * )
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=45)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     * @Assert\Email(
     *     message = "Wprowadzony e-mail '{{ value }}' nie jest prawidłowym adresem e-mail."
     * )
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_temp", type="boolean")
     */
    private $isTemp;
    
    /**
     * @ORM\OneToMany(targetEntity="UsersAnswers", mappedBy="user")
     */
    protected $answers;
    
    /**
     * @ORM\ManyToMany(targetEntity="Workshop", mappedBy="users")
     */
    private $workshops;
    
    /**
     * @ORM\ManyToMany(targetEntity="Workshop", mappedBy="user")
     */
    private $myWorkshops;


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
     * Set login
     *
     * @param string $login
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;
    
        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
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
     * Set surname
     *
     * @param string $surname
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    
        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isTemp
     *
     * @param boolean $isTemp
     * @return User
     */
    public function setIsTemp($isTemp)
    {
        $this->isTemp = $isTemp;
    
        return $this;
    }

    /**
     * Get isTemp
     *
     * @return boolean 
     */
    public function getIsTemp()
    {
        return $this->isTemp;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->courses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->answers = new \Doctrine\Common\Collections\ArrayCollection();
        
        $this->salt = md5(uniqid(null, true));
    }
    
    /**
     * Set language
     *
     * @param \Kni\ThomasBundle\Entity\Language $language
     * @return User
     */
    public function setLanguage(\Kni\ThomasBundle\Entity\Language $language = null)
    {
        $this->language = $language;
    
        return $this;
    }

    /**
     * Get language
     *
     * @return \Kni\ThomasBundle\Entity\Language 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Add courses
     *
     * @param \Kni\ThomasBundle\Entity\Course $courses
     * @return User
     */
    public function addCourse(\Kni\ThomasBundle\Entity\Course $courses)
    {
        $this->courses[] = $courses;
    
        return $this;
    }

    /**
     * Remove courses
     *
     * @param \Kni\ThomasBundle\Entity\Course $courses
     */
    public function removeCourse(\Kni\ThomasBundle\Entity\Course $courses)
    {
        $this->courses->removeElement($courses);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Add answers
     *
     * @param \Kni\ThomasBundle\Entity\UsersAnswers $answers
     * @return User
     */
    public function addAnswer(\Kni\ThomasBundle\Entity\UsersAnswers $answers)
    {
        $this->answers[] = $answers;
    
        return $this;
    }

    /**
     * Remove answers
     *
     * @param \Kni\ThomasBundle\Entity\UsersAnswers $answers
     */
    public function removeAnswer(\Kni\ThomasBundle\Entity\UsersAnswers $answers)
    {
        $this->answers->removeElement($answers);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    public function eraseCredentials() {
        
    }

    public function getRoles() {
        return array('ROLE_USER');
    }

    public function getSalt() {
        
    }

    public function getUsername() {
        
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Add workshops
     *
     * @param \Kni\ThomasBundle\Entity\Workshop $workshops
     * @return User
     */
    public function addWorkshop(\Kni\ThomasBundle\Entity\Workshop $workshops)
    {
        $this->workshops[] = $workshops;
    
        return $this;
    }

    /**
     * Remove workshops
     *
     * @param \Kni\ThomasBundle\Entity\Workshop $workshops
     */
    public function removeWorkshop(\Kni\ThomasBundle\Entity\Workshop $workshops)
    {
        $this->workshops->removeElement($workshops);
    }

    /**
     * Get workshops
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWorkshops()
    {
        return $this->workshops;
    }

    /**
    * @see \Serializable::serialize()
    */
    public function serialize() {
        return serialize(array(
            $this->id,
        ));
    }

    /**
    * @see \Serializable::unserialize()
    */
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }

    /**
     * Add myWorkshops
     *
     * @param \Kni\ThomasBundle\Entity\Workshop $myWorkshops
     * @return User
     */
    public function addMyWorkshop(\Kni\ThomasBundle\Entity\Workshop $myWorkshops)
    {
        $this->myWorkshops[] = $myWorkshops;
    
        return $this;
    }

    /**
     * Remove myWorkshops
     *
     * @param \Kni\ThomasBundle\Entity\Workshop $myWorkshops
     */
    public function removeMyWorkshop(\Kni\ThomasBundle\Entity\Workshop $myWorkshops)
    {
        $this->myWorkshops->removeElement($myWorkshops);
    }

    /**
     * Get myWorkshops
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMyWorkshops()
    {
        return $this->myWorkshops;
    }
}