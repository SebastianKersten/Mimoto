<?php

// classpath
namespace Mimoto\Core;


/**
 * Validation
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class Validation
{

    const TYPE_IBAN     = 'iban';
    const TYPE_EMAIL    = 'email';
    const TYPE_MINCHARS = 'minchars';
    const TYPE_MAXCHARS = 'maxchars';

    const OPTIONAL      = 'optional';

    const REGEXP_IBAN   = '/[a-zA-Z]{2}[0-9]{2}[a-zA-Z0-9]{4}[0-9]{7}([a-zA-Z0-9]?){0,16}/';
    const REGEXP_EMAIL  = '';

    const UNIQUE        = 'unique';

}


