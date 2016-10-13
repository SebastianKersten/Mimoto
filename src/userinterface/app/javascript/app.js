'use strict';

var Sidebar = require('./views/Sidebar');
var sideBar = document.querySelector('.js-sidebar');

document.addEventListener('DOMContentLoaded', function () {

  if (sideBar) {
    new Sidebar();
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
