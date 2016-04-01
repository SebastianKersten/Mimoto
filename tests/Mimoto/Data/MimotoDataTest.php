<?php


require __DIR__.'/../../../src/app.php';
$GLOBALS['Mimoto.EntityService'] = $app['Mimoto.EntityService'];

/**
 * MimotoData - Test
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoDataTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateAndSetValueProperyTest()
    {
        $project = new \Mimoto\Data\MimotoData();
        
        $project->setValueAsProperty('name');        
        $project->setValue('name', 'VanMoof');
        
        $this->assertEquals('VanMoof', $project->getValue('name'), "Project name should be 'VanMoof'");
    }
    
    public function testCreateAndSetEntityProperty()
    {
        $project = new \Mimoto\Data\MimotoData();
        
        $project->setEntityAsProperty('client', 'client');
        $project->setValue('client', 2);
        
        $this->assertEquals(2, $project->getValue('client')->getId(), "Client id should be '2'");
        
        $project->setValue('client.name', 'Yeah!');
        
        $this->assertEquals($project->getValue('client.name'), 'Yeah!', "Client name should be 'Yeah!'");
    }
}
