<?php

namespace Kni\ThomasBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/profile/workshopcreate")
 */
class WorkshopCreateController extends Controller {

    /**
     * @Route("/step")
     * @Template()
     */
    public function stepAction() {
        //it is responsible for creating one particular step (it's part of procces of creating steps (stepsAction))    
        return array();
    }

    /**
     * @Route("/steps")
     * @Template()
     */
    public function stepsAction() {
        //add steps and questions
        return array();
    }

}

?>
