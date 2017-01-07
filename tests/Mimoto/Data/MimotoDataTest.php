<?php


use Mimoto\Mimoto;

require __DIR__.'/../../../src/app.php';
Mimoto::setService('data', $app['Mimoto.Data']);

/**
 * MimotoData - Test
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoDataTest extends \PHPUnit_Framework_TestCase
{
    public function XtestSetUnknonwPropery()
    {
        $project = new \Mimoto\Data\MimotoData();
        
        $this->expectException($project->setValue('name', 'Bugaboo'));
        // 1. needs php update?
    }
    
    public function testCreateAndSetValuePropery()
    {
        $project = new \Mimoto\Data\MimotoData();
        
        $project->setValueAsProperty('name');        
        $project->setValue('name', 'VanMoof');
        
        $this->assertEquals('VanMoof', $project->getValue('name'), "Project name should be 'VanMoof'");
        
        // 1. shoudl have changes
    }
    
    public function testCreateAndUnsetValuePropery()
    {
        $project = new \Mimoto\Data\MimotoData();
        
        $project->setValueAsProperty('name');        
        $project->setValue('name', '');
        
        $this->assertEmpty($project->getValue('name'), "Project name should be empty");
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
    
    public function testCreateAndUnsetEntityPropery()
    {
        $project = new \Mimoto\Data\MimotoData();
        
        $project->setEntityAsProperty('client', 'client');        
        $project->setValue('client', 2);
        
        $this->assertEmpty($project->getValue('client'), "Client should be empty");
    }
}
