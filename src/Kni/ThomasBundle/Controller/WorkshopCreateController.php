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
     * @Route("/steps")
     * @Template()
     */
    public function stepsAction() {
        //add steps and questions
        return array();
    }

}

?>
