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

    //this.initErrorHandling();

  },


  setVariables: function () {

    this.validated = true;
    this.submit = this.el.querySelector('.js-form-submit');

  },

  addEventListeners: function () {

    this.submit.addEventListener('click', function () {

      this.submitForm();

    }.bind(this));

  },

  submitForm: function () {

    this.validateForm();

  },

  validateForm: function () {

    this.validated = true;
    this.getElements();

    if (this.validated) {
      this.el.submit();
    }

  },

  getElements: function () {

    var elements = this.el.querySelectorAll('.js-form-component');

    for (var i = 0; i < elements.length; i++) {

      this.validateElement(elements[i]);

    }

  },

  validateElement: function (element) {

    var type = element.querySelector('input').type;

    if (type == 'checkbox') {
      if (!FV.validateCheckbox(elements[i]).passed) this.validated = false;
    }

  }

};
