<?php

namespace Kni\ThomasBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Kni\ThomasBundle\DependencyInjection\NavigationBar;


class NavigationBarController extends Controller
{
    /**
     * @Route("/navigationBar", name="navigation_bar")
     * @Template("KniThomasBundle:NavigationBar:index.html.twig")
     */
    public function indexAction()
    {
        return array('navigationLinks' => NavigationBar::get());
    }
    
    
}
