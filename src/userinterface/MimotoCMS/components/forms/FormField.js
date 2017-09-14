/**
 * Mimoto - FormField
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Mimoto input classes
let Textline = require('./input/Textline/Textline');
let Radiobutton = require('./input/Radiobutton/Radiobutton');
let Checkbox = require('./input/Checkbox/Checkbox');
let MultiSelect = require('./input/MultiSelect/MultiSelect');
let Image = require('./input/Image/Image');
let Dropdown = require('./input/Dropdown/Dropdown');
let Video = require('./input/Video/Video');
let ColorPicker = require('./input/ColorPicker/ColorPicker');
let DatePicker = require('./input/DatePicker/DatePicker');


module.exports = function(elFormField) {

    // start
    this.__construct(elFormField);
};

module.exports.prototype = {


    // form field directives
    DIRECTIVE_MIMOTO_FORM_FIELD_VALUE:      'data-mimoto-form-field-value',
    DIRECTIVE_MIMOTO_FORM_FIELD_TYPE:       'data-mimoto-form-field-type',
    DIRECTIVE_MIMOTO_FORM_FIELD_INPUT:      'data-mimoto-form-field-input',
    DIRECTIVE_MIMOTO_FORM_FIELD_ERROR:      'data-mimoto-form-field-error',
    DIRECTIVE_MIMOTO_FORM_FIELD_VALIDATION: 'data-mimoto-form-field-validation',

    // settings
    _sType: null,
    _elFormField: null,

    // elements
    _aInputElements: null,
    _elError: null,
    _aValidationRules: [],

    // state
    _bHasChanges: false,
    _bHasPendingChanges: false,

    _persistentValue: null,
    _pendingValue: null,

    _coreInputFields: {
        '_Mimoto_form_input_textline': Textline,
        '_Mimoto_form_input_radiobutton': Radiobutton,
        '_Mimoto_form_input_checkbox': Checkbox,
        '_Mimoto_form_input_multiselect': MultiSelect,
        '_Mimoto_form_input_image': Image,
        '_Mimoto_form_input_dropdown': Dropdown,
        '_Mimoto_form_input_video': Video,
        '_Mimoto_form_input_colorpicker': ColorPicker,
        '_Mimoto_form_input_datepicker': DatePicker
    },



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(elFormField)
    {
        // store
        this._elFormField = elFormField;

        // parse
        this._parseFormField(elFormField);
    },



    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------


    getFieldValue: function()
    {
        return this._elFormField.getAttribute(this.DIRECTIVE_MIMOTO_FORM_FIELD_VALUE);
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    hasChanges: function()
    {
        return this._bHasChanges;
    },

    getChanges: function()
    {
        // copy
        this._pendingValue = this._input.getValue();
        this._bHasPendingChanges = true;

        // toggle
        this._bHasChanges = false;

        // send
        return this._pendingValue;
    },

    acceptChanges: function()
    {
        // verify
        if (this._bHasPendingChanges)
        {
            // accept
            this._persistentValue = this._pendingValue;
            this._pendingValue = null;

            // toggle
            this._bHasPendingChanges = false;
        }

        // broadcast
        if (this._bHasChanges) this._broadcastChanges();
    },

    updatePropertySelector: function(sOldSelector, sNewSelector)
    {
        // collect
        let aElements = [
            { el: this._elFormField, attr: this.DIRECTIVE_MIMOTO_FORM_FIELD_VALUE },
        ];

        // configure
        let nInputElementCount = this._aInputElements.length;
        for (let nInputElementIndex = 0; nInputElementIndex < nInputElementCount; nInputElementIndex++)
        {
            // register
            let elInput = this._aInputElements[nInputElementIndex];

            // register
            aElements.push({ el: elInput, attr: this.DIRECTIVE_MIMOTO_FORM_FIELD_INPUT });
            aElements.push({ el: elInput, attr: 'name' });
        }


        // swap
        let nElementCount = aElements.length;
        for (let nElementIndex = 0; nElementIndex < nElementCount; nElementIndex++)
        {
            // register
            let element = aElements[nElementIndex];

            // read
            let sCurrentSelector = element.el.getAttribute(element.attr);

            // compare
            if (sCurrentSelector.substr(0, sOldSelector.length) === sOldSelector)
            {
                // update
                element.el.setAttribute(element.attr, sNewSelector + sCurrentSelector.substr(sOldSelector.length));
            }
        }
    },



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    _parseFormField: function(elFormField)
    {
        // 1. register
        this._sType = elFormField.getAttribute(this.DIRECTIVE_MIMOTO_FORM_FIELD_TYPE);
        this._elError = elFormField.querySelector('[' + this.DIRECTIVE_MIMOTO_FORM_FIELD_ERROR + ']');

        // 2. collect
        this._aInputElements= elFormField.querySelectorAll('[' + this.DIRECTIVE_MIMOTO_FORM_FIELD_INPUT + ']');

        // 3. setup
        let fBroadcast = function(e) { elFormField.dispatchEvent(new Event('onMimotoInputChanged')); }.bind(this);

        // 4. configure
        elFormField.addEventListener('onMimotoInputChanged', function(e) { this._handleInputChange(); }.bind(this));

        // 5. prepare
        let aInputElements = (this._aInputElements.length !== 1) ? this._aInputElements : this._aInputElements[0];

        // 6. init
        if (this._coreInputFields[this._sType])
        {
            // register
            let CoreInputField = this._coreInputFields[this._sType];

            // init
            this._input = new CoreInputField(elFormField, fBroadcast, aInputElements);
        }
        // else if (Mimoto.inputFields([this._sType]))
        // {
        //     // 1. check if any custom field registered in root
        // }
        // else
        // {
        //     // 2. if not, try based in Mimoto.input and Mimoto.value (generalInput)
        // }


        // TEMP
        if (!this._input) return;


        // 7. store initial value
        this._persistentValue = this._input.getValue();

        // 8. setup validation
        if (elFormField.hasAttribute(this.DIRECTIVE_MIMOTO_FORM_FIELD_VALIDATION))
        {
            // a. register
            this._aValidationRules = JSON.parse(elFormField.getAttribute(this.DIRECTIVE_MIMOTO_FORM_FIELD_VALIDATION));
        }
    },

    _handleInputChange: function()
    {
        Mimoto.log('Changed from', this._persistentValue, 'to', this._input.getValue());


        // 1. validate
        if (this._aValidationRules.length > 0 && !this._validateInputField()) return;

        // 2. register
        let testValue = this._input.getValue();

        // 3. filter on actual change or changes pending
        if (this._bHasPendingChanges && testValue === this._pendingValue) return;
        if (!this._bHasPendingChanges && testValue === this._persistentValue) return;

        // 4. toggle
        this._bHasChanges = true;

        // 5. broadcast
        this._broadcastChanges();
    },

    _broadcastChanges: function()
    {
        // broadcast
        this._elFormField.dispatchEvent(new Event('onMimotoFormfieldChanged'));
    },

    _validateInputField: function()
    {
        // init
        let sErrorMessage = '';

        // check rules
        let nValidationRuleCount = this._aValidationRules.length;
        let bValid = true;
        for (let nValidationRuleIndex = 0; nValidationRuleIndex < nValidationRuleCount; nValidationRuleIndex++)
        {
            // register
            let validationRule = this._aValidationRules[nValidationRuleIndex];

            // read
            let value = this._input.getValue();

            // compare
            switch(validationRule.type)
            {
                case 'maxchars':

                    // validate
                    if (value.length > validationRule.value)
                    {
                        sErrorMessage = validationRule.errorMessage;
                        bValid = false;
                    }
                    break;

                case 'minchars':

                    // validate
                    if (value.length < validationRule.value)
                    {
                        sErrorMessage = validationRule.errorMessage;
                        bValid = false;
                    }
                    break;

                case 'regex_custom':

                    // init
                    let patt = new RegExp(validationRule.value, "g");

                    // validate
                    if (!patt.test(value))
                    {
                        sErrorMessage = validationRule.errorMessage;
                        bValid = false;
                    }
                    break;
            }

            if (!bValid) break;
        }

        // update interface
        if (this._elError)
        {
            if (sErrorMessage)
            {
                this._elError.innerHTML = sErrorMessage;
                // #todo toggle field icon - zie code David
            }
            else
            {
                this._elError.innerHTML = '';
            }
        }

        // send
        return bValid;
    }

}
