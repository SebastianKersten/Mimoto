'use strict';

var HeaderView = require('./views/Header');
var FormView = require('./views/form-components/Form');

document.addEventListener('DOMContentLoaded', function () {

  var navigation = document.querySelector('.js-navigation');
  var header = document.querySelector('.js-header');
  var forms = document.querySelectorAll('.js-form');

  if (navigation && header) {
    new HeaderView(header);
  }

  for (var i = 0; i < forms.length; i++) {
    new FormView(forms[i]);
  }

  EH.init({
    "element": "p",
    "classes": ["form-component-element-error"],
    "errorClass": "form-component--has-error",
    "validatedClass": "form-component--is-validated",
    "iconSelectorClass": "js-error-icon",
    "iconErrorClass": "form-component-title-icon--warning",
    "iconValidatedClass": "form-component-title-icon--checkmark"
  });

  Conditioner.init();

}, false);
