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

        Mimoto.utils.callAPI({
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



}
