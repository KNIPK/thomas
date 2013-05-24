<?php

namespace Kni\ThomasBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/profile/workshopedit")
 */
class WorkshopEditController extends Controller {

    /**
     * @Route("/steps")
     * @Template()
     */
    public function stepsAction() {
        //add steps and questions
        return array();
    }
    
    /**
     * @Route("/basicInfo", defaults={"workshopId" = 0})    
     * @Route("/basicInfo/{workshopId}")
     * @Template()
     */
    public function basicInfoAction($workshopId){
        
        if($workshopId==0) $bWorkshopCreate = true; //zmienna ktora okresla czy tworzymy nowy czy edytujemy
        else $bWorkshopCreate = false;
        
        
        
        return array(
            'bWorkshopCreate' => $bWorkshopCreate
        );
    }
    
    

}

?>
