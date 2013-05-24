<?php

namespace Kni\ThomasBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Kni\ThomasBundle\DependencyInjection\NavigationBar;


/**
 *Profile controller.
 *
 * @Route("/profile")
 */
class ProfileController extends Controller
{
    function __construct(){
        NavigationBar::add("Profil", "profile");
    }
    
    /**
     * @Route("/index", name="profile")
     */
    public function indexAction()
    {
        return $this->render('KniThomasBundle:Profile:index.html.twig', array());
    }
    
    /**
     * Finds and displays a Profile entity.
     *
     * @Route("/show", name="profile_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $entity = $em->getRepository('KniThomasBundle:User')->find($user->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return array(
            'entity'      => $entity
        );
    }
    
    
}
