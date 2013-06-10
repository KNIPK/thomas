<?php

namespace Kni\ThomasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Invitation controller.
 *
 * @Route("profile/workshop/invitation")
 */
class InvitationController extends Controller {

    /**
     * Creates a new Workshop entity.
     *
     * @Route("/{workshopId}/", name="workshop_invitation")
     * @Template()
     */
    public function formAction($workshopId) {
        $em = $this->getDoctrine()->getManager();
        $workshop = $em->getRepository('KniThomasBundle:Workshop')->find($workshopId);
        return array('workshop' => $workshop);
    }

}