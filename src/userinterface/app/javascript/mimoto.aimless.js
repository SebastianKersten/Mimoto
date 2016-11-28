/**
 * Aimless - MLS - Mimoto's Live Screen protocol
 *
 * @author Sebastian Kersten (@supertaboo)
 */


// init
if (typeof Mimoto == "undefined") Mimoto = {};
if (typeof Mimoto.Aimless == "undefined") Mimoto.Aimless = {};
if (typeof Mimoto.modules == "undefined") Mimoto.modules = {};
if (typeof Mimoto.classes == "undefined") Mimoto.classes = {};

// include
var MimotoAimless = require('./mimoto.aimless/Mimoto.Aimless');
Mimoto.classes.DomService = require('./mimoto.aimless/modules/DomService');
Mimoto.classes.DomUtils = require('./mimoto.aimless/modules/DomUtils');
Mimoto.classes.DomRealtime = require('./mimoto.aimless/modules/DomRealtime');

// setup
Mimoto.Aimless = new MimotoAimless(new Mimoto.classes.DomService());
Mimoto.Aimless.utils = new Mimoto.classes.DomUtils();
Mimoto.Aimless.realtime = new Mimoto.classes.DomRealtime();

// connect
document.addEventListener('DOMContentLoaded', function () {
    
    // 1. setup webevents
    Mimoto.Aimless.connect(false);
    
}, false);

