<?php
namespace Kni\ThomasBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Kni\ThomasBundle\Entity\User;

class Registration
{
    /**
     * @Assert\Type(type="Kni\ThomasBundle\Entity\User")
     * @Assert\Valid()
     */
    protected $user;

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

}

?>
