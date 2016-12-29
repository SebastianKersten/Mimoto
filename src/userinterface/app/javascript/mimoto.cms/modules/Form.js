/**
 * Mimoto.CMS - Form handling
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


module.exports = function() {

    // start
    this.__construct();
};

module.exports.prototype = {



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function()
    {
        // init
        this._aForms = [];
        this._sCurrentOpenForm = '';
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Open new form
     */
    open: function(sFormName, sAction, sMethod, bRealtimeCollaborationMode)
    {
        // store
        this._sCurrentOpenForm = sFormName;

        // setup
        var form = {
            'sName': sFormName,
            'sAction': sAction,
            'sMethod': sMethod,
            'aFields': [],
            'bRealtimeCollaborationMode': bRealtimeCollaborationMode
        };

        // register
        this._aForms[sFormName] = form;
    },

    /**
     * Register input field
     */
    registerInputField: function(sInputFieldId, settings)
    {
        // read
        var currentForm = this._aForms[this._sCurrentOpenForm]; // #todo - validate if no form set

        // 1. locate form in dom
        var $form = $('form[name="' + currentForm.sName + '"]');

        // setup
        var field = {
            'sFormId': currentForm,
            'sName': sInputFieldId,
            'sType': 'input', // #todo - const
            'settings': settings,
            $field: $("[mls_form_field='" + sInputFieldId + "']", $form),
            $input: $("input[mls_form_field_input='" + sInputFieldId + "']", $form),
            $error: $("[mls_form_field_error='" + sInputFieldId + "']", $form)
        };

        // store
        currentForm.aFields.push(field);

        // store
        // Mimoto.Aimless.realtime.broadcastedValues[sInputFieldId] = {
        //     sFormName: currentForm.sFormName,
        //     value: $(field.$input).val()
        // };

        // connect
        this._connectInputField(field);
    },

    /**
     * Unregister input field
     */
    unregisterInputField: function(sInputFieldId)
    {

    },

    /**
     * Close form
     */
    close: function(sFormName)
    {
        // register
        var classRoot = this;

        // search
        var aSubmitButtons = $('[mls_form_submit="' + sFormName + '"]');

        // activate
        aSubmitButtons.each(function(nIndex, $component) {

            // read
            var currentForm = classRoot._aForms[classRoot._sCurrentOpenForm]; // #todo - validate if no form set

            // prepare
            if (!currentForm.aSubmitButtons) currentForm.aSubmitButtons = [];

            // register
            currentForm.aSubmitButtons.push($component);

            // setup
            $($component).click(function() { classRoot.submit(sFormName); /*alert('Submit was auto connected!');*/ } );
        });


        // Mimoto.Aimless.privateChannel = Mimoto.Aimless.pusher.subscribe('private-' + 'AimlessForm_' + sFormName);
        //
        // Mimoto.Aimless.privateChannel.bind('client-Aimless:formfield_update_' + sFormName, function(data)
        // {
        //
        //     var $input = $("input[mls_form_field_input='" + data.fieldId + "']");
        //
        //
        //     // 1. check if supports realtime
        //     // 2. get this text
        //     // 3. get diff patch
        //
        //
        //     console.log(Mimoto.Aimless.pusher);
        //
        //     var currentValue = $($input).val();
        //     var patches = Mimoto.Aimless.realtime.dmp.patch_fromText(data.diff);
        //
        //     //var ms_start = (new Date).getTime();
        //     var results = Mimoto.Aimless.realtime.dmp.patch_apply(patches, currentValue);
        //     //var ms_end = (new Date).getTime();
        //
        //
        //     Mimoto.Aimless.realtime.broadcastedValues[data.fieldId].value = results[0];
        //     $($input).val(results[0]);
        // });
    },

    /**
     * Submit form
     */
    submit: function(sFormName)
    {
        // 1. validate
        if (!this._aForms) return;

        // 2. set default is no specific form requested
        if (!sFormName) { for (var s in this._aForms) { sFormName = s; break; } }

        // 3. validate
        if (!this._aForms[sFormName]) return;

        // 4. register
        var form = this._aForms[sFormName];
        var aFields = form.aFields;
        var nFieldCount = aFields.length;

        // 5. locate form in dom
        var $form = $('form[name="' + sFormName + '"]');

        // 6. read public key
        var sPublicKey = '';
        var aPublicKeys = $("input[name='Mimoto.PublicKey']", $form);
        aPublicKeys.each( function(index, $component) { sPublicKey = $($component).val(); });
    
        // 6. read instructions
        var sOnCreatedAddTo = '';
        var aOnCreatedAddTo = $("input[name='Mimoto.onCreated:addTo']", $form);
        aOnCreatedAddTo.each( function(index, $component) { sOnCreatedAddTo = $($component).val(); });
        
        // 7. collect data
        var aValues = {};
        var classRoot = this;
        for (var i = 0; i < nFieldCount; i++)
        {
            // 7a. register
            var field = aFields[i];
            
            var aInputFields = $("[mls_form_field='" + field.sName + "']", $form);
    
            aInputFields.each( function(index, $inputField)
            {
                // 7b. find field
                var aInputs = $("[mls_form_field_input='" + field.sName + "']", $inputField);
                
                if (aInputs.length > 1 && ($(aInputs[0]).is("input")) && $(aInputs[0]).attr('type') == 'checkbox')
                {
                    // init
                    aValues[field.sName] = [];
        
                    // 7c. collect value
                    aInputs.each( function(index, $input)
                    {
                        // init
                        var value = classRoot._getValueFromInputField($input);
            
                        // store
                        if (value !== null) aValues[field.sName].push(value);
                    });
                }
                else
                {
                    // 7c. collect value
                    aInputs.each( function(index, $input)
                    {
                        // init
                        var value = classRoot._getValueFromInputField($input);
        
                        // store
                        if (value !== null) aValues[field.sName] = value;
                    });
                }
                
            });
        }
    
        
        
        // 10. collect data
        var requestData = { publicKey: sPublicKey, values: aValues };
        if (sOnCreatedAddTo) requestData.onCreatedAddTo = sOnCreatedAddTo;



        // console.log('Sending ' + form.sAction + ' ' + form.sMethod);
        // console.log(aValues);
        // console.error(requestData);
        // console.log('------');
    
        
        // 11. send data
        $.ajax({
            type: form.sMethod,
            url: form.sAction,
            data: JSON.stringify(requestData),
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething)
            {
                
                if (resultData.newEntities)
                {

                    for (var sEntityType in resultData.newEntities)
                    {
                        var newEntity = resultData.newEntities[sEntityType];

                        // 1. locate form in dom
                        var $form = $('form[name="' + resultData.formName + '"]');


                        // update dom
                        var aFields = $('[mls_form_field^="' + newEntity.selector + '"]', $form);
                        aFields.each( function(index, $component)
                        {
                            var mls_form_field = $($component).attr("mls_form_field");
                            mls_form_field = newEntity.id + mls_form_field.substr(newEntity.selector.length);
                            $($component).attr("mls_form_field", mls_form_field);
                        });

                        // update dom
                        var aFields = $('[mls_form_field_input^="' + newEntity.selector + '"][name^="' + newEntity.selector + '"]', $form);
                        
                        aFields.each( function(index, $component)
                        {
                            var sOld_mls_form_field_input = $($component).attr("mls_form_field_input");
                            var sNew_mls_form_field_input = newEntity.id + sOld_mls_form_field_input.substr(newEntity.selector.length);
                            $($component).attr("mls_form_field_input", sNew_mls_form_field_input);

                            classRoot._alterRegisteredFieldId(resultData.formName, sOld_mls_form_field_input, sNew_mls_form_field_input);

                            var name = $($component).attr("name");
                            name = newEntity.id + name.substr(newEntity.selector.length);
                            $($component).attr("name", name);
                        });

                        // update dom
                        var aFields = $('[mls_form_field_error^="' + newEntity.selector + '"]', $form);
                        aFields.each( function(index, $component)
                        {
                            var mls_form_field_error = $($component).attr("mls_form_field_error");
                            mls_form_field_error = newEntity.id + mls_form_field_error.substr(newEntity.selector.length);
                            $($component).attr("mls_form_field_error", mls_form_field_error);
                        });
                    }
                }

                if (resultData.newPublicKey)
                {
                    // 6. read public key
                    var sPublicKey = '';
                    var aPublicKeys = $("input[name='Mimoto.PublicKey']", $form);
                    aPublicKeys.each( function(index, $component)
                    {
                        sPublicKey = $($component).val(resultData.newPublicKey);
                    });
                    
                    // cleanup instructions
                    $("input[name='Mimoto.onCreated:addTo']", $form).remove();
                }

                // 1. #todo get input field value in method
                // 2. collaborationMode
                
                
                Mimoto.popup.close();

            }
        });

    },



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    _getValueFromInputField: function($component)
    {
        // init
        var value = null;

        // validate
        if ($($component).is("input"))
        {
            switch($($component).attr('type'))
            {
                case 'radio':

                    if ($($component).prop("checked") === true) {
                        value = $($component).val();
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
        };

        if ($($component).is("select"))
        {
            value = $($component).val();
        }

        // send
        return value;
    },

    _setInputFieldValue: function($component, value) // #todo - implement
    {
        if ($($component).is("input"))
        {
            switch($($component).attr('type'))
            {
                case 'radio':

                    // output
                    $($component).each( function(nIndex, $component)
                    {
                        $($component).prop('checked', $($component).val() == change.value);
                    });
                    break;
    
                case 'checkbox':
        
                    // output
                    $($component).each( function(nIndex, $component)
                    {
                        $($component).prop('checked', $($component).val() == change.value);
                    });
                    break;
                
                default:

                    // output
                    $($component).val(value);
            }
        };
    },

    _alterRegisteredFieldId: function(sFormName, sOldInputFieldId, sNewInputFieldId)
    {
        var form = this._aForms[sFormName];

        var nFieldCount = form.aFields.length;
        for (var i = 0; i < nFieldCount; i++)
        {
            // register
            var field = form.aFields[i];

            if (field.sName == sOldInputFieldId)
            {
                field.$input.off('input');

                field.sName = sNewInputFieldId;
                field.$input = $("input[mls_form_field_input='" + sNewInputFieldId + "']");

                // store
                // Mimoto.Aimless.realtime.broadcastedValues[sNewInputFieldId] = Mimoto.Aimless.realtime.broadcastedValues[sOldInputFieldId];
                // delete Mimoto.Aimless.realtime.broadcastedValues[sOldInputFieldId];

                this._connectInputField(field);
            }
        }
    },

    _connectInputField: function(field)
    {
        // register
        var classRoot = this;


        field.$input.on('input', function(e)
        {
            var sFormName = field.sFormId;
            var value = $(this).val();

            // Mimoto.Aimless.realtime.registerChange(sFormName, field.sName, value);

            // #todo change reference to sInputFieldId / addEventListener / removeEventListener

            classRoot._validateInputField(field);

        });
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

            switch(validationRule.key)
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
                    var patt = new RegExp(validationRule.value);

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

    }


};
