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
        this.initConversationCount();

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

        this.dropdownToggles = this.el.querySelectorAll('.js-dropdown-toggle');
        this.dropdownClass = 'js-dropdown';
        this.dropdownActiveClass = 'header-menu-dropdown--active';

        this.collapsed = false;

        this.notificationCount = document.getElementById('header_notification_count');
        this.conversationCount = document.getElementById('header_conversation_count');
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

        if (this.dropdownToggles.length && this.dropdownClass)
        {
/*
            var rect = this.dropdownToggles[0].getBoundingClientRect();
            console.log(rect.top, rect.right, rect.bottom, rect.left);
*/

            // var bodyRect = document.body.getBoundingClientRect(),
            //     elemRect = element.getBoundingClientRect(),
            //     offset   = elemRect.top - bodyRect.top;
            //
            // alert('Element is ' + offset + ' vertical pixels from <body>');

            for (var i = 0; i < this.dropdownToggles.length; i++) {

                this.dropdownToggles[i].addEventListener('click', function (e) {
                    this.toggleDropdown(e);
                }.bind(this));

            }
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
                    // convert
                    var data = JSON.parse(this.responseText);

                    if (parseInt(data.count) > 0)
                    {
                        // update counter
                        classRoot.notificationCount.innerText = data.count;
                        classRoot.notificationCount.classList.remove('hidden');

                        // add notifications
                        classRoot.el.querySelector('.js-messages').innerHTML = data.notifications;
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
     * Init conversation count
     */
    initConversationCount: function()
    {
        
        // setup
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/mimoto.cms/conversations/count');
        
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
                    // convert
                    var data = JSON.parse(this.responseText);
                    
                    if (parseInt(data.count) > 0)
                    {
                        // update counter
                        classRoot.conversationCount.innerText = data.count;
                        classRoot.conversationCount.classList.remove('hidden');
                        
                        // add notifications
                        classRoot.el.querySelector('.js-messages').innerHTML = data.conversations;
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
    },

    toggleDropdown: function (event) {

        var target = event.currentTarget;

        target.nextElementSibling.classList.toggle(this.dropdownActiveClass);

    }

};
