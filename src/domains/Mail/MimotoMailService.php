<?php

// classpath
namespace MaidoProjects\Mail;


/**
 * MailService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MailService
{
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Send mail
     */
    public function sendMail($sTemplate, $aData)
    {
        
    }
    
    /**
     * Schedule mail
     */
    public function scheduleMail($sTemplate, $aData, $momentToSend)
    {
        // opslaan in request/action queue
        // ScheduleService / TaskService
        // Sequence / Action
    }
    
}
