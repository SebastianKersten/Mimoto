'use strict';

module.exports = function (element) {

  this.el = element;
  this.init();

};

module.exports.prototype = {

  init: function () {

    console.log('Init Textline');

    this.setVariables();

    this.addEventListeners();

  },

  setVariables: function () {

    this.input = this.el.querySelector('.js-form-input');

  },

  addEventListeners: function () {

    this.input.addEventListener('keyup', function () {

      this.handleValidation(this.input.value);

    }.bind(this));

  },

  handleValidation: function (value) {

    if (value.length == 0) {

      EH.clearState(this.el);

    } else {

      var validated = FV.validateTextline(this.el);

      if (validated.passed) {

        EH.addValidatedState(this.el);

      } else {

        EH.addErrorState(this.el, validated.message);

      }

    }

  }

};
