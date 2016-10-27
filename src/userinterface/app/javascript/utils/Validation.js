'use strict';

module.exports = function (options) {

  this.init(options);

};

module.exports.prototype = {

  init: function (options) {

    this.minLength = 0;
    this.maxLength = 100;

    if (options.minLength) {
      this.minLength = options.minLength;
    }

    if (options.maxLength) {
      this.maxLength = options.maxLength;
    }

  },

  validate: function (value) {

    return this.checkLength(value);

  },

  checkLength: function (value) {

    var length = value.length;

    return (length >= this.minLength && length < this.maxLength);

  }

};
