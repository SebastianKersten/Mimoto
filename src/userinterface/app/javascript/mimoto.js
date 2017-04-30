/**
 * Mimoto - An ultra fast, fluid & realtime data management microframework
 *
 * @author Sebastian Kersten (@supertaboo)
 */


// Mimoto classes
var Mimoto = require('./mimoto/Mimoto');

// init
window.MimotoX = new Mimoto();

// connect
document.addEventListener('DOMContentLoaded', function () { MimotoX.startup(); }, true);
