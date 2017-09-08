/**
 * Mimoto - An ultra fast, fluid & realtime data management microframework
 *
 * @author Sebastian Kersten (@supertaboo)
 */


// Mimoto classes
var ClassMimoto = require('./mimoto/Mimoto');

// init
window.Mimoto = new ClassMimoto();


// connect
document.addEventListener('DOMContentLoaded', function () {

    // register
    Mimoto.version = __webpack_hash__;

    // startup
    Mimoto.startup();

}, true);
