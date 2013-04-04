<?php
namespace Kni\ThomasBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     * @Template("::index.html.twing")
     */
    
    public function indexAction()
    {
        $user = new User();
        
        $form = $this->createForm(new UserType(), $user);
        
        return array();
    }
}

?>
