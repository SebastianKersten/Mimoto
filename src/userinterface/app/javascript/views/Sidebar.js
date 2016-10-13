'use strict';

module.exports = function (element) {

  this.el = element;
  this.init();

};

module.exports.prototype = {

  init: function () {

    console.log('Init sidebar');
    this.setVariables();
    this.addEventListeners();

  },

  setVariables: function () {

    this.toggle = this.el.querySelector('.js-sidebar-toggle');
    this.header = document.querySelector('.js-header');

  },

  addEventListeners: function () {

    this.toggle.addEventListener('click', function () {
      console.error("YEAH");

      this.el.classList.toggle('sidebar--is-collapsed');
      this.header.classList.toggle('header--sidebar-is-collapsed');
    }.bind(this));

  }

};
