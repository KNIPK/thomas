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
     * Send invitations.
     *
     * @Route("/send/", name="send_invitations")
     * @Method("POST")
     * @Template("KniThomasBundle:Workshop:added.html.twig")
     */
    public function sendMailsAction(Request $request) {

        $data = $request->request->all();
        $mails = explode(',', $data['mails'], 100);
        $text = $data['text'];
        foreach ($mails as $mail) {
            $message = \Swift_Message::newInstance()->setSubject('Zaproszenie do warsztatu: '.$data['name'])->setFrom('thomas@kalinowski.net.pl')
                            ->setTo(trim($mail))->setBody($data['text']);
            $this->get('mailer')->send($message);
        }

        return array();
    }

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