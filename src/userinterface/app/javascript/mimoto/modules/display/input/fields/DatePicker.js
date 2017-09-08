/**
 * Mimoto - DatePicker
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Chmln classes
var Flatpickr = require('flatpickr');


module.exports = function(sFieldSelector, elInputField) {

    // start
    this.__construct(sFieldSelector, elInputField);
};

module.exports.prototype = {




    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(sFieldSelector, elInputField)
    {
        // store
        this._sFieldSelector = sFieldSelector;

        // parse
        this._parseInputField(elInputField);
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    getValue: function()
    {

    },



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    setupDatePicker: function(sDatePickerId, sFlatDatePickerId, sInputFieldId) {
        // read
        var currentForm = this._aForms[this._sCurrentOpenForm];

        // validate
        if (!currentForm) return;

        // 1. locate form in dom
        var $form = $('form[name="' + currentForm.sName + '"]');

        // register
        var field = $('[data-mimoto-form-field="' + sInputFieldId + '"]', $form);
        var fieldInput = $("input", field);

        var jsClass = '.js-' + sFlatDatePickerId + '-date-picker';

        var datePicker = {
            sDatePickerId: sDatePickerId,
            field: field,
            datePickerInputElement: document.querySelector(jsClass + '-input'),
            currentValue: document.querySelector(jsClass + '-input').getAttribute('data-dp-value'),
            dateFormat: document.querySelector(jsClass + '-input').getAttribute('data-dp-format')
        }

        // store
        this._aDatePicker[sDatePickerId] = datePicker;

        new Flatpickr(this._aDatePicker[sDatePickerId].datePickerInputElement, {
            altInput: true,
            altFormat: this._aDatePicker[sDatePickerId].dateFormat,
            defaultDate: this._aDatePicker[sDatePickerId].currentValue,
            enableTime: true,
            dateFormat: 'Y-m-d H:i:S', // 2017-03-08 21:46:42
            // noCalendar: true, // only diplays time
            time_24hr: true,
            'static': true
        });
    },



}
