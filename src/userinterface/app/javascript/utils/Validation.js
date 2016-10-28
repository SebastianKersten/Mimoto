'use strict';

module.exports = function (options) {

  this.init(options);

};

module.exports.prototype = {

  init: function (options) {

    this.validateMaxLength = true;
    this.validateMinLength = true;


    this.minLength = 0;
    this.maxLength = 100;

    if (options.minLength) {
      this.minLength = options.minLength;
    }

    if (options.maxLength) {
      this.maxLength = options.maxLength;
    }

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

    if (value.length >= this.maxLength) {
      return {
        "passed": false,
        "message": "Input is too long."
      }
    }

    return {
      "passed": true
    };

  }

};
