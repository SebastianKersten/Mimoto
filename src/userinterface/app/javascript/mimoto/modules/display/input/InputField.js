/**
 * Mimoto - InputField
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


module.exports = function(sFieldSelector, elInputField) {

    // start
    this.__construct(sFieldSelector, elInputField);
};

module.exports.prototype = {


    // form field directives
    DIRECTIVE_MIMOTO_FORM_FIELD_TYPE:  'data-mimoto-form-field-type',
    DIRECTIVE_MIMOTO_FORM_FIELD_INPUT: 'data-mimoto-form-field-input',
    DIRECTIVE_MIMOTO_FORM_FIELD_ERROR: 'data-mimoto-form-field-error',

    // settings
    _sType: null,
    _sFieldSelector: null,

    // elements
    _elInput: null,
    _elError: null,

    // state
    _bHasChanged: false,
    _bHasPendingChanges: false,



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


    _parseInputField: function(elInputField)
    {
        // register
        this._sType = elInputField.getAttribute(this.DIRECTIVE_MIMOTO_FORM_FIELD_TYPE);
        this._elInput = elInputField.querySelector('[' + this.DIRECTIVE_MIMOTO_FORM_FIELD_INPUT + ']');
        this._elError = elInputField.querySelector('[' + this.DIRECTIVE_MIMOTO_FORM_FIELD_ERROR + ']');


    },

    _connectInputField: function(field)
    {
        // register
        var classRoot = this;


        field.$input.on('input', function(e)
        {
            var form = field.sFormId;
            var sFormName = field.sFormId;
            var value = $(this).val();

            // Mimoto.Aimless.realtime.registerChange(sFormName, field.sName, value);

            // #todo change reference to sInputFieldId / addEventListener / removeEventListener

            classRoot._validateInputField(field);

            classRoot._startAutosave(form, field);
        });

        field.$input.on('change', function(e)
        {
            var form = field.sFormId;
            var sFormName = field.sFormId;
            var value = $(this).val();

            // Mimoto.Aimless.realtime.registerChange(sFormName, field.sName, value);

            // #todo change reference to sInputFieldId / addEventListener / removeEventListener

            classRoot._validateInputField(field);

            classRoot._startAutosave(form);
        });
    },




    _getValueFromInputField: function($component)
    {
        // init
        var value = null;

        // read type
        var sAimlessInputType = this._getInputFieldType($component);


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
