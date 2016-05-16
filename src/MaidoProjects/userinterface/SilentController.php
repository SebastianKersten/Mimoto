<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MaidoProjects\UserInterface;


use Silex\Application;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;


/**
 * SilentController
 *
 * @author Sebastian Kersten (@supertaoo)
 */
class SilentController {
    //put your code here
    
    public function getIndex(Application $app)
    {
        
        return $app['twig']->render(
            'interface.twig',
            array(
                'section' => 'silent',
                'pagetemplate' => 'pages/silent/SilentPage.twig'
            )
        );
    }
    
}
