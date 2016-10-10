'use strict';

document.addEventListener('DOMContentLoaded', function () {

  Conditioner.init();

  ErrorHandling.init({
    "element": "p",
    "classes": ["form-component-element-error"],
    "errorClass": "form-component--has-error",
    "iconClass": "js-form-component-title-icon",
    "iconErrorClass": "icon-warning"
  });

}, false);
