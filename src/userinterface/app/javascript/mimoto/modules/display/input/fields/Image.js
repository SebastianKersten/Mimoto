/**
 * Mimoto - InputField
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Dropzone classes
var Dropzone = require('dropzone');


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

        Mimoto.utils.callAPI({
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



}
