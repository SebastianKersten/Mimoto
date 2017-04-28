/**
 * Mimoto - Realtime dom manager
 *
 * @author Sebastian Kersten (@supertaboo)
 */


// Mimoto classes
var MimotoX = require('./mimoto/MimotoX');


// init
if (typeof Mimoto == "undefined") Mimoto = {};
if (typeof Mimoto.Aimless == "undefined") Mimoto.Aimless = {};
if (typeof Mimoto.modules == "undefined") Mimoto.modules = {};
if (typeof Mimoto.classes == "undefined") Mimoto.classes = {};


var RealtimeManager = require('./mimoto/modules/RealtimeManager');


// include
var MimotoAimless = require('./mimoto/Mimoto');
Mimoto.classes.DomService = require('./mimoto/modules/DomService');
//Mimoto.classes.DomUtils = require('./mimoto/modules/DomUtils');

// setup
Mimoto.Aimless = new MimotoAimless();
//Mimoto.Aimless.dom = new Mimoto.classes.DomService();
//Mimoto.Aimless.utils = new Mimoto.classes.DomUtils();

// connect
document.addEventListener('DOMContentLoaded', function () {

    // update
    Mimoto.Aimless.utils.parseRequestQueue();


    window.MimotoX = new MimotoX('Hoi');

    // connect
    var realtimeManager = new RealtimeManager();


}, false);
