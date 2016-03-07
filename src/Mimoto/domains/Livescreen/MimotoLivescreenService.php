<?php

// classpath
namespace library\Livescreen;


/**
 * LivescreenService
 *
 * @author Sebastian Kersten
 */
class MimotoLivescreenService
{
    
    // repositories
    private $_ClientRepository;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($ClientRepository)
    {
        // register
        $this->_ClientRepository = $ClientRepository;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get client by ID
     */
    public function sendUpdate($nId) // UPDATED
    {
        
        stuur
        
        // gooi in Gearman
        
        
        LivescreenMessage (model) #todo
        
        
        // generieke livescreen API ingang, met ID voor object o.i.d.
        // #YES: mapping -> url vs welk model, id etc
        // of fields kan directe data zijn
        
        // $( "input[value='Hot Fuzz']" ).next().text( "Hot Fuzz" );
        // MimotoLivescreenID=''
        
        // query in LivescreenID identifier:
        // field:client.<id>.value
        
        
        //To get all the elements starting with "jander" you should use:
        //$("[id^=jander]")
        //
        //To get those that end with "jander"
        //$("[id$=jander]")
        //    
        //http://api.jquery.com/category/selectors/
        
        // set livescreenid prefix (lsid) shorter than full name -> saves data traffic
        // 
        // 
        // http://api.jquery.com/attribute-contains-selector/
        //
        // build selector based on event
        
        // entity=subproject
        // properties=[
        //  name: 'In store visuals'
        //],
        // id: 5,
        // livescreenid='subproject.5.name'
        // field:
        
        // only broadcast changed ->
        // model set -> save to modified -> track changes, default aan na uitgeven entity
        
        //if has values -> replace values
        //if component && id -> reload component
        //if (componen && new-id -> load and add 
        
            
            
        
        
        $data = (object) array();
    
        $data->type = 'livescreen';

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
    
    /**
     * Get all 
     */
    public function sendUpdate() // CREATED
    {
       $data = (object) array();
    
        $data->type = 'livescreen';

        $data->ajax = (object) array();
        $data->ajax->url = '/livescreen/agency/'.$agencyEvent->getAgency()->getId();
        $data->ajax->method = 'GET';
        //$data->ajax->data = (object) array('bla' => 'yeahBlaYeah!');
        $data->ajax->dataType = 'html';

        $data->dom = (object) array();
        $data->dom->containerId = '#simplelist';
        $data->dom->objectId = '#simplelist_item_'.$agencyEvent->getAgency()->getId();

        // dom, internal template id's direct live update, of replace entire element

        sendPusherEvent('agencies', 'agency.created', $data);
    }
    
}
