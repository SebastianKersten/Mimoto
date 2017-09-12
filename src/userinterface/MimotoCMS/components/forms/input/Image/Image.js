/**
 * Mimoto - InputField - Image
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


let Dropzone = require('dropzone');


module.exports = function(elFormField, elInput) {

    // start
    this.__construct(elFormField, elInput);
};

module.exports.prototype = {

    // dom
    _elFormField: null,
    _elInput: null,

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
    __construct: function(elFormField, elInput)
    {
        // store
        this._elFormField = elFormField;
        this._elInput = elInput;

        // register
        this._elTemplate = elFormField.querySelector('[data-mimoto-form-input-image-template]');
        this._elPreview = elFormField.querySelector('[data-mimoto-form-input-image-preview]');
        this._elPersistent = elFormField.querySelector('[data-mimoto-form-input-image-persistent]');
        this._elRemoveButton = elFormField.querySelector('[data-mimoto-form-input-image-remove]');


        // setup
        this._dropzone = new Dropzone('[data-mimoto-form-input-image-upload]', {
            url: '/mimoto/media/upload/image',
            maxFilesize: 1000,
            parallelUploads: 20,
            previewTemplate: this._elTemplate.parentNode.innerHTML,
            thumbnailWidth: 500,
            thumbnailHeight: null,
            previewsContainer: this._elPreview,
            clickable: '[data-mimoto-form-input-image-trigger]'
        });

        // cleanup
        this._elTemplate.parentNode.removeChild(this._elTemplate);


        // // configure
        // this._dropzone.on('removedfile', function (file)
        // {
        //     this._dropzone.element.classList.remove('MimotoCMS_forms_input_ImageUpload--show-preview');
        //     this._dropzone.element.classList.remove('MimotoCMS_forms_input_ImageUpload--show-preview-image');
        //
        //     // set value
        //     this.setValue(null);
        //
        // }.bind(this));

        this._dropzone.on('addedfile', function (file)
        {
            this._dropzone.removeAllFiles();

            this._dropzone.element.classList.add('MimotoCMS_forms_input_ImageUpload--show-preview');
            this._dropzone.element.classList.add('MimotoCMS_forms_input_ImageUpload--hide-upload-progess');

            // hide persistent
            this._elPersistent.classList.add('Mimoto_CoreCSS_hidden');

        }.bind(this));

        this._dropzone.on('complete', function (file) {

            Mimoto.warn('File complete', file);

            //this._dropzone.removeAllFiles();

        }.bind(this));

        this._dropzone.on('thumbnail', function (file)
        {
            this._dropzone.element.classList.add('MimotoCMS_forms_input_ImageUpload--show-preview-image');
            //this._dropzone.element.classList.add('MimotoCMS_forms_input_ImageUpload--hide-upload-progess');

        }.bind(this));

        this._dropzone.on('error', function (file, errorMessage, xhrObject)
        {
            Mimoto.log('Error on upload', file, errorMessage, xhrObject);

        }.bind(this));

        this._dropzone.on('success', function (file, serverResponse)
        {
            Mimoto.log('serverResponse onSuccess', serverResponse);


            // connect value
            this.setValue(serverResponse.file_id);

            // show
            this._elRemoveButton.classList.remove('Mimoto_CoreCSS_hidden');

            // hide
            //this._dropzone.element.classList.remove('MimotoCMS_forms_input_ImageUpload--hide-upload-progess');

        }.bind(this));


        this._elRemoveButton.addEventListener('click', function() {

            // clear value
            this.setValue(null);

            this._dropzone.element.classList.remove('MimotoCMS_forms_input_ImageUpload--show-preview');
            this._dropzone.element.classList.remove('MimotoCMS_forms_input_ImageUpload--show-preview-image');

            // hide
            this._dropzone.removeAllFiles();
            this._elRemoveButton.classList.add('Mimoto_CoreCSS_hidden');
            this._elPersistent.setAttribute('src', '');
            this._elPersistent.classList.add('Mimoto_CoreCSS_hidden');

        }.bind(this));


        if (this.getValue())
        {
            Mimoto.log('Persistent value found');


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

        this._elInput.value = value; // #todo show image?


        if (!bDontBroadcastOnInitialSet) this._broadcastChange();
    },



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    _broadcastChange: function()
    {
        this._elInput.dispatchEvent(new Event('onMimotoInputChanged'));
    }

}
