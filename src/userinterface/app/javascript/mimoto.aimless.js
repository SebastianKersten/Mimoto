/**
 * Aimless - MLS - Mimoto's Live Screen protocol
 *
 * @author Sebastian Kersten (@supertaboo)
 */


// init
if (typeof Mimoto == "undefined") Mimoto = {};
if (typeof Mimoto.Aimless == "undefined") Mimoto.Aimless = {};
if (typeof Mimoto.modules == "undefined") Mimoto.modules = {};

// include
var MimotoAimless = require('./mimoto.aimless/Mimoto.Aimless');
Mimoto.modules.DomService = require('./mimoto.aimless/modules/DomService');

// setup
Mimoto.Aimless = new MimotoAimless(new Mimoto.modules.DomService());
Mimoto.Aimless.utils = new require('./mimoto.aimless/modules/DomUtils');
Mimoto.Aimless.realtime = new require('./mimoto.aimless/modules/DomRealtime');

// connect
document.addEventListener('DOMContentLoaded', function () {
    
    // 1. setup webevents
    Mimoto.Aimless.connect(true);
    
}, false);

