/**
 * Mimoto - FormField
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


module.exports = function(elFormField) {

    // events
    this.CHANGED = 'changed';

    // start
    this.__construct(elFormField);
};

module.exports.prototype = {


    // form field directives
    DIRECTIVE_MIMOTO_FORM_FIELD_VALUE: 'data-mimoto-form-field-value',
    DIRECTIVE_MIMOTO_FORM_FIELD_TYPE:  'data-mimoto-form-field-type',
    DIRECTIVE_MIMOTO_FORM_FIELD_INPUT: 'data-mimoto-form-field-input',
    DIRECTIVE_MIMOTO_FORM_FIELD_ERROR: 'data-mimoto-form-field-error',

    // settings
    _sType: null,
    _elFormField: null,

    // elements
    _elInput: null,
    _elError: null,

    // state
    _bHasChanges: false,
    _bHasPendingChanges: false,

    _persistantValue: null,
    _currentValue: null,
    _pendingValue: null,



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
        this._pendingValue = this._currentValue;
        this._bHasPendingChanges = true;

        // toggle
        this._bHasChanges = false;

        // send
        return this._pendingValue;
    },

    acceptChanges: function()
    {
        Mimoto.log('acceptChanges');
        // verify
        if (this._bHasPendingChanges)
        {
            Mimoto.log('Has pending changes');
            // accept
            this._persistantValue = this._pendingValue;
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
            { el: this._elInput, attr: this.DIRECTIVE_MIMOTO_FORM_FIELD_INPUT },
            { el: this._elInput, attr: 'name' }
        ];

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
        // register
        this._sType = elFormField.getAttribute(this.DIRECTIVE_MIMOTO_FORM_FIELD_TYPE);
        this._elInput = elFormField.querySelector('[' + this.DIRECTIVE_MIMOTO_FORM_FIELD_INPUT + ']');
        this._elError = elFormField.querySelector('[' + this.DIRECTIVE_MIMOTO_FORM_FIELD_ERROR + ']');

        // store
        this._persistantValue = this._getValueFromInputField(this._elInput);
        this._currentValue = this._persistantValue;

        // register
        let classRoot = this;

        // configure
        this._elInput.addEventListener('input', function (e) { classRoot._handleInputChange(this.value); });
        this._elInput.addEventListener('change', function(e) { classRoot._handleInputChange(this.value); });
    },

    _handleInputChange: function(value)
    {
        Mimoto.log('Changed from', this._persistantValue, 'to', value);


        //if (_validateValue(value));
        //classRoot._validateInputField(field);


        // this.pendingValue - persistValue


        // 1. verify
        if (value !== this._currentValue)
        {
            // a. update
            this._currentValue = value;

            // b. broadcast
            this._broadcastChanges();
        }
        else
        {
            // toggle
            this._bHasChanges = false;
        }


    },

    _broadcastChanges: function()
    {
        // toggle
        this._bHasChanges = true;

        // broadcast
        this._elFormField.dispatchEvent(new Event(this.CHANGED));
    },


    _getValueFromInputField: function(elInput)
    {
        // init
        let value = null;



        return elInput.value;


        // read type
        var sAimlessInputType = 'xxx'; //this._getInputFieldType($component);


        switch(sAimlessInputType)
        {
            case 'list':

                value = JSON.parse($($component).val());
                break;

            default:

                // validate
                if ($($component).is("input"))
                {
                    switch($($component).attr('type'))
                    {
                        case 'radio':

                            //  fix for handling radiobutton onSubmit en onChange
                            if ($component.length)
                            {
                                var aComponents = $component;

                                // collect value
                                aComponents.each( function(index, $component)
                                {
                                    if ($($component).prop("checked") === true)
                                    {
                                        value = $($component).val();
                                    }
                                });
                            }
                            else
                            {
                                if ($($component).prop("checked") === true)
                                {
                                    value = $($component).val();
                                }
                            }

                            break;

                        case 'checkbox':

                            if ($($component).attr('value'))
                            {
                                if ($($component).prop("checked") === true)
                                {
                                    value = $($component).val();
                                }
                            }
                            else
                            {
                                value = $($component).prop("checked");
                            }

                            break;

                        default:

                            value = $($component).val();
                    }
                }

                if ($($component).is("select"))
                {
                    value = $($component).val();
                }

                if ($($component).is("textarea"))
                {
                    value = $($component).val();
                }

                break;
        }

        // send
        return value;
    },

    _setInputFieldValue: function($component, value) // #todo - implement
    {
        //console.log('value:');



        if ($($component).is("input"))
        {
            switch($($component).attr('type'))
            {
                case 'radio':

                    // output
                    $($component).each( function(nIndex, $component)
                    {
                        $($component).prop('checked', $($component).val() == value);
                    });
                    break;

                case 'checkbox':

                    // output
                    $($component).each( function(nIndex, $component)
                    {
                        $($component).prop('checked', value);
                    });
                    break;

                default:

                    // output
                    $($component).val(value);
            }
        };

        if ($($component).is("select"))
        {
            $($component).val(value);
        }

        if ($($component).is("textarea"))
        {
            // output
            $($component).val(value);
        }
    },

    _validateInputField: function(field)
    {
        // validae
        if (!field.settings) return;
        if (!field.settings.validation) return;

        // init
        var sErrorMessage = '';

        // check rules
        var nValidationRuleCount = field.settings.validation.length;
        var bValid = true;
        for (var i = 0; i < nValidationRuleCount; i++)
        {
            // register
            var validationRule = field.settings.validation[i];

            // read
            var value = this._getValueFromInputField(field.$input);

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
                    var patt = new RegExp(validationRule.value, "g");

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
        if (field.$error)
        {
            if (sErrorMessage)
            {
                field.$error.text(sErrorMessage);
                // #todo toggle field icon - zie code David
            }
            else
            {
                field.$error.text('');
            }
        }

        // send
        return bValid;
    },


}
