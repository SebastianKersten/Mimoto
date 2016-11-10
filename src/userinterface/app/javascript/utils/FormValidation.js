'use strict';

module.exports = {

  init: function () {

    console.log('Init Validation');

    this.setVariables();

  },

  setVariables: function () {

    this.result = {};

    this.validateMinLength = false;
    this.validateMaxLength = false;
    this.validateNoNumbers = false;
    this.validateMinNumbers = false;
    this.validateMaxNumbers = false;
    this.validateNoSpecialCharacters = false;
    this.validateMinSpecialCharacters = false;
    this.validateMaxSpecialCharacters = false;

  },

  setInputOptions: function (input) {

    this.minLength = input.getAttribute('data-min-length');
    this.maxLength = input.getAttribute('data-max-length');

    this.noNumbers = input.getAttribute('data-no-numbers');
    this.minNumbers = input.getAttribute('data-min-numbers');
    this.maxNumbers = input.getAttribute('data-max-numbers');

    this.noSpecialCharacters = input.hasAttribute('data-no-special-characters');
    this.minSpecialCharacters = input.getAttribute('data-min-special-characters');
    this.maxSpecialCharacters = input.getAttribute('data-max-special-characters');

    this.setValidationOptions();

  },

  setValidationOptions: function () {

    if (this.minLength) {
      this.validateMinLength = true;
    }

    if (this.maxLength) {
      this.validateMaxLength = true;
    }

    if (this.noNumbers) {
      this.validateNoNumbers = true;
    }

    if (this.minNumbers) {
      this.validateMinNumbers = true;
    }

    if (this.maxNumbers) {
      this.validateMaxNumbers = true;
    }

    if (this.noSpecialCharacters) {
      this.validateNoSpecialCharacters = true;
    }

    if (this.minSpecialCharacters) {
      this.validateMinSpecialCharacters = true;
    }

    if (this.maxSpecialCharacters) {
      this.validateMaxSpecialCharacters = true;
    }

  },

  setResult: function (passed, message) {

    this.result = {};

    this.result.passed = passed;

    if (message) {
      this.result.message = message;
    }

  },

  validateCheckbox: function (element) {

    this.el = element;

    return this.checkIfChecked();

  },

  validateTextline: function (element) {

    this.input = element.querySelector('.js-form-input');
    this.value = this.input.value;

    this.setInputOptions(this.input);
    this.setResult(true);

    if (this.validateMinLength) {
      this.checkMinLength();
    }

    if (this.validateMaxLength) {
      this.checkMaxLength();
    }

    if (this.validateNoNumbers) {
      this.checkNoNumbers();
    }

    if (this.validateMinNumbers) {
      this.checkMinNumbers();
    }

    if (this.validateMaxNumbers) {
      this.checkMaxNumbers();
    }

    if (this.validateNoSpecialCharacters) {
      this.checkNoSpecialCharacters();
    }

    if (this.validateMinSpecialCharacters) {
      this.checkMinSpecialCharacters();
    }

    if (this.validateMaxSpecialCharacters) {
      this.checkMaxSpecialCharacters();
    }

    return this.result;

  },





  checkIfChecked: function () {

    var checkboxes = this.el.querySelectorAll('input');

    this.setResult(false, "Select a checkbox.");

    for (var i = 0; i < checkboxes.length; i++) {

      if (checkboxes[i].checked) {
        this.setResult(true);
      }

    }

    return this.result;

  },

  checkMinLength: function () {

    if (this.value.length < this.minLength) {
      this.setResult(false, "Input should be minimal " + this.minLength + " characters long.");
    }

  },

  checkMaxLength: function () {

    if (this.value.length > this.maxLength) {
      this.setResult(false, "Input can't be longer than " + this.maxLength + " characters.");
    }

  },

  checkNoNumbers: function () {

    var regExp = new RegExp("\\d");

    if (regExp.test(this.value)) {
      this.setResult(false, "No numbers allowed.");
    }

  },

  checkMinNumbers: function () {

    var regExp = new RegExp("([^\\d]*\\d){" + this.minNumbers + ",}");

    if (!regExp.test(this.value)) {
      this.setResult(false, "Input should contain a minimum of " + this.minNumbers + " number(s).");
    }
  },

  checkMaxNumbers: function () {

    var regExp = new RegExp("([^\\d]*\\d){" + (Number(this.maxNumbers) + 1) + ",}");

    if (regExp.test(this.value)) {
      this.setResult(false, "Input can't contain more than " + this.maxNumbers + " numbers.");
    }

  },

  checkNoSpecialCharacters: function () {

    var regExp = new RegExp("^[\\w]*$");

    if (!regExp.test(this.value)) {
      this.setResult(false, "Input can't contain special characters (except for underscores).");
    }

  },

  checkMinSpecialCharacters: function () {

    var regExp = new RegExp("([\\w]*\\W){" + this.minSpecialCharacters + ",}");

    if (!regExp.test(this.value)) {
      this.setResult(false, "Input should contain a minimum of " + this.minSpecialCharacters + " special characters.");
    }

  },

  checkMaxSpecialCharacters: function () {

    var regExp = new RegExp("([\\w]*\\W){" + (Number(this.maxSpecialCharacters) + 1) + ",}");

    if (regExp.test(this.value)) {
      this.setResult(false, "Input can't contain more than " + this.maxSpecialCharacters + " special characters.");
    }

  }

};
