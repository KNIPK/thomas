<?php

namespace Kni\ThomasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kni\ThomasBundle\Entity\Workshop;
use Kni\ThomasBundle\Form\WorkshopType;
use Kni\ThomasBundle\DependencyInjection\NavigationBar;

/**
 * Workshop controller.
 *
 * @Route("/meeting")
 */
class MeetingController extends Controller {

    /**
     * Lists all Workshop entities.
     *
     * @Route("/{id}", name="meeting_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {
        NavigationBar::add("Wszystkie warsztaty", "profile_workshop");
        $em = $this->getDoctrine()->getManager();

        $request->get('query');
        if ($request->get('query') == "") {
            $entities = $em->getRepository('KniThomasBundle:Workshop')->findAll();
        } else {
            $entities = $em->getRepository('KniThomasBundle:Workshop')->findBy(array('name' => $request->get('query')));
        }

        return array(
            'entities' => $entities,
        );
    }


    /**
     * Dołącz do  warsztatów
     *
     * @Route("join/{workshopId}", name="join_to_workshop")
     * @Template()
     */
    public function joinAction($workshopId) {
        return array(
            'workshopId' => $workshopId,
        );
    }
    
    /**
     * Podsumowanie dołączenia do  warsztatów
     *
     * @Route("joined/{workshopId}", name="joined_to_workshop")
     * @Template()
     */
    public function joinedAction($workshopId) {
        return array(
            'workshopId' => $workshopId,
        );
    }

}
