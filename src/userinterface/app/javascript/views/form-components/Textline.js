'use strict';

module.exports = function (element) {

  this.el = element;
  this.init();

};

module.exports.prototype = {

  init: function () {

    console.log('Init textline');
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

    this.validation = new ValidationTextline({
      "minLength": this.minLength,
      "maxLength": this.maxLength,
      "minNumbers": this.minNumbers,
      "maxNumbers": this.maxNumbers,
      "noSpecialCharacters": this.noSpecialCharacters,
      "minSpecialCharacters": this.minSpecialCharacters,
      "maxSpecialCharacters": this.maxSpecialCharacters
    });

  },

  setVariables: function () {

    this.input = this.el.querySelector('.js-form-input');

    this.minLength = this.input.getAttribute('data-min-length');
    this.maxLength = this.input.getAttribute('data-max-length');
    this.minNumbers = this.input.getAttribute('data-min-numbers');
    this.maxNumbers = this.input.getAttribute('data-max-numbers');
    this.minSpecialCharacters = this.input.getAttribute('data-min-special-characters');
    this.maxSpecialCharacters = this.input.getAttribute('data-max-special-characters');
    this.noSpecialCharacters = this.input.hasAttribute('data-no-special-characters');

  },

  addEventListeners: function () {

    this.input.addEventListener('keyup', function () {

      this.handleValidation(this.input.value);

    }.bind(this));

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
