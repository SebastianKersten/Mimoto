/**
 * Mimoto - InputField - ColorPicker
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Chmln classes
var Flatpickr = require('flatpickr');


module.exports = function(elFormField, fBroadcast, aInputElements) {

    // start
    this.__construct(elFormField, fBroadcast, aInputElements);
};

module.exports.prototype = {

    // dom
    _elFormField: null,
    _fBroadcast: null,
    _aInputElements: null,

    // elements
    _elColorPickerPreview: null,

    // utils
    _datePicker: null,



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(elFormField, fBroadcast, elInput)
    {
        // store
        this._elFormField = elFormField;
        this._fBroadcast = fBroadcast;
        this._elInput = elInput;

        // register
        this._elDatePicker = elFormField.querySelector('[data-mimoto-form-input-datepicker]');

        this._datePicker = new Flatpickr(this._elDatePicker, {
            altInput: true,
            altFormat: this._elDatePicker.getAttribute('data-dp-format'),
            defaultDate: this._elDatePicker.getAttribute('data-dp-value'),
            enableTime: true,
            dateFormat: 'Y-m-d H:i:S', // 2017-03-08 21:46:42
            // noCalendar: true, // only diplays time
            time_24hr: true,
            'static': true
        });

        // configure
        this._elInput.addEventListener('input', function(e) { this._correctColorValue(); }.bind(this));
        this._elInput.addEventListener('change', function(e) { this._correctColorValue(); }.bind(this));
    },




    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    getValue: function()
    {
        // send
        return this._elInput.value;
    },

    setValue: function(value, bDontBroadcastOnInitialSet)
    {
        // update
        this._elInput.value = value;

        // broadcast
        if (!bDontBroadcastOnInitialSet) this._fBroadcast();
    }


}
