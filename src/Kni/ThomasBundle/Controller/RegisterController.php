<?php

namespace Kni\ThomasBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Kni\ThomasBundle\Form\UserType;
use Kni\ThomasBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends Controller
{
    /**
     * @Route("/register")
     */
    public function indexAction()
    {
        $user = new User();
        
        $form = $this->createForm(new UserType(), $user);
        
        return $this->render('KniThomasBundle:Register:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/newUser", name="new_user")
     */
    public function newAction(Request $request){
        
    }
    
}
