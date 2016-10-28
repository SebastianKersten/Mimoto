'use strict';

module.exports = function (options) {

  this.init(options);

};

module.exports.prototype = {

  init: function (options) {

    this.validateMinLength = false;
    this.validateMaxLength = false;
    this.validateNoNumbers = false;
    this.validateMinNumbers = false;
    this.validateMaxNumbers = false;
    this.validateNoSpecialCharacters = false;
    this.validateMinSpecialCharacters = false;
    this.validateMaxSpecialCharacters = false;

    if (options.minLength) {
      this.minLength = options.minLength;
      this.validateMinLength = true;
    }

    if (options.maxLength) {
      this.maxLength = options.maxLength;
      this.validateMaxLength = true;
    }

    if (options.noNumbers) {
      this.validateNoNumbers = true;
    }

    if (options.minNumbers) {
      this.minNumbers = options.minNumbers;
      this.validateMinNumbers = true;
    }

    if (options.maxNumbers) {
      this.maxNumbers = options.maxNumbers;
      this.validateMaxNumbers = true;
    }

    if (options.noSpecialCharacters) {
      this.validateNoSpecialCharacters = true;
    }

    if (options.minSpecialCharacters) {
      this.minSpecialCharacters = options.minSpecialCharacters;
      this.validateMinSpecialCharacters = true;
    }

    if (options.maxSpecialCharacters) {
      this.maxSpecialCharacters = options.maxSpecialCharacters;
      this.validateMaxSpecialCharacters = true;
    }

    this.setVariables();

  },

  setVariables: function () {


  },

  validateInput: function (value) {

    this.value = value;
    this.result = {
      "passed": true
    };

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

  checkMinLength: function () {

    if (this.value.length < this.minLength) {
      this.result = {
        "passed": false,
        "message": "Input is too short."
      }
    }

  },

  checkMaxLength: function () {

    if (this.value.length > this.maxLength) {
      this.result = {
        "passed": false,
        "message": "Input is too long."
      }
    }

  },

  checkNoNumbers: function () {

    var regExp = new RegExp("\\d");

    if (regExp.test(this.value)) {
      this.result = {
        "passed": false,
        "message": "No numbers allowed."
      }
    }

  },

  checkMinNumbers: function () {

    var regExp = new RegExp("([^\\d]*\\d){" + this.minNumbers + ",}");

    if (!regExp.test(this.value)) {
      this.result = {
        "passed": false,
        "message": "Input should contain a minimum of " + this.minNumbers + " number(s)."
      }
    }
  },

  checkMaxNumbers: function () {

    var regExp = new RegExp("([^\\d]*\\d){" + (Number(this.maxNumbers) + 1) + ",}");

    if (regExp.test(this.value)) {
      this.result = {
        "passed": false,
        "message": "Input can't contain more than " + this.maxNumbers + " numbers."
      }
    }

  },

  checkNoSpecialCharacters: function () {

    var regExp = new RegExp("^[\\w]*$");

    if (!regExp.test(this.value)) {
      this.result = {
        "passed": false,
        "message": "Input can't contain special characters (except for underscore)."
      }
    }

  },

  checkMinSpecialCharacters: function () {

    var regExp = new RegExp("([\\w]*\\W){" + this.minSpecialCharacters + ",}");

    if (!regExp.test(this.value)) {
      this.result = {
        "passed": false,
        "message": "Input should contain a minimum of " + this.minSpecialCharacters + " special characters."
      }
    }

  },

  checkMaxSpecialCharacters: function () {

    var regExp = new RegExp("([\\ww]*\\W){" + (Number(this.maxSpecialCharacters) + 1) + ",}");

    if (regExp.test(this.value)) {
      this.result = {
        "passed": false,
        "message": "Input can't contain more than " + this.maxSpecialCharacters + " special characters."
      }
    }

  }

};
