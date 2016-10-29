'use strict';

var HeaderView = require('./views/Header');
var TextlineView = require('./views/Textline');

document.addEventListener('DOMContentLoaded', function () {

  var navigation = document.querySelector('.js-navigation');
  var header = document.querySelector('.js-header');
  var textlines = document.querySelectorAll('.js-form-component-textline');

  if (navigation && header) {
    new HeaderView(header);
  }

  for (var i = 0; i < textlines.length; i++) {
    new TextlineView(textlines[i]);
  }

  Conditioner.init();

}, false);
