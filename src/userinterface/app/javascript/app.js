'use strict';

document.addEventListener('DOMContentLoaded', function () {

  var Test = require('./views/test');
  var Textline = require('forms/input/Textline/textline.js'); // You can require from src/userinterface/MimotoCMS/components

  new Test();
  new Textline();


}, false);
