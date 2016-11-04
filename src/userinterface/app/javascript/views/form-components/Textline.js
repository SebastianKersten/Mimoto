'use strict';

module.exports = function (element) {

  this.el = element;
  this.init();

};

module.exports.prototype = {

  init: function () {

    console.log('Init textline');

    this.setVariables();
    this.setValidationOptionsObject();
    this.addEventListeners();

    this.initErrorhandling();
    this.initValidation();

  },

  setVariables: function () {

    this.input = this.el.querySelector('.js-form-input');

    this.minLength = this.input.getAttribute('data-min-length');
    this.maxLength = this.input.getAttribute('data-max-length');

    this.noNumbers = this.input.getAttribute('data-no-numbers');
    this.minNumbers = this.input.getAttribute('data-min-numbers');
    this.maxNumbers = this.input.getAttribute('data-max-numbers');

    this.noSpecialCharacters = this.input.hasAttribute('data-no-special-characters');
    this.minSpecialCharacters = this.input.getAttribute('data-min-special-characters');
    this.maxSpecialCharacters = this.input.getAttribute('data-max-special-characters');

  },

  setValidationOptionsObject: function () {

    this.validationOptions = {};

    if (this.minLength) this.validationOptions.minLength = this.minLength;
    if (this.maxLength) this.validationOptions.maxLength = this.maxLength;

    if (this.noNumbers) this.validationOptions.noNumbers = this.noNumbers;
    if (this.minNumbers) this.validationOptions.minNumbers = this.minNumbers;
    if (this.maxNumbers) this.validationOptions.maxNumbers = this.maxNumbers;

    if (this.noSpecialCharacters) this.validationOptions.noSpecialCharacters = this.noSpecialCharacters;
    if (this.minSpecialCharacters) this.validationOptions.minSpecialCharacters = this.minSpecialCharacters;
    if (this.maxSpecialCharacters) this.validationOptions.maxSpecialCharacters = this.maxSpecialCharacters;

  },

  addEventListeners: function () {

    this.input.addEventListener('keyup', function () {

      this.handleValidation(this.input.value);

    }.bind(this));

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

  },

  initValidation: function () {

    this.validation = new ValidationTextline(this.validationOptions);

  },

  handleValidation: function (value) {

    if (value.length == 0) {

      this.errorHandling.clearState();

    } else {

      var validated = this.validation.validateTextline(value);

      if (validated.passed) {

        this.errorHandling.addValidatedState();

      } else {

        this.errorHandling.addErrorState(validated.message, this.el);

      }

    }

  }

};
