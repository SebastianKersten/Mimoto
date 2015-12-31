<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MaidoProjects\Controller\pages;


use Silex\Application;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;


/**
 * Description of newPHPClass
 *
 * @author apple
 */
class ProjectsController {
    //put your code here
    
    public function getIndex(Application $app)
    {   
        
        
        $aProjects = array();
        
        $aProjects[] = array('name' => 'Project 1', 'client' => 'Client 1');
        $aProjects[] = array('name' => 'Project 2', 'client' => 'Client 2');
        $aProjects[] = array('name' => 'Project 3', 'client' => 'Client 3');
        
        
        
        return $app['twig']->render(
            'interface.twig',
            array(
                'section' => 'projects',
                'pagetemplate' => 'page_projects.twig',
                'name' => 'Sebastian',
                'projects' => $aProjects
            )
        );
    }
    
}
