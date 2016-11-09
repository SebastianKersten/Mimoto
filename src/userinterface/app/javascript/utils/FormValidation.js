'use strict';

module.exports = {

  init: function () {

    console.log('Init Validation');

  },

  validateCheckbox: function (element) {

    console.log(element);
    this.el = element;

    this.checkIfChecked();

  },

  checkIfChecked: function () {

    var checkboxes = this.el.querySelectorAll('input');

    for (var i = 0; i < checkboxes.length; i++) {
      console.log(checkboxes[i].checked);
    }

  }

};
