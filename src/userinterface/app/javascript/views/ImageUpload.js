'use strict';

var Dropzone = require('dropzone');
Dropzone.autoDiscover = false;

module.exports = function (element, options) {

  this.el = element;
  this.options = options;
  this.init();

};

module.exports.prototype = {

  init: function () {

    this.setVariables();
    this.initDropzones();

  },

  setVariables: function () {

    this.imageUploadClass = '.js-image-upload';
    this.imageUploadTriggerClass = '.js-image-upload-trigger';
    this.previewClass = '.js-image-upload-preview';
    this.previewTemplateClass = '.js-image-upload-preview-template';

    this.showPreviewClass = 'form-image-upload--show-preview';
    this.showPreviewImageClass = 'form-image-upload--show-preview-image';
    this.hideUploadProgressClass = 'form-image-upload--hide-upload-progess';

    this.errorParent = this.el.querySelector('.js-error-parent');

    this.postURL = this.options.url;
    this.imageUpload = this.el.querySelector(this.imageUploadClass);
    this.previewTemplate = this.getPreviewTemplate();

  },

  initDropzones: function () {

    this.dropzone = new Dropzone(this.imageUpload, {
      url: this.postURL,
      maxFilesize: 1,
      parallelUploads: 20,
      previewTemplate: this.previewTemplate,
      thumbnailWidth: null,
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
      ErrorHandling.removeError(this.errorParent, this.el);
    }.bind(this));

    this.dropzone.on('addedfile', function (file) {
      this.dropzone.element.classList.add(this.showPreviewClass);
    }.bind(this));

    this.dropzone.on('thumbnail', function (file) {
      this.dropzone.element.classList.add(this.showPreviewImageClass);
    }.bind(this));

    this.dropzone.on('error', function (file, errorMessage, xhrObject) {
      ErrorHandling.addError(errorMessage, this.errorParent, this.el);
    }.bind(this));

    this.dropzone.on('success', function (file, serverResponse) {
      setTimeout(function () {
        this.dropzone.element.classList.add(this.hideUploadProgressClass);
      }.bind(this), 100);
    }.bind(this));

  }

};
