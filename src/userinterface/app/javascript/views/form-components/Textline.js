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

    this.textline = this.el.querySelector('.js-textline');

  },

  addEventListeners: function () {

    this.textline.addEventListener('keyup', function () {

      this.handleValidation(this.textline.value);

    }.bind(this));

  },

  handleValidation: function (value) {

    if (value.length == 0) {

      EH.clearState(this.el);

    } else {

      FV.validateInput(this.el);

    }

  }

};
