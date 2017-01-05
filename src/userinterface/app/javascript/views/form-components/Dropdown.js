'use strict';

module.exports = function (element) {

    this.el = element;
    this.init();

};

module.exports.prototype = {

    init: function () {

        console.log('Init Dropdown');

        this.setVariables();
        this.addEventListeners();

    },

    setVariables: function () {

        this.dropdown = this.el.querySelector('.js-dropdown');

    },

    addEventListeners: function () {

        this.dropdown.addEventListener('change', this.handleValidation.bind(this));

    },

    handleValidation: function () {

        var value = this.dropdown.value;

        if (value == '') {

            EH.clearState(this.el);

        } else {

            FV.validateInput(this.el);

        }

    }

};
