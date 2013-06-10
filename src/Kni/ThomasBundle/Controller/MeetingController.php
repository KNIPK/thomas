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
 * @Route("meeting")
 */
class MeetingController extends Controller {

    private $workshop;

    /**
     * Lists all Workshop entities.
     *
     * @Route("/{workshopId}", name="meeting_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($workshopId) {

        //sprawdzimy czy user może tutaj przebywać
//        $repoUser = $this->getDoctrine()
//                ->getRepository('KniThomasBundle:Workshop');
//        
//        $queryUser = $repoUser->createQueryBuilder('u')
//                ->join('u.workshops', 'wu')
////                ->where('wu.workshop = :workshopId')
////                ->setParameter('workshopId', $workshopId)
//                ->getQuery();
//        
//        
//        $users = $queryUser->getResult();
//        
//        if(!$users[0]) return $this->redirect($this->generateUrl('join_to_workshop', array('workshopId' => $workshopId)));
  
        //user moze tutaj przebywać
        $repository = $this->getDoctrine()
                ->getRepository('KniThomasBundle:Workshop');

        $query = $repository->createQueryBuilder('w')
                ->leftjoin('w.user', 'u')
                ->where('w.id = :workshopId')
                ->setParameter('workshopId', $workshopId)
                ->getQuery();

        $workshops = $query->getResult();

        $this->workshop = $workshops[0];
        

        return array(
            'workshop' => $this->workshop,
            'adminMode' => $this->checkAdminMode(),
            'maxPosition' => $this->getMaxWorkshopPosition($this->workshop)
        );
    }
    
    private function getMaxWorkshopPosition($workshop){
        $em = $this->getDoctrine()->getManager();
        
        $maxStep = 0;
        
        $questions = $em->getRepository('KniThomasBundle:Question')->findBy(array(
            'workshop' => $workshop
        ), array(
            'position' => 'desc'
        ), 1);
        
        $steps = $em->getRepository('KniThomasBundle:Step')->findBy(array(
            'workshop' => $workshop
        ), array(
            'position' => 'desc'
        ), 1);
        
        if($questions){
            $maxStep = $questions[0]->getPosition();
        }
        
        if($steps && $steps[0]->getPosition()>$maxStep){
            $maxStep = $steps[0]->getPosition();
        }
        
        return $maxStep;
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
            return $this->redirect($this->generateUrl('meeting_index', array('workshopId' => $workshopId)));
        } else {

            if ($entity->getPassword() == '') { // jesli nie ma hasla na warsztacie i user nie jest zapisany => zapisz i przekieruj
                print 'dodać obsługe warsztatów bez hasel';
                $users->add($user);
                $em->flush();
                return $this->redirect($this->generateUrl('meeting_index', array('workshopId' => $workshopId)));
            }
            else
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
     * @Template("KniThomasBundle:Meeting:join.html.twig")
     */
    public function joinedAction(Request $request) {

        //if(poprwne_haslo){
        $data = $request->request->all();
        $pass = $data['pass'];
        $id = $data['id'];

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('KniThomasBundle:Workshop')->find($id);

        if ($pass == $entity->getPassword()) {
            $user = $this->get('security.context')->getToken()->getUser();
            $registeredUsers = $entity->getUsers();
            $registeredUsers->add($user);
            $em->flush();
            return $this->redirect($this->generateUrl('meeting_index', array('workshopId' => $id)));
        } else {
            return array(
                'error' => 'Podałeś niepoprawne hasło. Spróbój ponownie.',
                'entity' => $entity
            );
        }
    }

    /**
     * Metoda zwraca czy strona jest otwarta przez osobe, która zarządza tymi warsztatami
     */
    private function checkAdminMode() {
        if ($this->get('security.context')->getToken()->getUser() == $this->workshop->getUser())
            return 1;
        else
            return 0;
    }

}

