<?php

// classpath
namespace MaidoProjects\Agency;

// Momkai classes
use library\eventlisteners\AbstractSingleMySQLTableRepository;


/**
 * AgencyEventListener
 *
 * @author Sebastian Kersten
 */
class AgencyEventListener extends AbstractSingleMySQLTableRepository
{      
    
    /**
     * Constructor
     */
    public function __construct($EventService)
    {
        
        // register
        $this->setEventService($LivescreenService);
        
        // setup
        $this->setModelClass('MaidoProjects\Agency\Agency');
        $this->setModelExceptionClass('MaidoProjects\Agency\AgencyException');
        $this->setModelEventClass('MaidoProjects\Agency\AgencyEvent');
        $this->setMySQLTable('agencies');
        
        // connect
        $this->setModelToMySQLTableMap(
            [
                (object) array('property' => 'Id', 'column' => 'id', 'primary' => true),
                (object) array('property' => 'Name', 'column' => 'name')
            ]
        );
    }
    
    
    
    public function sendUpdate()
    {
        
        $message = new LivescreenMessage();
        
        $data->type = 'livescreen'; // default
        
        
        
        
        $data->ajax = (object) array();
        $data->ajax->url = '/livescreen/agency/'.$agencyEvent->getAgency()->getId();
        $data->ajax->method = 'GET';
        //$data->ajax->data = (object) array('bla' => 'yeahBlaYeah!');
        $data->ajax->dataType = 'html';
        
        
        $message->setValue($agencyEvent->getAgency()->getName());
        
        $message->setDomContainer('#simplelist');
        $message->setDomObject('#simplelist_item_'.$agencyEvent->getAgency()->getId());
        
        // a public, open, discussion about the implications and consequences of our future actions
        
        // SettingsEventListener
        // scheduleMail
        
        // generien event in EventService
        
        
        $data->dom = (object) array();
        $data->dom->containerId = ;
        $data->dom->objectId = ;
        
        
        $data = (object) array();
    
        

        $data->ajax = (object) array();
        $data->ajax->url = '/livescreen/agency/'.$agencyEvent->getAgency()->getId();
        $data->ajax->method = 'GET';
        //$data->ajax->data = (object) array('bla' => 'yeahBlaYeah!');
        $data->ajax->dataType = 'html';

        $data->dom = (object) array();
        $data->dom->containerId = '#simplelist';
        $data->dom->objectId = '#simplelist_item_'.$agencyEvent->getAgency()->getId();

        // dom, internal template id's direct live update, of replace entire element

        sendPusherEvent('agencies', 'agency.updated', $data);
    }
}
