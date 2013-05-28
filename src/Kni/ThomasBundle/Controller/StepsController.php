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
        
        //pobieramy sobie dla kazdego etapu pytania, które do niego należą
        foreach($entities as $key => $entity){
            $em->getRepository('KniThomasBundle:Question')->findBy(array('step'=>$entity));
        }
        
        
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
                    
                    $em->persist($step);
                    
                    $stepPosition++;
                    $questionPosition=1;
                }elseif(isset($data['questions'][$i])){
                    //mamy pytanie
                    $questionArray = json_decode($data['questions'][$i]);
                    parse_str($questionArray[1], $answers);
                    parse_str($questionArray[2], $answersCorrect);
                    
                    $question = new \Kni\ThomasBundle\Entity\Question();
                    
                    
                    
                    $question->setType(1); //co to miał być ten typ? trzeba to poprawić D:
                    $question->setContent($questionArray[0]); //to jest treść pytania
                    $question->setPosition($questionPosition);
                    $question->setStep($step);

                    $em->persist($question);
                    
                    foreach($answers['answer'] as $answerKey => $oneAnswer){
                        $answer = new \Kni\ThomasBundle\Entity\Answer();
                        $answer->setContent($oneAnswer);
                        
                        if(isset($answersCorrect['correctAnswer'][$answerKey])){
                            $isCorrect = false;
                        }else{
                            $isCorrect = true;
                        }
                        $answer->setIsCorrect($isCorrect);
                        
                        $em->persist($answer);
                        
                        $answer->setQuestion($question);
                    }
                    
                    
                    
                    
                    $questionPosition++;
                }else{
                    break;
                }
                $i++;
            }
            
            $em->flush();
            
//            foreach($data['steps'] as $key => $name){
//                $description = $data['stepsDescriptions'][$key];
//                
//                $step = new Step();
//                $step->setName($name);
//                $step->setDescription($description);
//                $step->setWorkshop($em->getRepository('KniThomasBundle:Workshop')->find($workshopId));
//                $step->setPosition($position);
//                
//                $em->persist($step);
//                $em->flush();
//                
//                $position++;
//            }
            
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
