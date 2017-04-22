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


var RealtimeManager = require('./mimoto/modules/RealtimeManager');


// include
var MimotoAimless = require('./mimoto/Mimoto');
Mimoto.classes.DomService = require('./mimoto/modules/DomService');
Mimoto.classes.DomUtils = require('./mimoto/modules/DomUtils');
Mimoto.classes.DomRealtime = require('./mimoto/modules/DomRealtime');

// setup
Mimoto.Aimless = new MimotoAimless();
Mimoto.Aimless.dom = new Mimoto.classes.DomService();
Mimoto.Aimless.utils = new Mimoto.classes.DomUtils();
Mimoto.Aimless.realtime = new Mimoto.classes.DomRealtime();

// connect
document.addEventListener('DOMContentLoaded', function () {
    
    // update
    Mimoto.Aimless.utils.parseRequestQueue();

    // connect
    var realtimeManager = new RealtimeManager();


}, false);
