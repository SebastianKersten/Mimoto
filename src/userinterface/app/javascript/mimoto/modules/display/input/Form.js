/**
 * Mimoto - Form
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Mimoto input classes
let InputField = require('./InputField');


module.exports = function(elForm) {

    // start
    this.__construct(elForm);
};

module.exports.prototype = {

    // elements
    _aInputFields: [],

    // settings
    _bAutoSave: false,
    _sPublicKey: null,
    _actions: null,

    // state
    _bHasChanges: false,


    // form setting directives
    DIRECTIVE_MIMOTO_FORM_AUTOSAVE:  'data-mimoto-form-autosave',
    DIRECTIVE_MIMOTO_FORM_PUBLICKEY: 'data-mimoto-form-publickey',
    DIRECTIVE_MIMOTO_FORM_ACTIONS:   'data-mimoto-form-actions',

    // form field directives
    DIRECTIVE_MIMOTO_FORM_FIELD:       'data-mimoto-form-field',


    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(elForm)
    {
        this._parseForm(elForm);
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------





    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    _parseForm: function(elForm)
    {
        // 1. register
        this._sPublicKey = elForm.getAttribute(this.DIRECTIVE_MIMOTO_FORM_PUBLICKEY);
        this._bAutoSave = (elForm.getAttribute(this.DIRECTIVE_MIMOTO_FORM_AUTOSAVE) === 'true');
        this._actions = (elForm.getAttribute(this.DIRECTIVE_MIMOTO_FORM_ACTIONS) === 'true');

        // 2. get fields
        let aInputFieldElements = elForm.querySelectorAll('[' + this.DIRECTIVE_MIMOTO_FORM_FIELD + ']');

        // 3. parse input fields
        let nInputFieldCount = aInputFieldElements.length;
        for (let nInputFieldIndex = 0; nInputFieldIndex < nInputFieldCount; nInputFieldIndex++)
        {
            // a. register
            let elInputField = aInputFieldElements[nInputFieldIndex];

            // b. read
            let sFieldSelector = elInputField.getAttribute(this.DIRECTIVE_MIMOTO_FORM_FIELD);

            // b. init
            let inputField = new InputField(sFieldSelector, elInputField);

            // c. store
            this._aInputFields.push(inputField);
        }

    },







    _startAutosave: function(form)
    {

        //console.log('Autosave ', form);
        return;

        if (!form.autosaveTimer)
        {

            var classRoot = this;

            form.autosaveTimer = setTimeout(function(){ classRoot._executeAutoSave(form); }, 1000);
        }
    },

    _executeAutoSave: function(form)
    {
        // cleanup
        clearTimeout(form.autosaveTimer);
        delete(form.autosaveTimer);

        console.log('Auto saving ... ');

        this.submit(form.sName);
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


            var aInputFields = $("[data-mimoto-form-field='" + field.sName + "']", $form);

            aInputFields.each( function(index, $inputField)
            {
                // 7b. find field
                var aInputs = $("[data-mimoto-form-field-input='" + field.sName + "']", $inputField);

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
        //console.error(requestData);
        // console.log('------');



        // 11. send data
        Mimoto.utils.callAPI({
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
                        var aFields = $('[data-mimoto-form-field^="' + newEntity.selector + '"]', $form);
                        aFields.each( function(index, $component)
                        {
                            var mls_form_field = $($component).attr("data-mimoto-form-field");
                            mls_form_field = newEntity.id + mls_form_field.substr(newEntity.selector.length);
                            $($component).attr("data-mimoto-form-field", mls_form_field);
                        });

                        // update dom
                        var aFields = $('[data-mimoto-form-field-input^="' + newEntity.selector + '"][name^="' + newEntity.selector + '"]', $form);

                        aFields.each( function(index, $component)
                        {
                            var sOld_mls_form_field_input = $($component).attr("data-mimoto-form-field-input");
                            var sNew_mls_form_field_input = newEntity.id + sOld_mls_form_field_input.substr(newEntity.selector.length);
                            $($component).attr("data-mimoto-form-field-input", sNew_mls_form_field_input);

                            classRoot._alterRegisteredFieldId(resultData.formName, sOld_mls_form_field_input, sNew_mls_form_field_input);

                            var name = $($component).attr("name");
                            name = newEntity.id + name.substr(newEntity.selector.length);
                            $($component).attr("name", name);
                        });

                        // update dom
                        var aFields = $('[data-mimoto-form-field-error^="' + newEntity.selector + '"]', $form);
                        aFields.each( function(index, $component)
                        {
                            var mls_form_field_error = $($component).attr("data-mimoto-form-field-error");
                            mls_form_field_error = newEntity.id + mls_form_field_error.substr(newEntity.selector.length);
                            $($component).attr("data-mimoto-form-field-error", mls_form_field_error);
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
                            Mimoto.closePopup();
                        }
                        else if (form.responseSettings.onSuccess.reloadPopup)
                        {
                            Mimoto.popup.replace(form.responseSettings.onSuccess.reloadPopup);
                        }
                        else if (form.responseSettings.onSuccess.dispatchEvent)
                        {

                            console.log('form.responseSettings.onSuccess.dispatchEvent', form.responseSettings.onSuccess.dispatchEvent);
                        }
                    }
                }
            }
        });

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
                field.$input = $("input[data-mimoto-form-field-input='" + sNewInputFieldId + "']");

                // store
                // Mimoto.Aimless.realtime.broadcastedValues[sNewInputFieldId] = Mimoto.Aimless.realtime.broadcastedValues[sOldInputFieldId];
                // delete Mimoto.Aimless.realtime.broadcastedValues[sOldInputFieldId];

                this._connectInputField(field);
            }
        }
    }

}
