'use strict';

module.exports = function (options) {

  this.init(options);

};

module.exports.prototype = {

  init: function (options) {

    console.log('Validate checkbox');

    this.setVariables();

  },

  setVariables: function () {


  },

  validateCheckbox: function (value) {

    this.value = value;
    this.result = {
      "passed": true
    };


    return this.result;

  }

};
