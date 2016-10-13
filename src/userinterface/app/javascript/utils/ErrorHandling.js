'use strict';

module.exports = {

  init: function (options) {

    // Default options
    this.element = "p";
    this.classes = "error-message";
    this.validatedClass = "is-validated";
    this.errorClass = "has-error";
    this.iconSelectorClass = "icon";
    this.iconValidatedClass = "icon-validated";
    this.iconErrorClass = "icon-error";

    if (options.element) {
      this.element = options.element;
    }

    if (options.classes) {
      this.classes = options.classes;
    }

    if (options.iconSelectorClass) {
      this.iconSelectorClass = options.iconSelectorClass;
    }

    if (options.errorClass) {
      this.errorClass = options.errorClass;
    }

    if (options.iconErrorClass) {
      this.iconErrorClass = options.iconErrorClass;
    }

    if (options.validatedClass) {
      this.validatedClass = options.validatedClass;
    }

    if (options.iconValidatedClass) {
      this.iconValidatedClass = options.iconValidatedClass;
    }

    this.createErrorElement();

  },

  // Global functions
  addIconClass: function (element, iconClass) {

    element.querySelector('.' + this.iconSelectorClass).classList.add(iconClass);

  },

  removeIconClass: function (element, iconClass) {

    element.querySelector('.' + this.iconSelectorClass).classList.remove(iconClass);

  },

  addElementClass: function (element, elementClass) {

    element.classList.add(elementClass);

  },

  removeElementClass: function (element, elementClass) {

    element.classList.remove(elementClass);

  },

  clearState: function (element, parent) {

    var error = parent.querySelector('.' + this.classes[0]);

    if (error) {
      parent.removeChild(error);
    }

    if (element.classList.contains(this.errorClass)) {
      this.removeElementClass(element, this.errorClass);
    } else if (element.classList.contains(this.validatedClass)) {
      this.removeElementClass(element, this.validatedClass);
    }

    this.removeIconClass(element, this.iconErrorClass);
    this.removeIconClass(element, this.iconValidatedClass);

  },

  // Validated functions
  isValidated: function (element) {

    this.addElementClass(element, this.validatedClass);
    this.addIconClass(element, this.iconValidatedClass);

  },

  // Error functions
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

    this.addElementClass(element, this.errorClass);
    this.addIconClass(element, this.iconErrorClass);
    parent.appendChild(this.error);

  },

  removeError: function (parent, element) {

    var error = parent.querySelector('.' + this.classes[0]);

    this.removeElementClass(element, this.errorClass);
    this.removeIconClass(element, this.iconErrorClass);
    parent.removeChild(error);

  }

};
