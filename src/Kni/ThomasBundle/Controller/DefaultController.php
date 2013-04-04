<?php

namespace Kni\ThomasBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    /**
     * @Route("/profile/index")
     */
    public function indexAction()
    {
        return $this->render('KniThomasBundle:Default:index.html.twig', array());
    }
    
    /**
     * @Route("create")
     */
    public function createAction()
    {
        $factory = $this->get('security.encoder_factory');
        $user = new User();

        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword('pass', $user->getSalt());
        $user->setPassword($password);
        $user->setUsername("user");
        
        return $this->render('KniThomasBundle:Default:page.html.twig', array());
    }
    
    /**
     * @Route("profile/page", name="page")
     * @Template()
     */
    public function pageAction()
    {
        return array();
//        return null;
    }
}
