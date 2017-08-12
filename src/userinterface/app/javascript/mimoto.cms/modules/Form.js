/**
 * Mimoto.CMS - Form handling
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';

var Sortable = require('sortablejs'); // https://github.com/RubaXa/Sortable

var Dropzone = require('dropzone');
var Flatpickr = require('flatpickr');
var Quill = require('quill');

Dropzone.autoDiscover = false;

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
        this._aRequests = [];
        this._sCurrentOpenForm = '';
        this._aMediaFields = [];
        this._aDatePicker = [];
        this._aTextblockFields = [];
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
            $field: $("[data-mimoto-form-field='" + sInputFieldId + "']", $form),
            $input: $("[data-mimoto-form-field-input='" + sInputFieldId + "']", $form),  // todo - multiselect x * option
            $error: $("[data-mimoto-form-field-error='" + sInputFieldId + "']", $form)
        };

        // store
        currentForm.aFields.push(field);
        
        // store
        // Mimoto.Aimless.realtime.broadcastedValues[sInputFieldId] = {
        //     sFormName: currentForm.sFormName,
        //     value: $(field.$input).val()
        // };
    
        // var forms = document.querySelectorAll('.js-form');

        // connect
        this._connectInputField(field);
        
        // register
        var classPath = this;
        
        // read type
        var sAimlessInputType = this._getInputFieldType(field.$input);
    
        // verify
        if (sAimlessInputType == 'list')
        {
            // find
            var listInputField = document.querySelectorAll('[data-mimoto-form-field="' + sInputFieldId + '"]');
            var listElement = listInputField[0].querySelectorAll('.js-list');
            
            // read
            var bIsSortable = listElement[0].classList.contains('js-list-sortable');
            
            // verify
            if (bIsSortable)
            {
                var sortable = new Sortable(listElement[0], {
                    group: sInputFieldId,
                    handle: '.MimotoCMS_forms_input_ListItem-handle',
                    dragClass: 'MimotoCMS_forms_input_ListItem--drag',
                    ghostClass: 'MimotoCMS_forms_input_ListItem--ghost',
                    onEnd: function (e)
                    {
                        // adjust
                        classPath._changeOrder(e.from, e.item, e.oldIndex, e.newIndex)
                    }
                });
            }
        }
        
        
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
        var aSubmitButtons = $('[data-mimoto-form-submit="' + sFormName + '"]');

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
        //     var $input = $("input[data-mimoto-form-field-input='" + data.fieldId + "']");
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
        // console.error(requestData);
        // console.log('------');
        
        
        
        // 11. send data
        MimotoX.utils.callAPI({
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
                            MimotoX.closePopup();
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



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


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
    
    
    setupImageField: function(sImageFieldId, sFlatImageFieldId, sInputFieldId, sImagePath, sImageName, nImageSize)
    {
        // read
        var currentForm = this._aForms[this._sCurrentOpenForm];
        
        // validate
        if (!currentForm) return;
        
        
        
        // 1. locate form in dom
        var $form = $('form[name="' + currentForm.sName + '"]');
        
        // register
        var field = $('[data-mimoto-form-field="' + sInputFieldId + '"]', $form);
        var fieldInput = $("input", field);

        // setup
        var mediaField = {
            sImageFieldShowPreviewClass: 'MimotoCMS_forms_input_ImageUpload--show-preview',
            sImageFieldShowPreviewImageClass: 'MimotoCMS_forms_input_ImageUpload--show-preview-image',
            domElement: document.getElementById(sImageFieldId),
            sImageFieldId: sImageFieldId,
            field: field,
            fieldInput: fieldInput,
            $removeButton: $('#image-upload-delete-' + sFlatImageFieldId, $form),
            $previewImage: $('#js-' + sFlatImageFieldId + '-previewimage', $form)
        };

        // store
        this._aMediaFields[sImageFieldId] = mediaField;
        
        
        // register
        var classRoot = document;
        
    
        // preview template
        var previewNode = document.querySelector('.js-' + sFlatImageFieldId + '-image-upload-preview-template');
        var template = previewNode.parentNode.innerHTML;
        previewNode.id = "";
        previewNode.parentNode.removeChild(previewNode);
        mediaField.previewTemplate = template;
    
        // setup
        mediaField.dropzone = new Dropzone(mediaField.domElement.querySelector('.js-' + sFlatImageFieldId + '-image-upload'), {
            url: '/Mimoto.Aimless/upload/image',
            maxFilesize: 1000,
            parallelUploads: 20,
            previewTemplate: mediaField.previewTemplate,
            thumbnailWidth: 500,
            thumbnailHeight: null,
            previewsContainer: '.js-' + sFlatImageFieldId + '-image-upload-preview',
            clickable: '.js-' + sFlatImageFieldId + '-image-upload-trigger'
        });
    
    
        mediaField.dropzone.on('removedfile', function (file)
        {
            mediaField.dropzone.element.classList.remove(mediaField.sImageFieldShowPreviewClass);
            mediaField.dropzone.element.classList.remove(mediaField.sImageFieldShowPreviewImageClass);
    
            // set value
            fieldInput.val('');
            
        }.bind(this));
    
        mediaField.dropzone.on('addedfile', function (file)
        {
            mediaField.dropzone.element.classList.add(mediaField.sImageFieldShowPreviewClass);
        }.bind(this));
    
        mediaField.dropzone.on('thumbnail', function (file)
        {
            mediaField.dropzone.element.classList.add(mediaField.sImageFieldShowPreviewImageClass);
        }.bind(this));
    
        mediaField.dropzone.on('error', function (file, errorMessage, xhrObject) {}.bind(this));
    
        mediaField.dropzone.on('success', function (file, serverResponse)
        {
            // connect value
            fieldInput.val(serverResponse.file_id);

            // show
            mediaField.$removeButton.removeClass('hidden');

            // hide
            mediaField.dropzone.element.classList.add('MimotoCMS_forms_input_ImageUpload--hide-upload-progess');

            // save
            classRoot._startAutosave(currentForm);

        }.bind(this));


        mediaField.$removeButton.on('click', function() {

            console.log('click');

            // clear value
            mediaField.fieldInput.val('');

            mediaField.dropzone.element.classList.remove(mediaField.sImageFieldShowPreviewClass);
            mediaField.dropzone.element.classList.remove(mediaField.sImageFieldShowPreviewImageClass);

            // hide
            mediaField.$removeButton.addClass('hidden');
            mediaField.$previewImage.attr('src', '');
        });


        var classRoot = this;
        
        MimotoX.utils.callAPI({
            type: 'get',
            url: '/Mimoto.Aimless/media/source/' + sInputFieldId,
            success: function(resultData, resultStatus, resultSomething)
            {
                if (resultData && resultData.file_id)
                {
                    // register
                    var image = document.getElementById('js-' + sFlatImageFieldId + '-previewimage');
    
                    // setup
                    image.src = resultData.full_path;
                }
            }
        });
    },
    
    setupVideoField: function(sVideoFieldId, sFlatVideoFieldId, sInputFieldId, sImagePath, sImageName, nImageSize)
    {
        // read
        var currentForm = this._aForms[this._sCurrentOpenForm];
    
        // validate
        if (!currentForm) return;
        
        
        // 1. locate form in dom
        var $form = $('form[name="' + currentForm.sName + '"]');
        
        // register
        var field = $('[data-mimoto-form-field="' + sInputFieldId + '"]', $form);
        var fieldInput = $("input", field);
    
        // setup
        var mediaField = {
            domElement: document.getElementById(sVideoFieldId),
            sVideoFieldId: sVideoFieldId,
            field: field
        };
    
        // store
        this._aMediaFields[sVideoFieldId] = mediaField;
        
        
        // preview template
        var previewNode = document.querySelector('.js-' + sFlatVideoFieldId + '-video-upload-preview-template');
        var template = previewNode.parentNode.innerHTML;
        previewNode.id = "";
        previewNode.parentNode.removeChild(previewNode);
        mediaField.previewTemplate = template;
        
        // setup
        mediaField.dropzone = new Dropzone(mediaField.domElement.querySelector('.js-' + sFlatVideoFieldId + '-video-upload'), {
            url: '/Mimoto.Aimless/upload/video',
            maxFilesize: 1000,
            parallelUploads: 20,
            previewTemplate: mediaField.previewTemplate,
            thumbnailWidth: 500,
            thumbnailHeight: null,
            previewsContainer: '.js-' + sFlatVideoFieldId + '-video-upload-preview',
            acceptedFiles: ".mp4, .webm",
            clickable: '.js-' + sFlatVideoFieldId + '-video-upload-trigger'
        });
    
    
        mediaField.dropzone.on('removedfile', function (file) {
            fieldInput.val('');
        }.bind(this));
    
        mediaField.dropzone.on('addedfile', function (file) {}.bind(this));
        mediaField.dropzone.on('thumbnail', function (file) {}.bind(this));
        mediaField.dropzone.on('error', function (file, errorMessage, xhrObject) {}.bind(this));
    
        mediaField.dropzone.on('success', function (file, serverResponse) {
            
            // set value
            fieldInput.val(serverResponse.file_id);
            
            // register
            var video = document.getElementById('js-' + sFlatVideoFieldId + '-previewvideo');
            
            // add source
            video.src = serverResponse.full_path;
            video.controls = true;
            
            // load video
            video.load();

            classRoot._startAutosave(currentForm);

            mediaField.dropzone.element.classList.add('MimotoCMS_forms_input_VideoUpload--hide-upload-progess');

        }.bind(this));
        
        
        // register
        var classRoot = document;
        
        MimotoX.utils.callAPI({
            type: 'get',
            url: '/Mimoto.Aimless/media/source/' + sInputFieldId,
            success: function(resultData, resultStatus, resultSomething)
            {
                if (resultData && resultData.file_id)
                {
                    // register
                    var video = classRoot.getElementById('js-' + sFlatVideoFieldId + '-previewvideo');
                    
                    // setup
                    video.src = resultData.full_path;
                    video.controls = true;
    
                    // load video
                    video.load();
                }
            }
        });
        
    },

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

    _getInputFieldType: function($component)
    {
        // read type
        return $($component).attr('data-mimoto-input-type');
    },
    
    _changeOrder: function(htmlParentElement, htmlChildElement, nOldIndex, nNewIndex)
    {
        // register
        var sPropertySelector = htmlParentElement.getAttribute('data-mimoto-collection');
        var nConnectionId = htmlChildElement.getAttribute('data-mimoto-connection');
        var nCurrentSortindex = htmlChildElement.getAttribute('data-mimoto-sortindex');
        
        // validate
        if (!sPropertySelector || !nConnectionId || !nCurrentSortindex) return;
        
        // store
        MimotoX.utils.callAPI({
            type: 'get',
            url: '/mimoto.cms/form/list/sort/' + sPropertySelector + '/' + nConnectionId + '/' + nOldIndex + '/' + nNewIndex,
            success: function(resultData, resultStatus, resultSomething)
            {
                //console.log('Mimoto ===> I received a response from the FormController::updateSortindex!');
            }
        });
    },




    setupTextblock: function(sFieldId, sFlatFieldId, sInputFieldId, sPlaceHolder)
    {
        // read
        var currentForm = this._aForms[this._sCurrentOpenForm];

        // validate
        if (!currentForm) return;



        // 1. locate form in dom
        var $form = $('form[name="' + currentForm.sName + '"]');

        // register
        var field = $('[data-mimoto-form-field="' + sInputFieldId + '"]', $form);
        var fieldInput = $("input", field);

        // setup
        var textblockField = {
            domElement: document.getElementById(sFieldId),
            sFieldId: sFieldId,
            field: field,
            fieldInput: fieldInput
        };

        // store
        this._aTextblockFields[sFieldId] = textblockField;


        // register
        var classRoot = document;


        let valueContainer = document.getElementById('js-' + sFlatFieldId + '-textblock-container');
        let $valueHolder = $('js-' + sFlatFieldId + '-textblock-value', $form);


        // create
        textblockField.quill = new Quill(valueContainer, {
            theme: 'bubble',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block', 'link'],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                ],
                history: {
                    delay: 2000,
                    maxStack: 500,
                    userOnly: true
                }
            },
            placeholder: sPlaceHolder || '', // #todo
            formats: ['bold', 'italic', 'underline', 'strike', 'blockquote', 'code-block', 'link', 'header', 'list', 'indent']
        });


        // 1. set initial value
        fieldInput.val(valueContainer.getElementsByClassName("ql-editor")[0].innerHTML);


        textblockField.quill.on('text-change', function(delta, oldContents, source)
        {
            textblockField.fieldInput.val(valueContainer.getElementsByClassName("ql-editor")[0].innerHTML);
        });
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
    }
    
};
