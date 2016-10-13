'use strict';

module.exports = function () {

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
    this.body = document.getElementsByTagName('body')[0];

  },

  addEventListeners: function () {

    this.toggle.addEventListener('click', function () {

      this.toggleCollapse();

    }.bind(this));

  },

  toggleCollapse: function () {

    this.body.classList.toggle('sidebar-collapsed');

  }

};
