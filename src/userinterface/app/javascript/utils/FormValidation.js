'use strict';

module.exports = {

  setVariables: function (element) {

    this.input = element.querySelector('.js-form-input');

    if (this.input) {
      this.value = this.input.value;
    }

    this.checkboxes = element.querySelectorAll('.js-form-checkbox');

    if (this.checkboxes) {
      this.countChecked();
    }

    this.radioButtons = element.querySelectorAll('.js-radio-button');

  },

  countChecked: function () {

    this.checked = 0;

    for (var i = 0; i < this.checkboxes.length; i++) {
      if (this.checkboxes[i].checked) {
        this.checked++;
      }
    }

  },

  checkChecked: function () {

    for (var i = 0; i < this.radioButtons.length; i++) {
      if (this.radioButtons[i].checked) {
        this.setResult(true);
      }
    }

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

    this.minChecked = input.getAttribute('data-min-checked');
    this.maxChecked = input.getAttribute('data-max-checked');

    this.setValidationOptions();

  },

  setValidationOptions: function () {

    this.validateMinLength = false;
    this.validateMaxLength = false;
    this.validateNoNumbers = false;
    this.validateMinNumbers = false;
    this.validateMaxNumbers = false;
    this.validateNoSpecialCharacters = false;
    this.validateMinSpecialCharacters = false;
    this.validateMaxSpecialCharacters = false;
    this.validateMinChecked = false;
    this.validateMaxChecked = false;

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

    if (this.minChecked) {
      this.validateMinChecked = true;
    }

    if (this.maxChecked) {
      this.validateMaxChecked = true;
    }

  },

  setResult: function (passed, message) {

    this.result = {};

    this.result.passed = passed;

    if (message) {
      this.result.message = message;
    }

  },

  validateRadioButton: function (element) {

    this.setVariables(element);
    this.setResult(false, "Please select an option.");

    this.checkChecked();

    return this.result;

  },

  validateCheckbox: function (element) {

    this.setVariables(element);
    this.setInputOptions(this.checkboxes[0]);
    this.setResult(true);

    this.handleValidation();

    return this.result;

  },

  validateTextline: function (element) {

    this.setVariables(element);
    this.setInputOptions(this.input);
    this.setResult(true);

    this.handleValidation();

    return this.result;

  },

  handleValidation: function () {

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

    if (this.validateMinChecked) {
      this.checkMinChecked();
    }

    if (this.validateMaxChecked) {
      this.checkMaxChecked();
    }

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
      this.setResult(false, "Input should contain a minimum of " + this.minSpecialCharacters + " special character(s).");
    }

  },

  checkMaxSpecialCharacters: function () {

    var regExp = new RegExp("([\\w]*\\W){" + (Number(this.maxSpecialCharacters) + 1) + ",}");

    if (regExp.test(this.value)) {
      this.setResult(false, "Input can't contain more than " + this.maxSpecialCharacters + " special character(s).");
    }

  },

  checkMinChecked: function () {

    if (this.checked < this.minChecked) {
      this.setResult(false, "You need to check at least " + this.minChecked + " checkbox(es).");
    }

  },

  checkMaxChecked: function () {

    if (this.checked > this.maxChecked) {
      this.setResult(false, "You can't check more than " + this.maxChecked + " checkbox(es).");
    }

  }

};
