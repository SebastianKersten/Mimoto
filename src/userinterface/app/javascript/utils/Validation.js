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

    this.setVariables();

  },

  setVariables: function () {


  },

  validateInput: function (value) {

    var result;
    this.value = value;

    if (this.validateMaxLength) {
      result = this.checkMaxLength();
      if (!result.passed) {
        return result;
      }
    }

    if (this.validateMinLength) {
      result = this.checkMinLength();
      if (!result.passed) {
        return result;
      }
    }

    if (this.validateNoNumbers) {
      result = this.checkNoNumbers();
      if (!result.passed) {
        return result;
      }
    }

    if (this.validateMinNumbers) {
      result = this.checkMinNumbers(value);
      if (!result.passed) {
        return result;
      }
    }

    if (this.validateMaxNumbers) {
      result = this.checkMaxNumbers(value);
      if (!result.passed) {
        return result;
      }
    }

    return {
      "passed": true
    };

  },

  checkMinLength: function () {

    if (this.value.length < this.minLength) {
      return {
        "passed": false,
        "message": "Input is too short."
      }
    }

    return {
      "passed": true
    };

  },

  checkMaxLength: function () {

    if (this.value.length > this.maxLength) {
      return {
        "passed": false,
        "message": "Input is too long."
      }
    }

    return {
      "passed": true
    };

  },

  checkNoNumbers: function () {

    var regExp = new RegExp("\\d");

    if (regExp.test(this.value)) {
      return {
        "passed": false,
        "message": "No numbers allowed."
      }
    }

    return {
      "passed": true
    };

  },

  checkMinNumbers: function () {

    var regExp = new RegExp("\\d{" + this.minNumbers + "}");

    if (!regExp.test(this.value)) {
      return {
        "passed": false,
        "message": "Input should contain a minimum of " + this.minNumbers + " number(s)."
      }
    }

    return {
      "passed": true
    };

  },

  checkMaxNumbers: function () {

    var regExp = new RegExp("([^\\d]*\\d){" + (Number(this.maxNumbers) + 1) + ",}");

    if (regExp.test(this.value)) {
      return {
        "passed": false,
        "message": "Input can't contain more than " + this.maxNumbers + " numbers."
      }
    }

    return {
      "passed": true
    };

  }

};
