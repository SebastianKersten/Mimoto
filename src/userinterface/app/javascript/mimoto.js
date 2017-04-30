/**
 * Mimoto - The ultra fast, fluid & realtime data management microframework
 *
 * @author Sebastian Kersten (@supertaboo)
 */


// Mimoto classes
var MimotoStartup = require('./mimoto/MimotoStartup');

// init
window.MimotoX = new MimotoStartup();

// connect
document.addEventListener('DOMContentLoaded', function () { MimotoX.startup(); }, false);
