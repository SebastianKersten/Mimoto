'use strict';

var Dropzone = require('dropzone');
Dropzone.autoDiscover = false;

module.exports = function (element, options) {

  this.el = element;
  this.init();

};

module.exports.prototype = {

  init: function () {

    this.setVariables();
    this.initDropzones();

  },

  setVariables: function () {

    this.imageUploadClass = '.js-image-upload';
    this.previewImageClass = '.js-image-upload-preview-image';

    this.showPreviewClass = 'form-image-upload--show-preview';
    this.showPreviewImageClass = 'form-image-upload-preview-image--show';
    this.hideUploadProgressClass = 'form-image-upload--hide-upload-progess';
    this.imageUpload = this.el.querySelector(this.imageUploadClass);

  },

  initDropzones: function () {

    // Get the template HTML and remove it from the document
    var previewTemplate = this.getPreviewTemplate();

    this.dropzone = new Dropzone(this.imageUpload, {
      url: 'http://httpbin.org/post',
      maxFilesize: 1,
      parallelUploads: 20,
      previewTemplate: previewTemplate,
      thumbnailWidth: null,
      thumbnailHeight: 500,
      previewsContainer: '.js-image-upload-preview',
      clickable: '.js-image-upload-trigger'
    });

    this.addDropzoneEvents();

  },

  getPreviewTemplate: function () {

    var previewNode = document.querySelector('.form-image-upload-preview-template');
    var template = previewNode.parentNode.innerHTML;
    previewNode.id = "";
    previewNode.parentNode.removeChild(previewNode);

    return template;

  },

  addDropzoneEvents: function () {
    
    this.dropzone.on('removedfile', function (file) {
      this.dropzone.element.classList.remove(this.showPreviewClass);
    }.bind(this));

    this.dropzone.on('addedfile', function (file) {
      this.dropzone.element.classList.add(this.showPreviewClass);
    }.bind(this));

    this.dropzone.on('thumbnail', function (file) {
      this.dropzone.element.querySelector(this.previewImageClass).classList.add(this.showPreviewImageClass);
    }.bind(this));

    this.dropzone.on('error', function (file, errorMessage, xhrObject) {
      console.log(file);
      console.log(errorMessage);
      console.log(xhrObject);
    }.bind(this));

    this.dropzone.on('success', function (file, serverResponse) {
      setTimeout(function () {
        this.dropzone.element.classList.add(this.hideUploadProgressClass);
      }.bind(this), 100);
    }.bind(this));

  }

};
