'use strict';

module.exports = function (element) {

    this.el = element;
    this.init();

};

module.exports.prototype = {

    init: function () {

        console.log('Init Textblock');

        this.setVariables();
        this.addEventListeners();

    },

    setVariables: function () {

        this.textblock = this.el.querySelector('.js-textblock');

    },

    addEventListeners: function () {

        this.textblock.addEventListener('keyup', this.handleValidation.bind(this));

    },

    handleValidation: function () {

        var value = this.textblock.value;

        if (value == '') {

            EH.clearState(this.el);

        } else {

            FV.validateInput(this.el);

        }

    }

};
