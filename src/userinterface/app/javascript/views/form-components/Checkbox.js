'use strict';

module.exports = function (element) {

  this.el = element;
  this.init();

};

module.exports.prototype = {

  init: function () {

    console.log('Init Checkbox');

    this.setVariables();
    this.addEventListeners();

  },

  setVariables: function () {

    this.checkboxes = this.el.querySelectorAll('.js-form-checkbox');
    this.checked = 0;

  },

  addEventListeners: function () {

    for (var i = 0; i < this.checkboxes.length; i++) {

      this.checkboxes[i].addEventListener('change', function () {

        this.handleValidation();

      }.bind(this));

    }

  },

  handleValidation: function () {

    this.countChecked();

    if (this.checked == 0) {

      EH.clearState(this.el);

    } else {

      var validated = FV.validateCheckbox(this.el);

      if (validated.passed) {

        EH.addValidatedState(this.el);

      } else {

        EH.addErrorState(this.el, validated.message);

      }

    }

  },

  countChecked: function () {

    this.checked = 0;

    for (var i = 0; i < this.checkboxes.length; i++) {
      if (this.checkboxes[i].checked) {
        this.checked++;
      }
    }

  }

};
