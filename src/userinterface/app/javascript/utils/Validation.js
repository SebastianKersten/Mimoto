'use strict';

module.exports = function (options) {

  this.init(options);

};

module.exports.prototype = {

  init: function (options) {

    this.validateMinLength = false;
    this.validateMaxLength = false;
    this.validateNoNumbers = false;

    this.minLength = 0;
    this.maxLength = 100;

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

    this.setVariables();

  },

  setVariables: function () {

    this.regExpNumbers = new RegExp("\\d");

  },

  validateInput: function (value) {

    var result;

    if (this.validateMaxLength) {
      result = this.checkMaxLength(value);
      if (!result.passed) {
        return result;
      }
    }

    if (this.validateMinLength) {
      result = this.checkMinLength(value);
      if (!result.passed) {
        return result;
      }
    }

    if (this.validateNoNumbers) {
      result = this.checkNoNumbers(value);
      if (!result.passed) {
        return result;
      }
    }

    return {
      "passed": true
    };

  },

  checkMinLength: function (value) {

    if (value.length < this.minLength) {
      return {
        "passed": false,
        "message": "Input is too short."
      }
    }

    return {
      "passed": true
    };

  },

  checkMaxLength: function (value) {

    if (value.length > this.maxLength) {
      return {
        "passed": false,
        "message": "Input is too long."
      }
    }

    return {
      "passed": true
    };

  },

  checkNoNumbers: function (value) {

    if (this.regExpNumbers.test(value)) {
      return {
        "passed": false,
        "message": "No numbers allowed."
      }
    }

    return {
      "passed": true
    };

  }

};
