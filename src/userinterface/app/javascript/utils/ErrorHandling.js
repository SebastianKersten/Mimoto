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
    this.createErrorElement();

  },

  setVariables: function () {

    this.errorParent = this.el.querySelector('.js-error-parent');
    this.iconElement = this.el.querySelector('.' + this.iconSelectorClass);
    this.useElement = this.iconElement.getElementsByTagName('use')[0];

  },

  // Global functions
  addIconClass: function (iconClass, icon) {

    this.iconElement.classList.add(iconClass);
    this.useElement.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', icon);

  },

  removeIconClass: function (iconClass) {

    this.el.querySelector('.' + this.iconSelectorClass).classList.remove(iconClass);

  },

  addElementClass: function (elementClass) {

    this.el.classList.add(elementClass);

  },

  removeElementClass: function (elementClass) {

    this.el.classList.remove(elementClass);

  },

  clearState: function () {

    var error = this.errorParent.querySelector('.' + this.classes[0]);

    if (error) {
      this.errorParent.removeChild(error);
    }

    if (this.el.classList.contains(this.errorClass)) {
      this.removeElementClass( this.errorClass);
    } else if (this.el.classList.contains(this.validatedClass)) {
      this.removeElementClass(this.validatedClass);
    }

    this.removeIconClass(this.iconErrorClass);
    this.removeIconClass(this.iconValidatedClass);

  },

  // Validated functions
  isValidated: function () {

    this.clearState();

    this.addElementClass(this.validatedClass);
    this.addIconClass(this.iconValidatedClass, this.validatedIcon);

  },

  // Error functions
  createErrorElement: function () {

    this.error = document.createElement(this.element);

    for (var i = 0; i < this.classes.length; i++) {

      this.error.classList.add(this.classes[i]);

    }

  },

  addError: function (message) {

    this.clearState();

    this.error.innerHTML = message;

    this.addElementClass(this.errorClass);
    this.addIconClass(this.iconErrorClass, this.errorIcon);
    this.errorParent.appendChild(this.error);

  }

};
