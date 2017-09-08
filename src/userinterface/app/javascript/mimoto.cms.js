/**
 * Mimoto - An ultra fast, fluid & realtime data management microframework
 *
 * @author Sebastian Kersten (@supertaboo)
 */


// Mimoto classes
let ClassMimotoCMS = require('./mimoto.cms/MimotoCMS');

// init
window.MimotoCMS = new ClassMimotoCMS();


// connect
document.addEventListener('DOMContentLoaded', function () {

    // register
    MimotoCMS.version = __webpack_hash__;

    // startup
    MimotoCMS.startup();

}, true);
