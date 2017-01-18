'use strict';

var Dropzone = require('dropzone');
Dropzone.autoDiscover = false;

module.exports = function (element) {

    this.el = element;
    this.init();

};

module.exports.prototype = {

    init: function () {

        console.log("Init Image Upload");
        this.setVariables();
        this.initDropzone();

    },

    setVariables: function () {

        this.imageUploadClass = '.js-image-upload';
        this.imageUploadTriggerClass = '.js-image-upload-trigger';
        this.previewClass = '.js-image-upload-preview';
        this.previewTemplateClass = '.js-image-upload-preview-template';

        this.showPreviewClass = 'MimotoCMS_forms_input_ImageUpload--show-preview';
        this.showPreviewImageClass = 'MimotoCMS_forms_input_ImageUpload--show-preview-image';
        this.hideUploadProgressClass = 'MimotoCMS_forms_input_ImageUpload--hide-upload-progess';

        this.errorParent = this.el.querySelector('.js-error-parent');

        this.postURL = "http://httpbin.org/post";
        this.imageUpload = this.el.querySelector(this.imageUploadClass);
        this.previewTemplate = this.getPreviewTemplate();

    },

    initDropzone: function () {

        this.dropzone = new Dropzone(this.imageUpload, {
            url: this.postURL,
            maxFilesize: 1,
            parallelUploads: 20,
            previewTemplate: this.previewTemplate,
            thumbnailWidth: 500,
            thumbnailHeight: 500,
            previewsContainer: this.previewClass,
            clickable: this.imageUploadTriggerClass
        });

        this.addDropzoneEvents();

    },

    getPreviewTemplate: function () {

        var previewNode = document.querySelector(this.previewTemplateClass);
        var template = previewNode.parentNode.innerHTML;
        previewNode.id = "";
        previewNode.parentNode.removeChild(previewNode);

        return template;

    },

    addDropzoneEvents: function () {

        this.dropzone.on('removedfile', function (file) {
            this.dropzone.element.classList.remove(this.showPreviewClass);
            this.dropzone.element.classList.remove(this.showPreviewImageClass);
            EH.clearState(this.el);
        }.bind(this));

        this.dropzone.on('addedfile', function (file) {
            this.dropzone.element.classList.add(this.showPreviewClass);
        }.bind(this));

        this.dropzone.on('thumbnail', function (file) {
            this.dropzone.element.classList.add(this.showPreviewImageClass);
        }.bind(this));

        this.dropzone.on('error', function (file, errorMessage, xhrObject) {
            EH.addErrorState(this.el, errorMessage);
        }.bind(this));

        this.dropzone.on('success', function (file, serverResponse) {
            setTimeout(function () {
                this.dropzone.element.classList.add(this.hideUploadProgressClass);
                EH.addValidatedState(this.el);
            }.bind(this), 100);
        }.bind(this));

    }

};
