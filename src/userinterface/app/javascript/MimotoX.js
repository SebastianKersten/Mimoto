/**
 * Mimoto - Realtime fluid data management
 *
 * @author Sebastian Kersten (@supertaboo)
 */


// Mimoto classes
let RealtimeManagerX = require('mimoto/modules/RealtimeManagerX');



class MimotoX
{

    // realtime
    private _realtimeManager = null;


    constructor(sMessage)
    {
        console.log(sMessage);

        this._realtimeManager = new RealtimeManagerX();
    }
}

/**
 * Auto run
 */
document.addEventListener('DOMContentLoaded', function () {

    console.log('xxx');

    window.MimotoX = new MimotoX('Hi from MimotoX');

}, false);


