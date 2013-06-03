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
 * @Route("/meetingLoad")
 */
class MeetingProgressController extends Controller {
    
    
    /**
     * Lists all Workshop entities.
     *
     * @Route("/step/{workshopId}/{position}", name="meeting_load_step")
     * @Method("GET")
     * @Template()
     */
    public function loadStepAction($workshopId, $position) {
        
        $em = $this->getDoctrine()->getManager();
        $step = $em->getRepository('KniThomasBundle:Step')->findOneBy(array(
            'position' => $position,
            'workshop' => $workshopId
        ));
        
        if($step){
            //przetwarzamy etap
            return $this->render('KniThomasBundle:MeetingProgress:step.html.twig', array(
                'step' => $step
            ));
        }else{
            //nie ma etapu, czyli jest pytanie
            print "question";
        }
        

        return array(
        );
    }
}
