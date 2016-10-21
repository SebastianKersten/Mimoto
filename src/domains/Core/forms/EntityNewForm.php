<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * EntityNewForm
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityNewForm
{

    public static function getStructure()
    {
        // init
        $form = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM);

        // create and add
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_OUTPUT_TITLE);
        $field->setValue('title', 'Add new entity');
        $field->setValue('description', "The core element of data is called an 'entity'. Entities are the data objects that contain a certain set of properties, for instance <i>Person</i> containing a <i>name</i> and a <i>date of birth</i>");

        // add
        $form->addValue('fields', $field);

        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART);

        // add
        $form->addValue('fields', $field);




        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND);

        // add
        $form->addValue('fields', $field);


        // send
        return $form;
    }

}
