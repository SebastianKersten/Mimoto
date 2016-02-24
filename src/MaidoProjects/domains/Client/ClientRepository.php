<?php

namespace MaidoProjects\Client;

use MaidoProjects\Client\Client;
use MaidoProjects\Client\ClientException;


/**
 * ClientRepository
 *
 * @author Sebastian Kersten
 */
class ClientRepository
{
    
    // private
    const MYSQL_TABLE_CLIENTS = 'clients';
    
    
    
    public function __construct() {}
    
    
    public function get($nId)
    {
        // load
        $sQuery = "SELECT * FROM ".self::MYSQL_TABLE_CLIENTS." WHERE id=".$nId;
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        if ($nItemCount !== 1)
        {
             throw new ClientException('Cannot find client with ID='.$nId);
        }
        else
        {
            
            // init
            $client = new Client();
            
            // register
            $client->setId(mysql_result($result, 0, 'id'));
            $client->setName(mysql_result($result, 0, 'name'));
            
            // send
            return $client;
        }
    }
    
    public function find()
    {
        
        // init
        $aClients = array();
        
        // load
        $sQuery = "SELECT * FROM ".self::MYSQL_TABLE_CLIENTS." ORDER BY name ASC";
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        // register
        for ($i = 0; $i < $nItemCount; $i++)
        {
            
            $client = new Client();
            
            $client->setId(mysql_result($result, $i, 'id'));
            $client->setName(mysql_result($result, $i, 'name'));
            
            $aClients[] = $client;
        }
        
        // send
        return $aClients;
    }
    
}
