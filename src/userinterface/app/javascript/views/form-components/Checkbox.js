'use strict';

module.exports = function (element) {

  this.el = element;
  this.init();

};

module.exports.prototype = {

  init: function () {

    console.log('Init checkbox');
    this.setVariables();
    this.addEventListeners();

    this.initErrorhandling();

  },

  initErrorhandling: function () {

    this.errorHandling = new ErrorHandling(this.el, {
      "element": "p",
      "classes": ["form-component-element-error"],
      "errorClass": "form-component--has-error",
      "validatedClass": "form-component--is-validated",
      "iconSelectorClass": "js-error-icon",
      "iconErrorClass": "form-component-title-icon--warning",
      "iconValidatedClass": "form-component-title-icon--checkmark"
    });

    this.validation = new ValidationCheckbox({
    });

  },

  setVariables: function () {


  },

  addEventListeners: function () {


  },

  handleValidation: function (value) {

    if (value.length == 0) {

      this.errorHandling.clearState();

    } else {

      var validated = this.validation.validateInput(value);

      if (validated.passed) {

        this.errorHandling.addValidatedState();

      } else {

        this.errorHandling.addErrorState(validated.message, this.el);

      }

    }

  }

};
