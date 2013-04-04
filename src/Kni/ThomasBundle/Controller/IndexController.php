<?php
namespace Kni\ThomasBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Kni\ThomasBundle\Form\UserType;
use Kni\ThomasBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class IndexController extends Controller
{
    /**
     * @Route("/index")
     * @Template("KniThomasBundle:Default:index.html.twig")
     */
    public function indexAction()
    {
        return array();
    }
}

?>
