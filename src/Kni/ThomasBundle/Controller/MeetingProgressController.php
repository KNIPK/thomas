<?php

namespace Kni\ThomasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kni\ThomasBundle\Entity\Workshop;
use Kni\ThomasBundle\Entity\User;
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
        $this->workshop = $em->getRepository('KniThomasBundle:Workshop')->find($workshopId);
        
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
            $question = $em->getRepository('KniThomasBundle:Question')->findOneBy(array(
                'position' => $position,
                'workshop' => $workshopId
            ));
            
            //pobieramy odpowiedzi dla tego pytania
            $answers = $em->getRepository('KniThomasBundle:Answer')->findBy(array(
                'question' => $question
            ), array(
                'id' => 'asc'
            ));
            
            if($this->checkAdminMode()){
                //pobieramy jeszcze informacje o tym jacy uzytkownicy odpowiedzieli na pytanie
                //oraz sprawdzamy czy ich odpowiedz jest prawidlowa
                $wpRepo = $em->getRepository('KniThomasBundle:WorkshopProgress');
                $usersProgressQuery = $wpRepo->createQueryBuilder('wp')
                        ->leftjoin('wp.user', 'u')
                        ->where('wp.position >= :position')
                        ->andWhere('wp.user != :user')
                        ->andWhere('wp.workshop = :workshop')
                        ->setParameter('position', $question->getPosition())
                        ->setParameter('user', 'null')
                        ->setParameter('workshop', $workshopId);
                
                $usersProgress = $usersProgressQuery->getQuery()->getResult();
                
                
                $usersAnswers = array();
                foreach($usersProgress as $userProgress){
                    $user = $userProgress->getUser();
                    
                    $userAnswers = array();
                    $userAnswers['name'] = $user;
                    //sprawdzamy czy user poprawnie odpowiedział
                    
                    $userAnswer = $em->getRepository('KniThomasBundle:UsersAnswers')->findBy(array(
                        'user' => $user,
                        'question' => $question
                    ));
                    
                    $correct = true;
                    foreach($answers as $answer){
                        if($answer->getIsCorrect()){
                            //jesli odpowiedź poprawna to sprawdzamy czy uzytkownik ja zaznaczyl
                            
                            $correctTmp = false;
                            foreach($userAnswer as $oneAnswer){
                                if($oneAnswer->getAnswer()==$answer) $correctTmp=true;
                            }
                            
                            if(!$correctTmp) $correct=false;
                            
                        }else{
                            //jeśli niepoprawna to sprawdzamy czy przypadkiem jej nie zaznaczył
                            $correctTmp = true;
                            foreach($userAnswer as $oneAnswer){
                                if($oneAnswer->getAnswer()==$answer) $correctTmp=false;
                            }
                            
                            if(!$correctTmp) $correct = false;
                        }
                    }
                    
                    $userAnswers['correct'] = $correct;
                    
                    $usersAnswers[] = $userAnswers;
                }
                
                
                return $this->render('KniThomasBundle:MeetingProgress:question.html.twig', array(
                    'question' => $question,
                    'answers' => $answers,
                    'usersAnswers' => $usersAnswers
                ));
            }else{
                //pobranie pytania dla uzytkownika
                
                //pobieramy jeszcze progress użytkownika, zeby wiedziec czy juz odpowiedział
                $userProgress = $em->getRepository('KniThomasBundle:WorkshopProgress')->findOneBy(
                        array(
                            'user' => $this->get('security.context')->getToken()->getUser(),
                            'workshop' => $workshopId
                        ));
                
                if($userProgress)
                    $userProgress=$userProgress->getPosition();
                else{
                    $userProgress=0;
                }
                
//                print $userProgress->getPosition();
//                die();
                
                return $this->render('KniThomasBundle:MeetingProgress:questionForUser.html.twig', array(
                    'question' => $question,
                    'answers' => $answers,
                    'userProgress' => $userProgress
                ));
            }
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
     *
     * @Route("/saveAnswer/{questionId}/{answers}", name="save_answer")
     * @Method("GET")
     * @Template("KniThomasBundle:MeetingProgress:blank.html.twig")
     */
    public function saveAnswer($questionId, $answers){
        parse_str($answers, $answers);
        
        $em = $this->getDoctrine()->getManager();
        $question = $em->getRepository('KniThomasBundle:Question')->find($questionId);
        
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        foreach ($answers as $id => $correct){
            $answer = new \Kni\ThomasBundle\Entity\UsersAnswers();
            $answer->setQuestion($question);
            $answer->setUser($user);
            $answer->setAnswer($em->getRepository('KniThomasBundle:Answer')->find($id));
            
            $em->persist($answer);
        }
        
        //zapisujemy progress usera
        $workshopProgress = $em->getRepository('KniThomasBundle:WorkshopProgress')->findOneBy(array(
            'user' => $user
        ));
        if(!$workshopProgress) $workshopProgress = new \Kni\ThomasBundle\Entity\WorkshopProgress();
        $workshopProgress->setPosition($question->getPosition());
        $workshopProgress->setUser($user);
        $workshopProgress->setTime(new \DateTime('now'));
        $workshopProgress->setWorkshop($question->getWorkshop());
        $em->persist($workshopProgress);
        
        $em->flush();
    }
    
    
    /**
     * Metoda zwraca czy strona jest otwarta przez osobe, która zarządza tymi warsztatami
     */
    private function checkAdminMode(){
        
        return ($this->get('security.context')->getToken()->getUser() == $this->workshop->getUser());
    }
    
}
