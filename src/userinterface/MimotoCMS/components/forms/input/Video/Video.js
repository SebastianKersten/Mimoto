/**
 * Mimoto - InputField - Video
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
        this._elTemplate = elFormField.querySelector('[data-mimoto-form-input-video-template]');
        this._elPreview = elFormField.querySelector('[data-mimoto-form-input-video-preview]');
        this._elPersistent = elFormField.querySelector('[data-mimoto-form-input-video-persistent]');
        this._elRemoveButton = elFormField.querySelector('[data-mimoto-form-input-video-remove]');
        //this._elDropzone



        // setup
        this._dropzone = new Dropzone('[data-mimoto-form-input-video-upload]', {
            url: '/mimoto/media/upload/video',
            maxFilesize: 1000,
            parallelUploads: 20,
            previewTemplate: this._elTemplate.parentNode.innerHTML,
            thumbnailWidth: 500,
            thumbnailHeight: null,
            previewsContainer: this._elPreview,
            clickable: '[data-mimoto-form-input-video-trigger]'
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

            this._dropzone.element.classList.add('MimotoCMS_forms_input_VideoUpload--show-preview');
            this._dropzone.element.classList.add('MimotoCMS_forms_input_VideoUpload--hide-upload-progess');

            // hide persistent
            this._elPersistent.classList.add('Mimoto_CoreCSS_hidden');

        }.bind(this));

        this._dropzone.on('complete', function (file) {

        }.bind(this));

        this._dropzone.on('thumbnail', function (file)
        {
            this._dropzone.element.classList.add('MimotoCMS_forms_input_VideoUpload--show-preview-image');

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

            // show
            this._showVideo(serverResponse.full_path);

        }.bind(this));


        this._elRemoveButton.addEventListener('click', function() {

            // clear value
            this.setValue(null);

            this._dropzone.element.classList.remove('MimotoCMS_forms_input_VideoUpload--show-preview');
            this._dropzone.element.classList.remove('MimotoCMS_forms_input_VideoUpload--show-preview-image');

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
            this._loadPersistentVideo();
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


    _loadPersistentVideo: function()
    {
        Mimoto.utils.callAPI({
            type: 'get',
            url: '/mimoto/media/source/' + this._elInput.getAttribute('data-mimoto-form-field-input'),
            success: function(resultData, resultStatus, resultSomething)
            {
                if (resultData && resultData.file_id)
                {
                    // show
                    this._showVideo(resultData.full_path);
                }
            }.bind(this)
        });
    },

    _showVideo: function(sFullPath)
    {
        // setup
        this._elPersistent.src = sFullPath;
        this._elPersistent.controls = true;

        // load video
        this._elPersistent.load();
    }

}
