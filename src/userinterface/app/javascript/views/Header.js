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

    this.messageToggle = this.el.querySelector('.js-message-dropdown-toggle');
    this.messageDropdown = this.el.querySelector('.js-message-dropdown');

    this.chatToggle = this.el.querySelector('.js-chat-dropdown-toggle');
    this.chatDropdown = this.el.querySelector('.js-chat-dropdown');

    this.collapsed = false;

  },

  addEventListeners: function () {

    this.navigationToggle.addEventListener('click', function () {

      this.toggleNavigationCollapse();

    }.bind(this));

    this.mobileNavigationToggle.addEventListener('click', function () {

      this.toggleClass(this.navigation, 'navigation--active');

    }.bind(this));

    if (this.messageToggle && this.messageDropdown) {

      this.messageToggle.addEventListener('click', function () {

        this.toggleClass(this.messageDropdown, 'header-menu-message-dropdown--active');

      }.bind(this));

    }

    if (this.chatToggle && this.chatDropdown) {

      this.chatToggle.addEventListener('click', function () {

        this.toggleClass(this.chatDropdown, 'header-menu-chat-dropdown--active');

      }.bind(this));

    }

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

    this.toggleClass(this.body, 'navigation-collapsed');
    localStorage.setItem('collapsed', this.collapsed);

  },

  toggleClass: function (element, className) {

    element.classList.toggle(className);

  }

};
