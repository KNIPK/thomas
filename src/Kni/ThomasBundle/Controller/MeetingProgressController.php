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
    
    private $workshop;
    
    /**
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
    
    /**
     * Lists all Workshop entities.
     *
     * @Route("/stepNumber/{workshopId}", name="meeting_load_step_number")
     * @Method("GET")
     * @Template()
     */
    public function loadStepNumberAction($workshopId){
        $em = $this->getDoctrine()->getManager();
        $workshopProgress = $em->getRepository('KniThomasBundle:WorkshopProgress')->findOneBy(array(
            'user' => NULL,
            'workshop' => $workshopId
        ));
        
        if($workshopProgress){
            $stepNumber = $workshopProgress->getPosition();
        }
        else{
            $stepNumber=0;
        }
        
        return $this->render('KniThomasBundle:MeetingProgress:stepNumber.html.twig', 
                array('stepNumber' => $stepNumber)
                );
        
    }
    
    /**
     *
     * @Route("/loadUsers/{workshopId}", name="meeting_load_users")
     * @Method("GET")
     * @Template()
     */
    public function loadUsersAction($workshopId){
        $repository = $this->getDoctrine()
                ->getRepository('KniThomasBundle:User');
        
        $query = $repository->createQueryBuilder('u')
                ->join('u.workshops', 'w')
                ->leftjoin('u.workshopsProgress', 'wp')
                ->where('w.id = :workshopId')
                ->setParameter('workshopId', $workshopId)
                ->getQuery();

        $users = $query->getResult();
        
        $progress = array();
        foreach($users as $user){
            $wp = $user->getWorkshopsProgress();
            if(count($wp)){
                $progress[$user->getId()] = $wp[0]->getPosition();
            }else{
                $progress[$user->getId()] = 0;
            }
        }
        
        return array(
            'users' => $users,
            'progress' => $progress
        );
    }
    
    /**
     *
     * @Route("/goToStep/{workshopId}/{position}", name="go_to_step")
     * @Method("GET")
     * @Template("KniThomasBundle:MeetingProgress:blank.html.twig")
     */
    public function goToStepAction($workshopId, $position){
        $em = $this->getDoctrine()->getManager();
        $this->workshop = $em->getRepository('KniThomasBundle:Workshop')->find($workshopId);
        
        if($this->checkAdminMode()){
            
            $workshopProgress = $em->getRepository('KniThomasBundle:WorkshopProgress')->findOneBy(array(
                'workshop' => $this->workshop,
                'user' => null
            ));
            
            if(!$workshopProgress){
                $workshopProgress = new \Kni\ThomasBundle\Entity\WorkshopProgress;
                $workshopProgress->setWorkshop($this->workshop);
            }
            
            $workshopProgress->setPosition($position);
            $workshopProgress->setTime(new \DateTime());
            
            $em->persist($workshopProgress);
            $em->flush();
        }
        
    }
    
    
    /**
     * Metoda zwraca czy strona jest otwarta przez osobe, która zarządza tymi warsztatami
     */
    private function checkAdminMode(){
        return ($this->get('security.context')->getToken()->getUser() == $this->workshop->getUser());
    }
    
}
