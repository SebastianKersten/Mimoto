'use strict';

module.exports = {

  init: function (options) {

    // Default options
    this.errorElement = "p";
    this.errorElementClasses = "error-message";
    this.iconSelectorClass = "icon";
    this.validatedClass = "is-validated";
    this.validatedIcon = "#ico-validated";
    this.validatedIconClass = "icon-validated";
    this.errorClass = "has-error";
    this.errorIcon = "#ico-error";
    this.errorIconClass = "icon-error";

    if (options.errorElement) {
      this.errorElement = options.errorElement;
    }

    if (options.errorElementClasses) {
      this.errorElementClasses = options.errorElementClasses;
    }

    if (options.iconSelectorClass) {
      this.iconSelectorClass = options.iconSelectorClass;
    }

    if (options.validatedClass) {
      this.validatedClass = options.validatedClass;
    }

    if (options.validatedIcon) {
      this.validatedIcon = options.validatedIcon;
    }

    if (options.validatedIconClass) {
      this.validatedIconClass = options.validatedIconClass;
    }

    if (options.errorClass) {
      this.errorClass = options.errorClass;
    }

    if (options.errorIcon) {
      this.errorIcon = options.errorIcon;
    }

    if (options.errorIconClass) {
      this.errorIconClass = options.errorIconClass;
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
      this.removeIcon(this.errorIconClass);
    }

  },

  clearValidatedState: function () {

    if (this.isValidated) {
      this.removeElementClass(this.validatedClass);
      this.removeIcon(this.validatedIconClass);
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
      this.addIcon(this.validatedIconClass, this.validatedIcon);
    }

  },

  // Error functions
  addErrorState: function (element, message) {

    this.setVariables(element);
    this.clearValidatedState();

    if (!this.hasError) {
      this.addErrorElement(message);
      this.addElementClass(this.errorClass);
      this.addIcon(this.errorIconClass, this.errorIcon);
    } else {
      this.updateErrorElement(message);
    }

  },

  addErrorElement: function (message) {

    var error = document.createElement(this.errorElement);

    for (var i = 0; i < this.errorElementClasses.length; i++) {

      error.classList.add(this.errorElementClasses[i]);

    }

    error.innerHTML = message;
    this.errorParent.appendChild(error);

  },

  removeErrorElement: function () {

    var error = this.errorParent.querySelector('.' + this.errorElementClasses[0]);

    if (error) {
      this.errorParent.removeChild(error);
    }

  },

  updateErrorElement: function (message) {

    var error = this.errorParent.querySelector('.' + this.errorElementClasses[0]);
    error.innerHTML = message;

  }

};
