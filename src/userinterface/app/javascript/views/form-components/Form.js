'use strict';

module.exports = function (element) {

  this.el = element;
  this.init();

};

module.exports.prototype = {

  init: function () {

    console.log('Init form ');

    this.setVariables();
    this.addEventListeners();

    this.initErrorHandling();

  },


  setVariables: function () {

    this.submit = this.el.querySelector('.js-form-submit');

  },

  addEventListeners: function () {

    this.submit.addEventListener('click', function () {

      this.submitForm();

    }.bind(this));

  },

  submitForm: function () {

    var validated = this.validateForm();

  },

  validateForm: function () {


  }
  
};
