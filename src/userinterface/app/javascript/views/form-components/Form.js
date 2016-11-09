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

    this.validated = false;
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

    this.getElements();

  },

  getElements: function () {

    var elements = this.el.querySelectorAll('.js-form-component');
    console.log(elements);

    for (var i = 0; i < elements.length; i++) {

      var type = elements[i].querySelector('input').type;

      if (type == 'checkbox') {
        this.checkIfChecked(elements[i]);
      }
    }

  },

  checkIfChecked: function (parent) {

    var checkboxes = parent.querySelectorAll('input');

    for (var i = 0; i < checkboxes.length; i++) {
      console.log(checkboxes[i].checked);
    }

  }
  
};
