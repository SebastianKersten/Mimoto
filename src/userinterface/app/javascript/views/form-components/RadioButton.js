'use strict';

module.exports = function (element) {

    this.el = element;
    this.init();

};

module.exports.prototype = {

    init: function () {

        console.log('Init Radio Button');

        this.setVariables();
        this.addEventListeners();

    },

    setVariables: function () {

        this.radioButtons = this.el.querySelectorAll('.js-radio-button');

    },

    addEventListeners: function () {

        for (var i = 0; i < this.radioButtons.length; i++) {

            this.radioButtons[i].addEventListener('change', function () {

                FV.validateInput(this.el);

            }.bind(this));

        }

    }

};
