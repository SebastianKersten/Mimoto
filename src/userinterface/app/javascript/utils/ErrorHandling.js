'use strict';

module.exports = {

  init: function (options) {

    // Default options
    this.element = "p";
    this.classes = "error-message";

    if (options.element) {
      this.element = options.element;
    }

    if (options.classes) {
      this.classes = options.classes;
    }

    if (options.errorClass) {
      this.errorClass = options.errorClass;
    }

    this.createErrorElement();

  },

  createErrorElement: function () {

    this.error = document.createElement(this.element);
    this.addClasses();

  },

  addClasses: function () {

    for (var i = 0; i < this.classes.length; i++) {

      this.error.classList.add(this.classes[i]);

    }

  },

  addError: function (message, parent, element) {

    this.error.innerHTML = message;

    element.classList.add(this.errorClass);
    parent.appendChild(this.error);

  },

  removeError: function (parent, element) {

    var error = parent.querySelector('.' + this.classes[0]);

    element.classList.remove(this.errorClass);
    parent.removeChild(error);

  }

};
