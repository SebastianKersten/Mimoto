'use strict';

var Dropzone = require('dropzone');
Dropzone.autoDiscover = false;


module.exports = function () {

  this.init();

};

module.exports.prototype = {

  init: function () {


    this.setVariables();
    this.initImageUploads();

  },

  setVariables: function () {

    this.imageUploadClass = '.js-image-upload';
    this.showPreviewClass = 'form-image-upload--show-preview';
    this.imageUploads = document.querySelectorAll(this.imageUploadClass);

    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = document.querySelector(".form-image-upload-preview-template");
    previewNode.id = "";
    this.previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

  },

  initImageUploads: function () {

    for (var i = 0; i < this.imageUploads.length; i++) {

      this.dropzone = new Dropzone(this.imageUploads[i], {
        url: '/target-url',
        parallelUploads: 20,
        previewTemplate: this.previewTemplate,
        thumbnailWidth: null,
        thumbnailHeight: null,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: '.form-image-upload-preview',
        clickable: '.js-image-upload-trigger'
      });

      this.dropzone.on('thumbnail', function (file, dataUrl) {
        this.dropzone.element.classList.add(this.showPreviewClass);
      }.bind(this));

      this.dropzone.on('removedfile', function (file) {
        this.dropzone.element.classList.remove(this.showPreviewClass);
      }.bind(this));

    }

  }

};
