<?php

namespace Kni\ThomasBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Kni\ThomasBundle\Form\Type\UserType;
use Kni\ThomasBundle\Form\Model\Registration;
use Kni\ThomasBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Kni\ThomasBundle\DependencyInjection\NavigationBar;

class RegisterController extends Controller {

    /**
     * @Route("/register", name="register")
     * @Template()
     */
    public function indexAction() {

        NavigationBar::add("Rejestracja", "register");

        $form = $this->createForm(
                new UserType(), new User()
        );

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/newUser", name="new_user")
     * @Template("KniThomasBundle:Register:index.html.twig")
     */
    public function newAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new UserType(), new User());
        $form->bind($this->getRequest());

        if ($form->isValid()) {
            $registration = $form->getData();
            $registration->setIsTemp(false);

            $validator = $this->get('validator');

            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($registration);
            $password = $encoder->encodePassword($registration->getPassword(), $registration->getSalt());
            $registration->setPassword($password);

            $em->persist($registration);
            $em->flush();

            return $this->redirect('user_created');
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/user_created", name="user_created")
     * @Template("KniThomasBundle:Secured:login.html.twig")
     */
    public function userCreatedAction() {
        return array('error'=> '',
            'last_username' => '',
            'message' => 'Rejestracja przebiegła pomyślnie. Teraz możesz się zalogować.');
    }

}
