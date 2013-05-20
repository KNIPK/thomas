<?php

namespace Kni\ThomasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kni\ThomasBundle\Entity\Step;
use Kni\ThomasBundle\Form\FileType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;

/**
 * File controller.
 *
 * @Route("/profile/steps")
 */
class StepsController extends Controller
{
    
    private $workshopId;
        /**
     * Lists all File entities.
     *
     * @Route("/{workshopId}/", name="profile_steps")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($workshopId)
    {
        $this->workshopId = $workshopId;
        $this->checkAccess();
        
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KniThomasBundle:Step')->findBy(array('workshop'=>$workshopId));

        return array(
            'entities' => $entities,
            'workshopId' => $workshopId,
        );
    }
    
    /**
     * Creates a new Workshop entity.
     *
     * @Route("/{workshopId}/", name="profile_steps_create")
     * @Method("POST")
     * @Template("KniThomasBundle:Steps:index.html.twig")
     */
    public function createAction(Request $request, $workshopId)
    {
        if($request->getMethod()=='POST'){
            $data = $request->request->all();
            
            $em = $this->getDoctrine()->getManager();
            
            $position=1;
            
            print "<pre>";
            $question = json_decode($data['questions'][2]);
            parse_str($question[1], $answers);
            print_r($question);
            print_r($answers);
            print "</pre>";
            die();
            $i=1;
            $stepPosition=1;
            while(true){
                if(isset($data['steps'][$i])){
                    //mamy etap
                    $step = new Step();
                    $step->setName($data['steps'][$i]);
                    $step->setDescription($data['stepsDescriptions'][$i]);
                    $step->setWorkshop($em->getRepository('KniThomasBundle:Workshop')->find($workshopId));
                    $step->setPosition($stepPosition);
                    
                    $stepPosition++;
                    $questionPosition=1;
                }elseif(isset($data['questions'][$i])){
                    //mamy pytanie
                    $question = json_decode($data['questions'][$i]);
                    parse_str($question[1], $answers);
                    parse_str($question[2], $answersCorrect);
                    
                    
                    $questionPosition++;
                }else{
                    break;
                }
            }
            
            foreach($data['steps'] as $key => $name){
                $description = $data['stepsDescriptions'][$key];
                
                $step = new Step();
                $step->setName($name);
                $step->setDescription($description);
                $step->setWorkshop($em->getRepository('KniThomasBundle:Workshop')->find($workshopId));
                $step->setPosition($position);
                
                $em->persist($step);
                $em->flush();
                
                $position++;
            }
            
            print "dodane";
            
        }
//        $entity  = new Workshop();
//        $form = $this->createForm(new WorkshopType($this->get('security.context')->getToken()->getUser()), $entity);
//        $form->bind($request);
//
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            
//            //w pole user dodajemy aktualnie zalogowanego użytkownika
//            $entity->setUser($this->get('security.context')->getToken()->getUser());
//            
//            $em->persist($entity);
//            $em->flush();
//
//            return $this->redirect($this->generateUrl('profile_files', array('workshopId' => $entity->getId())));
//        }

//        return array(
//            'entity' => $entity,
//            'form'   => $form->createView(),
//        );
        return $this->redirect($this->generateUrl('profile_workshop_added', array('workshopId' => $workshopId)));
    }
    
    private function checkAccess(){
        $em = $this->getDoctrine()->getManager();
        $workshop = $em->getRepository('KniThomasBundle:Workshop')->findOneBy(array(
            'id' => $this->workshopId,
            'user' => $this->get('security.context')->getToken()->getUser()
        ));
        if(!$workshop){
            throw new AccessDeniedException();
        }
    }

}
