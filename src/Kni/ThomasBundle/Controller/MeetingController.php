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
 * @Route("meeting")
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
     * @Route("/join/{workshopId}", name="join_to_workshop")
     * @Template()
     */
    public function joinAction($workshopId) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('KniThomasBundle:Workshop')->find($workshopId);

        $users = $entity->getUsers();

        $user = $this->get('security.context')->getToken()->getUser();

        if (in_array($user, $users->toArray())) {//czy user jest już dałączył do kursu
            return $this->redirect($this->generateUrl('meeting_index', array('id' => $workshopId)));
        } else {
            return array(
                'entity' => $entity,
                'error' => ''
            );
        }
    }

    /**
     * Podsumowanie dołączenia do  warsztatów
     *
     * @Route("/joined", name="joined_to_workshop")
     * @Method("POST")
     * @Template()
     */
    public function joinedAction(Request $request) {
         return array(
                //todo napisac sprawdzanie poprawnosci hasla, ewentualnie redirect do index
                'error' => 'zle haslo'
            );
    }

}

