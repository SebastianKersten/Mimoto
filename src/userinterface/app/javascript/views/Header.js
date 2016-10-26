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
    this.checkCollapsed();

  },

  setVariables: function () {

    this.navigationToggle = this.el.querySelector('.js-navigation-toggle');
    this.mobileNavigationToggle = this.el.querySelector('.js-mobile-navigation-toggle');

    this.body = document.getElementsByTagName('body')[0];
    this.navigation = document.querySelector('.js-navigation');

    this.collapsed = false;

  },

  addEventListeners: function () {

    this.navigationToggle.addEventListener('click', function () {

      this.toggleNavigationCollapse();

    }.bind(this));

    this.mobileNavigationToggle.addEventListener('click', function () {

      this.toggleMobileNavigation();

    }.bind(this));

  },

  checkCollapsed: function () {

    if (localStorage.getItem('collapsed')) {
      this.collapsed = JSON.parse(localStorage.getItem('collapsed'));
    }

    if (this.collapsed) {
      this.body.classList.add('navigation-collapsed');
    }

  },

  toggleNavigationCollapse: function () {

    this.collapsed = !this.collapsed;

    this.body.classList.toggle('navigation-collapsed');
    localStorage.setItem('collapsed', this.collapsed);

  },

  toggleMobileNavigation: function () {

    this.navigation.classList.toggle('navigation--active');

  }

};
