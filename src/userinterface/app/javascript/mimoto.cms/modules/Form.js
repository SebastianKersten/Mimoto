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
    open: function(sFormName, sAction, sMethod, bRealtimeCollaborationMode, responseSettings)
    {
        // store
        this._sCurrentOpenForm = sFormName;

        // setup
        var form = {
            'sName': sFormName,
            'sAction': sAction,
            'sMethod': sMethod,
            'aFields': [],
            'bRealtimeCollaborationMode': bRealtimeCollaborationMode,
            'responseSettings': JSON.parse(responseSettings)
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
            $field: $("[data-aimless-form-field='" + sInputFieldId + "']", $form),
            $input: $("[data-aimless-form-field-input='" + sInputFieldId + "']", $form),  // todo - multiselect x * option
            $error: $("[data-aimless-form-field-error='" + sInputFieldId + "']", $form)
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
        var aSubmitButtons = $('[data-aimless-form-submit="' + sFormName + '"]');

        // activate
        aSubmitButtons.each(function(nIndex, $component) {

            // read
            var currentForm = classRoot._aForms[classRoot._sCurrentOpenForm]; // #todo - validate if no form set

            // prepare
            if (!currentForm.aSubmitButtons) currentForm.aSubmitButtons = [];

            // register
            currentForm.aSubmitButtons.push($component);
            
            console.log('Submit register');
            
            
            // setup
            $($component).click(function() { console.log('Submit pressed'); classRoot.submit(sFormName); /*alert('Submit was auto connected!');*/ } );
        });


        // Mimoto.Aimless.privateChannel = Mimoto.Aimless.pusher.subscribe('private-' + 'AimlessForm_' + sFormName);
        //
        // Mimoto.Aimless.privateChannel.bind('client-Aimless:formfield_update_' + sFormName, function(data)
        // {
        //
        //     var $input = $("input[data-aimless-form-field-input='" + data.fieldId + "']");
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
    
        var nEntityId = '';
        var aEntityIds = $("input[name='Mimoto.EntityId']", $form);
        aEntityIds.each( function(index, $component) { nEntityId = $($component).val(); });
    
        // 6. read instructions
        var sOnCreatedConnectTo = '';
        var aOnCreatedConnectTo = $("input[name='Mimoto.onCreated:connectTo']", $form);
        aOnCreatedConnectTo.each( function(index, $component) { sOnCreatedConnectTo = $($component).val(); });
        
        // 7. collect data
        var aValues = {};
        var classRoot = this;
        var bValidated = true;
        for (var i = 0; i < nFieldCount; i++)
        {
            // 7a. register
            var field = aFields[i];
            
            
            // validate
            if (!classRoot._validateInputField(field)) { bValidated = false; continue; }
            
            
            var aInputFields = $("[data-aimless-form-field='" + field.sName + "']", $form);
    
            aInputFields.each( function(index, $inputField)
            {
                // 7b. find field
                var aInputs = $("[data-aimless-form-field-input='" + field.sName + "']", $inputField);
                
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
        
        
        //console.log('Before validated ..');
        // don't send if not validated
        if (!bValidated) return;
        //console.log('After validated ..');
        
        
        // 10. collect data
        var requestData = { publicKey: sPublicKey, entityId: nEntityId, values: aValues };
        if (sOnCreatedConnectTo) requestData.onCreatedConnectTo = sOnCreatedConnectTo;



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
                        var aFields = $('[data-aimless-form-field^="' + newEntity.selector + '"]', $form);
                        aFields.each( function(index, $component)
                        {
                            var mls_form_field = $($component).attr("data-aimless-form-field");
                            mls_form_field = newEntity.id + mls_form_field.substr(newEntity.selector.length);
                            $($component).attr("data-aimless-form-field", mls_form_field);
                        });

                        // update dom
                        var aFields = $('[data-aimless-form-field-input^="' + newEntity.selector + '"][name^="' + newEntity.selector + '"]', $form);
                        
                        aFields.each( function(index, $component)
                        {
                            var sOld_mls_form_field_input = $($component).attr("data-aimless-form-field-input");
                            var sNew_mls_form_field_input = newEntity.id + sOld_mls_form_field_input.substr(newEntity.selector.length);
                            $($component).attr("data-aimless-form-field-input", sNew_mls_form_field_input);

                            classRoot._alterRegisteredFieldId(resultData.formName, sOld_mls_form_field_input, sNew_mls_form_field_input);

                            var name = $($component).attr("name");
                            name = newEntity.id + name.substr(newEntity.selector.length);
                            $($component).attr("name", name);
                        });

                        // update dom
                        var aFields = $('[data-aimless-form-field-error^="' + newEntity.selector + '"]', $form);
                        aFields.each( function(index, $component)
                        {
                            var mls_form_field_error = $($component).attr("data-aimless-form-field-error");
                            mls_form_field_error = newEntity.id + mls_form_field_error.substr(newEntity.selector.length);
                            $($component).attr("data-aimless-form-field-error", mls_form_field_error);
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
                    
                    // cleanup instuctions
                    $("input[name='Mimoto.onCreated:addTo']", $form).remove();
                }
    
                if (resultData.newEntityId)
                {
                    // 6. read public key
                    var nEntityId = '';
                    var aEntityIds = $("input[name='Mimoto.EntityId']", $form);
                    aEntityIds.each( function(index, $component)
                    {
                        nEntityId = $($component).val(resultData.newEntityId);
                    });
        
                    // cleanup instuctions
                    $("input[name='Mimoto.onCreated:addTo']", $form).remove();
                }

                // 1. #todo get input field value in method
                // 2. collaborationMode
    
                
                if (form.responseSettings)
                {
                    if (form.responseSettings.onSuccess)
                    {
                        if (form.responseSettings.onSuccess.loadPage)
                        {
                            window.open(form.responseSettings.onSuccess.loadPage, '_self');
                        }
                        else if (form.responseSettings.onSuccess.closePopup)
                        {
                            Mimoto.popup.close();
                        }
                    }
                }
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
        
        //console.warn('value:');
        //console.warn(value);
        
        // send
        return value;
    },

    _setInputFieldValue: function($component, value) // #todo - implement
    {
        //console.log('value:');
        //console.error(value);
        
        
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
                field.$input = $("input[data-aimless-form-field-input='" + sNewInputFieldId + "']");

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
    
        field.$input.on('change', function(e)
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
    }

};
