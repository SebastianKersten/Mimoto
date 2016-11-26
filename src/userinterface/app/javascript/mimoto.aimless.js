'use strict';



// init
if (typeof Mimoto == "undefined") Mimoto = {};
if (typeof Mimoto.Aimless == "undefined") Mimoto.Aimless = {};
if (typeof Mimoto.Aimless.realtime == "undefined") Mimoto.Aimless.realtime = {};

// include
var MimotoAimless = require('./mimoto.aimless/Mimoto.Aimless');

// setup
Mimoto.Aimless = new MimotoAimless();


document.addEventListener('DOMContentLoaded', function () {

    // ... anything here?
    
}, false);

