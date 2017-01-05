'use strict';

module.exports = function (element) {

    this.el = element;
    this.init();

};

module.exports.prototype = {

    init: function () {

        console.log('Init Textline');

        this.setVariables();
        this.addEventListeners();

    },

    setVariables: function () {

        this.textline = this.el.querySelector('.js-textline');

    },

    addEventListeners: function () {

        this.textline.addEventListener('keyup', this.handleValidation.bind(this));

    },

    handleValidation: function () {

        var value = this.textline.value;

        if (value == '') {

            EH.clearState(this.el);

        } else {

            FV.validateInput(this.el);

        }

    }

};
