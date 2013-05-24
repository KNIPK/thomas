<?php

namespace Kni\ThomasBundle\DependencyInjection;

class NavigationBar
{
    private static $aNavigationBar = array(array('name'=>"Thomas", 'urlName'=>"home"));
    
    public static function get(){
        return self::$aNavigationBar;
    }
    
    public static function add($name, $urlName){
        $data = array();
        $data['name'] = $name;
        $data['urlName'] = $urlName;
        
        self::$aNavigationBar[] = $data;
    }
}

?>
