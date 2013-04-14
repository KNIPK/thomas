<?php

namespace Kni\ThomasBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Kni\ThomasBundle\DependencyInjection\NavigationBar;

class ProfileController extends Controller
{
    function __construct(){
        NavigationBar::add("Profil", "profile");
    }
    
    /**
     * @Route("/profile/index", name="profile")
     */
    public function indexAction()
    {
        return $this->render('KniThomasBundle:Profile:index.html.twig', array());
    }
    
}
