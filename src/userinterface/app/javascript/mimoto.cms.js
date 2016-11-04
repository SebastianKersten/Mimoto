'use strict';

var HeaderView = require('./views/Header');
var TextlineView = require('./views/form-components/Textline');
var CheckboxView = require('./views/form-components/Checkbox');

document.addEventListener('DOMContentLoaded', function () {

  var navigation = document.querySelector('.js-navigation');
  var header = document.querySelector('.js-header');
  var textlines = document.querySelectorAll('.js-form-component-textline');
  var checkboxes = document.querySelectorAll('.js-form-component-checkbox');

  if (navigation && header) {
    new HeaderView(header);
  }

  for (var i = 0; i < textlines.length; i++) {
    new TextlineView(textlines[i]);
  }

  for (i = 0; i < checkboxes.length; i++) {
    new CheckboxView(checkboxes[i]);
  }

  Conditioner.init();

}, false);
