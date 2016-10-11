'use strict';

document.addEventListener('DOMContentLoaded', function () {

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
