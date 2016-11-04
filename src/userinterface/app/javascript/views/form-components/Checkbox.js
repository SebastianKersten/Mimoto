'use strict';

module.exports = function (elements) {

  this.elements = elements;
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

    for (var i = 0; i < this.elements.length; i++) {
      this.errorHandling = new ErrorHandling(this.elements[i], {
        "element": "p",
        "classes": ["form-component-element-error"],
        "errorClass": "form-component--has-error",
        "validatedClass": "form-component--is-validated",
        "iconSelectorClass": "js-error-icon",
        "iconErrorClass": "form-component-title-icon--warning",
        "iconValidatedClass": "form-component-title-icon--checkmark"
      });
    }

    this.validation = new ValidationCheckbox({
    });

  },

  setVariables: function () {
    
  },

  addEventListeners: function () {

    for (var i = 0; i < this.elements.length; i++) {

      (function (e) {
        var checkbox = this.elements[e];

        checkbox.addEventListener('click', function () {

          console.log(checkbox);

        });

      }.bind(this))(i);

    }

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
