'use strict';

module.exports = {

  init: function (options) {

    // Default options
    this.element = "p";
    this.classes = "error-message";
    this.errorClass = "error-class";
    this.iconClass = "icon";
    this.iconErrorClass = "icon-error";

    if (options.element) {
      this.element = options.element;
    }

    if (options.classes) {
      this.classes = options.classes;
    }

    if (options.errorClass) {
      this.errorClass = options.errorClass;
    }

    if (options.iconClass) {
      this.iconClass = options.iconClass;
    }

    if (options.iconErrorClass) {
      this.iconErrorClass = options.iconErrorClass;
    }

    this.createErrorElement();

  },

  createErrorElement: function () {

    this.error = document.createElement(this.element);
    this.addErrorElementClasses();

  },

  addErrorElementClasses: function () {

    for (var i = 0; i < this.classes.length; i++) {

      this.error.classList.add(this.classes[i]);

    }

  },

  addError: function (message, parent, element) {

    this.error.innerHTML = message;

    this.addErrorClass(element);
    this.addIconClass(element, this.iconErrorClass);
    parent.appendChild(this.error);

  },

  removeError: function (parent, element) {

    var error = parent.querySelector('.' + this.classes[0]);

    this.removeErrorClass(element);
    this.removeIconClass(element, this.iconErrorClass);
    parent.removeChild(error);

  },

  addErrorClass: function (element) {

    element.classList.add(this.errorClass);

  },

  removeErrorClass: function (element) {

    element.classList.remove(this.errorClass);

  },

  addIconClass: function (element, iconClass) {

    element.querySelector('.' + this.iconClass).classList.add(iconClass);

  },

  removeIconClass: function (element, iconClass) {

    element.querySelector('.' + this.iconClass).classList.remove(iconClass);

  }

};
