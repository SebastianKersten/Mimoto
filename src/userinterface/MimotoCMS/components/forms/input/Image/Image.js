/**
 * Mimoto - InputField - Image
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


let Dropzone = require('dropzone');


module.exports = function(elFormField, fBroadcast, aInputElements) {

    // start
    this.__construct(elFormField, fBroadcast, aInputElements);
};

module.exports.prototype = {

    // dom
    _elDropzone: null,
    _elFormField: null,
    _fBroadcast: null,
    _aInputElements: null,

    // elements
    _elTemplate: null,
    _elPreview: null,
    _elPersistent: null,
    _elRemoveButton: null,

    // utils
    _dropzone: null,



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
        this._elDropzone = elFormField.querySelector('[data-mimoto-form-input-image-upload]');
        this._elTemplate = elFormField.querySelector('[data-mimoto-form-input-image-template]');
        this._elPreview = elFormField.querySelector('[data-mimoto-form-input-image-preview]');
        this._elPersistent = elFormField.querySelector('[data-mimoto-form-input-image-persistent]');
        this._elRemoveButton = elFormField.querySelector('[data-mimoto-form-input-image-remove]');

        // prepare
        let aClickableElements = elFormField.querySelectorAll('[data-mimoto-form-input-image-trigger]');
        let nClickableElementCount = aClickableElements.length;
        for (let nClickableElementIndex = 0; nClickableElementIndex < nClickableElementCount; nClickableElementIndex++)
        {
            // make unique
            aClickableElements[nClickableElementIndex].setAttribute('data-mimoto-form-input-image-trigger', elFormField.getAttribute('data-mimoto-form-field'));
        }

        // setup
        this._dropzone = new Dropzone(this._elDropzone, {
            url: '/mimoto/media/upload/image',
            maxFilesize: 1000,
            parallelUploads: 20,
            previewTemplate: this._elTemplate.parentNode.innerHTML,
            thumbnailWidth: 500,
            thumbnailHeight: null,
            previewsContainer: this._elPreview,
            clickable: '[data-mimoto-form-input-image-trigger="' + elFormField.getAttribute('data-mimoto-form-field') + '"]'
        });

        // cleanup
        this._elTemplate.parentNode.removeChild(this._elTemplate);


        this._dropzone.on('addedfile', function (file)
        {
            // remove all previous files
            for (let nFileIndex = 0; nFileIndex < this._dropzone.files.length; nFileIndex++)
            {
                // register
                let registeredFile = this._dropzone.files[nFileIndex];

                // verify
                if (registeredFile !== file) this._dropzone.removeFile(registeredFile);
            }

            this._dropzone.element.classList.add('MimotoCMS_forms_input_ImageUpload--show-preview');
            this._dropzone.element.classList.add('MimotoCMS_forms_input_ImageUpload--hide-upload-progess');

            // hide persistent
            this._elPersistent.classList.add('Mimoto_CoreCSS_hidden');

        }.bind(this));

        this._dropzone.on('complete', function (file) {

        }.bind(this));

        this._dropzone.on('thumbnail', function (file)
        {
            this._dropzone.element.classList.add('MimotoCMS_forms_input_ImageUpload--show-preview-image');

        }.bind(this));

        this._dropzone.on('error', function (file, errorMessage, xhrObject)
        {
            Mimoto.log('Error on upload', file, errorMessage, xhrObject);

        }.bind(this));

        this._dropzone.on('success', function (file, serverResponse)
        {
            // connect value
            this.setValue(serverResponse.file_id);

            // show
            this._elRemoveButton.classList.remove('Mimoto_CoreCSS_hidden');

        }.bind(this));


        this._elRemoveButton.addEventListener('click', function() {

            // clear value
            this.setValue(null);

            this._dropzone.element.classList.remove('MimotoCMS_forms_input_ImageUpload--show-preview');
            this._dropzone.element.classList.remove('MimotoCMS_forms_input_ImageUpload--show-preview-image');

            // hide
            this._elRemoveButton.classList.add('Mimoto_CoreCSS_hidden');
            this._elPersistent.classList.add('Mimoto_CoreCSS_hidden');

            // clear
            this._dropzone.removeAllFiles();
            this._elPersistent.setAttribute('src', '');

        }.bind(this));


        if (this.getValue())
        {
            // load
            this._loadPersistentImage();
        }
        else
        {
            this._elPersistent.classList.add('Mimoto_CoreCSS_hidden');
        }
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
    },



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    _loadPersistentImage: function()
    {
        Mimoto.utils.callAPI({
            type: 'get',
            url: '/mimoto/media/source/' + this._elInput.getAttribute('data-mimoto-form-field-input'),
            success: function(resultData, resultStatus, resultSomething)
            {
                if (resultData && resultData.file_id)
                {
                    // setup
                    this._elPersistent.setAttribute('src', resultData.full_path);
                }
            }.bind(this)
        });
    }

}
