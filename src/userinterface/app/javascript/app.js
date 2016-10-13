'use strict';

var Sidebar = require('./views/Sidebar');

document.addEventListener('DOMContentLoaded', function () {

  var sideBar = document.querySelector('.js-sidebar');

  if (sideBar) {
    new Sidebar(sideBar);
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
