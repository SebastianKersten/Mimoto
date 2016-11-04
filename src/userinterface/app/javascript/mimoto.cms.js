'use strict';

var HeaderView = require('./views/Header');
var TextlineView = require('./views/form-components/Textline');
var CheckboxView = require('./views/form-components/Checkbox');
var FormView = require('./views/form-components/Form');

document.addEventListener('DOMContentLoaded', function () {

  var navigation = document.querySelector('.js-navigation');
  var header = document.querySelector('.js-header');
  var textlines = document.querySelectorAll('.js-form-component-textline');
  var checkboxes = document.querySelectorAll('.js-form-component-checkbox');
  var forms = document.querySelectorAll('.js-form');

  if (navigation && header) {
    new HeaderView(header);
  }

  for (var i = 0; i < textlines.length; i++) {
    new TextlineView(textlines[i]);
  }

  for (i = 0; i < forms.length; i++) {
    new FormView(forms[i]);
  }

  if (checkboxes.length > 0) {
    var checkboxView = new CheckboxView(checkboxes);
  }

  Conditioner.init();

}, false);
