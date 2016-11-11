'use strict';

module.exports = function (element, options) {

  this.el = element;
  this.options = options;
  this.init();

};

module.exports.prototype = {

  init: function () {

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

    if (this.options.element) {
      this.element = this.options.element;
    }

    if (this.options.classes) {
      this.classes = this.options.classes;
    }

    if (this.options.iconSelectorClass) {
      this.iconSelectorClass = this.options.iconSelectorClass;
    }

    if (this.options.errorClass) {
      this.errorClass = this.options.errorClass;
    }

    if (this.options.iconErrorClass) {
      this.iconErrorClass = this.options.iconErrorClass;
    }

    if (this.options.validatedClass) {
      this.validatedClass = this.options.validatedClass;
    }

    if (this.options.iconValidatedClass) {
      this.iconValidatedClass = this.options.iconValidatedClass;
    }

    this.setVariables();

  },

  setVariables: function () {

    this.errorParent = this.el.querySelector('.js-error-parent');
    this.iconElement = this.el.querySelector('.' + this.iconSelectorClass);
    this.useElement = this.iconElement.getElementsByTagName('use')[0];

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

    if (this.el.classList.contains(this.errorClass)) {
      this.removeElementClass(this.errorClass);
    }

    this.removeErrorElement();
    this.removeIcon(this.iconErrorClass);
    this.hasError = false;

  },

  clearValidatedState: function () {

    if (this.el.classList.contains(this.validatedClass)) {
      this.removeElementClass(this.validatedClass);
    }

    this.removeIcon(this.iconValidatedClass);
    this.validated = false;

  },

  clearState: function () {

    this.clearErrorState();
    this.clearValidatedState();

  },

  // Validated functions
  addValidatedState: function () {

    this.clearErrorState();

    if (!this.validated) {
      this.addElementClass(this.validatedClass);
      this.addIcon(this.iconValidatedClass, this.validatedIcon);
      this.validated = true;
    }

  },

  // Error functions
  addErrorState: function (message) {

    this.clearValidatedState();

    if (!this.hasError) {
      this.addErrorElement(message);
      this.addElementClass(this.errorClass);
      this.addIcon(this.iconErrorClass, this.errorIcon);
      this.hasError = true;
    }

    if (this.message != message) {
      this.updateErrorElement(message);
      this.message = message;
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
