<?php

namespace Kni\ThomasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Kni\ThomasBundle\DependencyInjection\NavigationBar;
use Kni\ThomasBundle\Form\Type\UserEditType;
use Kni\ThomasBundle\Form\Type\UserChangePassType;

/**
 * Profile controller.
 *
 * @Route("/profile")
 */
class ProfileController extends Controller {

    function __construct() {
        NavigationBar::add("Profil", "profile");
    }

    /**
     * @Route("/index", name="profile")
     */
    public function indexAction() {
        return $this->render('KniThomasBundle:Profile:index.html.twig', array());
    }

    /**
     * Finds and displays a Profile entity.
     *
     * @Route("/show", name="profile_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction() {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $entity = $em->getRepository('KniThomasBundle:User')->find($user->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }


        return array(
            'entity' => $entity
        );
    }

    /**
     * Displays a form to edit an existing profile entity.
     *
     * @Route("/edit", name="profile_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction() {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $entity = $em->getRepository('KniThomasBundle:User')->find($user->getId());
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Workshop entity.');
        }


        $editForm = $this->createForm(new UserEditType(), $entity);
        $passForm = $this->createForm(new UserChangePassType(), $entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'pass_form' => $passForm->createView(),
            'info' => ''
        );
    }
    
    
     /**
     * Edits users name and surname.
     *
     * @Route("/changeName", name="user_name_update")
     * @Method("PUT")
     * @Template("KniThomasBundle:Profile:edit.html.twig")
     */
    public function updateAction(Request $request)
    {
        $id = $this->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('KniThomasBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Workshop entity.');
        }

        
        $editForm = $this->createForm(new UserEditType(), $entity);
        $passForm = $this->createForm(new UserChangePassType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $entity->setName('spytacMateusza');
            $entity->setSurname('spytacMateusza');
            $em->persist($entity);
            $em->flush();

                    return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'pass_form' => $passForm->createView(),
            'info' => 'Zmiana dokonana poprawnie');
        } else{
           return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'pass_form' => $passForm->createView(),
            'info' => 'Nie udało się wprowadzić zmian');
        }


    }
    
    

}
