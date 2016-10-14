'use strict';

var HeaderView = require('./views/Header');

document.addEventListener('DOMContentLoaded', function () {

  var navigation = document.querySelector('.js-navigation');
  var header = document.querySelector('.js-header');

  if (navigation && header) {
    new HeaderView(header);
  }

  Conditioner.init();

  ErrorHandling.init({
    "element": "p",
    "classes": ["form-component-element-error"],
    "errorClass": "form-component--has-error",
    "validatedClass": "form-component--is-validated",
    "iconSelectorClass": "js-form-component-title-icon",
    "iconErrorClass": "icon-warning",
    "iconValidatedClass": "icon-checkmark"
  });

}, false);
