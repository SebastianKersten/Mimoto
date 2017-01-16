'use strict';

var CheckboxView = require('./Checkbox');
var DropdownView = require('./Dropdown');
var ImageUploadView = require('./ImageUpload');
var RadioButtonView = require('./RadioButton');
var TextlineView = require('./Textline');
var TextblockView = require('./Textblock');

module.exports = function (element) {

    this.el = element;
    this.init();

};

module.exports.prototype = {

    init: function () {

        console.log('Init Form');

        this.setVariables();
        this.addEventListeners();

        this.initFormElements();

    },

    setVariables: function () {

        this.validated = true;
        this.submit = this.el.querySelector('.js-form-submit');
        this.elements = this.el.querySelectorAll('.js-form-component');

    },

    addEventListeners: function () {

        if (this.submit) this.submit.addEventListener('click', this.validateForm.bind(this));

        this.el.addEventListener('validate', this.validateForm.bind(this));

    },

    initFormElements: function () {

        for (var i = 0; i < this.elements.length; i++) {

            if (this.elements[i].classList.contains('js-form-component-textline')) {
                new TextlineView(this.elements[i]);
            } else if (this.elements[i].classList.contains('js-form-component-checkbox')) {
                new CheckboxView(this.elements[i]);
            } else if (this.elements[i].classList.contains('js-form-component-radio-button')) {
                new RadioButtonView(this.elements[i]);
            } else if (this.elements[i].classList.contains('js-form-component-dropdown')) {
                new DropdownView(this.elements[i]);
            } else if (this.elements[i].classList.contains('js-form-component-textblock')) {
                new TextblockView(this.elements[i]);
            } else if (this.elements[i].classList.contains('js-form-component-image')) {
                new ImageUploadView(this.elements[i]);
            }

        }

    },

    validateForm: function () {

        this.validated = true;
        this.validateElements();

        if (this.validated) this.el.submit();

    },

    validateElements: function () {

        for (var i = 0; i < this.elements.length; i++) {

            var result = FV.validateInput(this.elements[i]);

            if (!result.passed) this.validated = false;

            //var type = (this.elements[i].querySelector('input') || this.elements[i].querySelector('select')).type;
            //
            //if (type == 'checkbox') {
            //    this.handleCheckboxValidation(this.elements[i]);
            //} else if (type == 'text') {
            //    this.handleTextlineValidation(this.elements[i]);
            //} else if (type == 'radio') {
            //    this.handleRadioButtonValidation(this.elements[i]);
            //} else if (type == 'select-one') {
            //    this.handleDropdownValidation(this.elements[i]);
            //}

        }

    },

    handleCheckboxValidation: function (element) {

        var result = FV.validateInput(element);

        if (!result.passed) this.validated = false;

    },

    handleTextlineValidation: function (element) {

        var result = FV.validateInput(element);

        if (!result.passed) this.validated = false;

    },

    handleRadioButtonValidation: function (element) {

        var result = FV.validateInput(element);

        if (!result.passed) this.validated = false;

    },

    handleDropdownValidation: function (element) {

        var result = FV.validateInput(element);

        if (!result.passed) this.validated = false;

    }

};
