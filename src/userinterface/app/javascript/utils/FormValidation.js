'use strict';

module.exports = {

  init: function () {

    console.log('Init Validation');

    this.setVariables();

  },

  setVariables: function () {

    this.result = {};
    this.test = "wow";

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

  checkIfChecked: function () {

    var checkboxes = this.el.querySelectorAll('input');

    this.setResult(false, "Select a checkbox.");

    for (var i = 0; i < checkboxes.length; i++) {

      if (checkboxes[i].checked) {
        this.setResult(true);
      }

    }

    return this.result;

  }

};
