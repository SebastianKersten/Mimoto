/**
 * Mimoto.Publisher - Demo - How to build a publication platform
 *
 * @author Sebastian Kersten (@supertaboo)
 */


'use strict';


// Publisher demo classes
let Publisher = require('./Publisher/Publisher');


/**
 * Auto run
 */
document.addEventListener('DOMContentLoaded', function ()
{
    // init
    window.Publisher = new Publisher();

}, false);
