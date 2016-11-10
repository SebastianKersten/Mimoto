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
    this.errorIcon = "#ico-warning";
    this.validatedIcon = "#ico-checkmark";

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

  },

  setVariables: function (element) {

    this.el = element;

    this.errorParent = this.el.querySelector('.js-error-parent');
    this.iconElement = this.el.querySelector('.' + this.iconSelectorClass);
    this.useElement = this.iconElement.getElementsByTagName('use')[0];

    this.hasError = this.el.classList.contains(this.errorClass);
    this.isValidated = this.el.classList.contains(this.validatedClass);

  },

  // Adding/removing functions
  addIcon: function (iconClass, icon) {

    this.iconElement.classList.add(iconClass);
    this.useElement.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', icon);

  },

  addElementClass: function (elementClass) {

    this.el.classList.add(elementClass);

  },

  removeIcon: function (iconClass) {

    this.el.querySelector('.' + this.iconSelectorClass).classList.remove(iconClass);

  },

  removeElementClass: function (elementClass) {

    this.el.classList.remove(elementClass);

  },

  // State functions
  clearErrorState: function () {

    if (this.hasError) {
      this.removeElementClass(this.errorClass);
      this.removeErrorElement();
      this.removeIcon(this.iconErrorClass);
    }

  },

  clearValidatedState: function () {

    if (this.isValidated) {
      this.removeElementClass(this.validatedClass);
      this.removeIcon(this.iconValidatedClass);
    }

  },

  clearState: function (element) {

    this.setVariables(element);
    this.clearErrorState();
    this.clearValidatedState();

  },

  // Validated functions
  addValidatedState: function (element) {

    this.setVariables(element);
    this.clearErrorState();

    if (!this.isValidated) {
      this.addElementClass(this.validatedClass);
      this.addIcon(this.iconValidatedClass, this.validatedIcon);
    }

  },

  // Error functions
  addErrorState: function (element, message) {

    this.setVariables(element);
    this.clearValidatedState();

    if (!this.hasError) {
      this.addErrorElement(message);
      this.addElementClass(this.errorClass);
      this.addIcon(this.iconErrorClass, this.errorIcon);
    } else {
      this.updateErrorElement(message);
    }

  },

  addErrorElement: function (message) {

    var error = document.createElement(this.element);

    for (var i = 0; i < this.classes.length; i++) {

      error.classList.add(this.classes[i]);

    }

    error.innerHTML = message;
    this.errorParent.appendChild(error);

  },

  removeErrorElement: function () {

    var error = this.errorParent.querySelector('.' + this.classes[0]);

    if (error) {
      this.errorParent.removeChild(error);
    }

  },

  updateErrorElement: function (message) {

    var error = this.errorParent.querySelector('.' + this.classes[0]);
    error.innerHTML = message;

  }

};
