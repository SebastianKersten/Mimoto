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

    this.checkboxes = this.el.querySelectorAll('.js-checkbox');

  },

  addEventListeners: function () {

    for (var i = 0; i < this.checkboxes.length; i++) {

      this.checkboxes[i].addEventListener('change', function () {

        this.handleValidation();

      }.bind(this));

    }

  },

  handleValidation: function () {

    var checked = FV.countChecked(this.checkboxes);

    if (checked == 0) {

      EH.clearState(this.el);

    } else {

      FV.validateCheckbox(this.el);

    }

  }

};
