'use strict';

module.exports = function(element) {

    this.el = element;
    this.init();
};

module.exports.prototype = {

    /**
     * Constructor
     */
    init: function()
    {
        this.setVariables();
        this.addEventListeners();
        this.checkMenuState();
        this.initNotificationCount();
    },

    /**
     * Set dom variables
     */
    setVariables: function()
    {

        this.navigationToggle = this.el.querySelector('.js-navigation-toggle');
        this.mobileNavigationToggle = this.el.querySelector('.js-mobile-navigation-toggle');

        this.body = document.getElementsByTagName('body')[0];
        this.navigation = document.querySelector('.js-navigation');

        this.messageToggle = this.el.querySelector('.js-message-dropdown-toggle');
        this.messageDropdown = this.el.querySelector('.js-message-dropdown');

        this.chatToggle = this.el.querySelector('.js-chat-dropdown-toggle');
        this.chatDropdown = this.el.querySelector('.js-chat-dropdown');

        this.collapsed = false;

        this.notificationCount = document.getElementById('header_notification_count');
    },

    /**
     * Add event listeners
     */
    addEventListeners: function()
    {

        this.navigationToggle.addEventListener('click', function () {
            this.toggleMenuState();
        }.bind(this));

        this.mobileNavigationToggle.addEventListener('click', function () {
            this.toggleClass(this.navigation, 'navigation--active');
        }.bind(this));

        if (this.messageToggle && this.messageDropdown)
        {
            this.messageToggle.addEventListener('click', function () {
                this.toggleClass(this.messageDropdown, 'header-menu-message-dropdown--active');
            }.bind(this));
        }

        if (this.chatToggle && this.chatDropdown)
        {
            this.chatToggle.addEventListener('click', function () {
                this.toggleClass(this.chatDropdown, 'header-menu-chat-dropdown--active');
            }.bind(this));
        }
    },


    /**
     * Check menu state
     */
    checkMenuState: function()
    {
        if (localStorage.getItem('collapsed')) { this.collapsed = JSON.parse(localStorage.getItem('collapsed'));}

        if (this.collapsed) { this.body.classList.add('navigation-collapsed'); }
    },

    /**
     * Init notification count
     */
    initNotificationCount: function()
    {

        // setup
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/mimoto.cms/notifications/count');

        // init
        var classRoot = this;

        xhr.onreadystatechange = function ()
        {
            // init
            var DONE = 4; // readyState 4 means the request is done.
            var OK = 200; // status 200 is a successful return.

            if (xhr.readyState === DONE)
            {
                if (xhr.status === OK)
                {
                    if (parseInt(xhr.responseText) > 0)
                    {
                        classRoot.notificationCount.innerText = xhr.responseText;
                        classRoot.toggleClass(classRoot.notificationCount, 'hidden');
                    }
                }
                else
                {
                    console.log('Error: ' + xhr.status); // An error occurred during the request.
                }
            }
        };

        xhr.send(null);
    },

    /**
     * Toggle menu state
     */
    toggleMenuState: function()
    {
        // toggle
        this.collapsed = !this.collapsed;

        // update dom
        this.toggleClass(this.body, 'navigation-collapsed');

        // store
        localStorage.setItem('collapsed', this.collapsed);
    },


    /**
     * Toggle dom class
     * @param element
     * @param className
     */
    toggleClass: function(element, className)
    {
        element.classList.toggle(className);
    }

};
