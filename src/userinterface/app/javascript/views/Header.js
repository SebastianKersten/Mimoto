'use strict';

module.exports = function (element) {

  this.el = element;
  this.init();

};

module.exports.prototype = {

  init: function () {

    console.log('Init header');
    this.setVariables();
    this.addEventListeners();

  },

  setVariables: function () {

    this.navigationToggle = this.el.querySelector('.js-navigation-toggle');
    this.mobileNavigationToggle = this.el.querySelector('.js-mobile-navigation-toggle');

    this.body = document.getElementsByTagName('body')[0];
    this.navigation = document.querySelector('.js-navigation');

  },

  addEventListeners: function () {

    this.navigationToggle.addEventListener('click', function () {

      this.toggleNavigationCollapse();

    }.bind(this));

    this.mobileNavigationToggle.addEventListener('click', function () {

      this.toggleMobileNavigation();

    }.bind(this));

  },

  toggleNavigationCollapse: function () {

    this.body.classList.toggle('navigation-collapsed');

  },

  toggleMobileNavigation: function () {

    this.navigation.classList.toggle('navigation--active');

  }

};
