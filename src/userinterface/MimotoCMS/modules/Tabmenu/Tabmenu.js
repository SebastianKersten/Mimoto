/**
 * Mimoto.CMS - TabMenuService
 *
 * @author Sebastian Kersten (@supertaboo)
 */


'use strict';


module.exports = function() {

    this._aTabmenus = [];

    // start
    this.__construct();
};

module.exports.prototype = {


    _sActiveTabId: null,
    _bHasFocusedRequestedTab: false,


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function ()
    {
        // 1. read active tab
        var sCurrentUrl = document.URL;
        var aUrlParts   = sCurrentUrl.split('#');
        this._sActiveTabId = (aUrlParts.length > 1) ? aUrlParts[1] : null;

        // 2. setup
        this._setupTabMenus();
    },



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Setup tab menus
     * @private
     */
    _setupTabMenus: function()
    {
        // collect
        let aTabmenuElements = document.querySelectorAll('[data-mimotocms-tabmenu]');

        // setup
        let nTabmenuCount = aTabmenuElements.length;
        for (let nTabmenuIndex = 0; nTabmenuIndex < nTabmenuCount; nTabmenuIndex++)
        {
            // register
            let elTabmenu = aTabmenuElements[nTabmenuIndex];

            // setup
            this._setupTabs(elTabmenu);
        }
    },

    /**
     * Setup tabs
     * @private
     */
    _setupTabs: function(elTabmenu)
    {
        // 1. register
        let elTabContainer = elTabmenu.querySelector('[data-mimotocms-tabmenu-tabcontainer]');
        let elPanelContainer = elTabmenu.querySelector('[data-mimotocms-tabmenu-panelcontainer]');

        // 2. collect
        let aTabElements = elTabContainer.querySelectorAll('[data-mimotocms-tabmenu-tab]');
        let aPanelElements = elPanelContainer.querySelectorAll('[data-mimotocms-tabmenu-panel]');

        // 3. init
        let nTabmenuIndex = this._aTabmenus.length;
        this._aTabmenus[nTabmenuIndex] = [];

        // 4. setup
        let tabToFocus = null;
        let nTabCount = aTabElements.length;
        for (let nTabIndex = 0; nTabIndex < nTabCount; nTabIndex++)
        {
            // register
            let elTab = aTabElements[nTabIndex];

            // verify
            if (!aPanelElements[nTabIndex]) break;

            // register
            let elPanel = aPanelElements[nTabIndex];

            // setup
            this._setupTab(elTab, elPanel, nTabmenuIndex);

            // store
            this._aTabmenus[nTabmenuIndex].push( { elTab: elTab, elPanel: elPanel } );


            // --- prepare focus of reqeusted tab

            // init
            if (!tabToFocus) tabToFocus = { elTab: elTab, elPanel: elPanel, nTabmenuIndex:nTabmenuIndex };

            // update
            if (this._getTabName(elTab) === this._sActiveTabId) tabToFocus = { elTab: elTab, elPanel: elPanel, nTabmenuIndex:nTabmenuIndex };
        }

        // 5. focus requested tab
        if (!this._bHasFocusedRequestedTab)
        {
            // a. focus
            this._selectTab(tabToFocus.elTab, tabToFocus.elPanel, tabToFocus.nTabmenuIndex);

            // b. toggle
            this._bHasFocusedRequestedTab = true;
        }
    },

    _setupTab: function(elTab, elPanel, nTabmenuIndex)
    {
        // register
        let classRoot = this;

        // configure
        elTab.addEventListener('click', function(elTab, elPanel, e)
        {
            classRoot._selectTab(elTab, elPanel, nTabmenuIndex);

        }.bind(this, elTab, elPanel), true);
    },

    /**
     * Check menu state
     */
    _selectTab: function(elTab, elPanel, nTabmenuIndex)
    {
        // register
        let aTabmenuItems = this._aTabmenus[nTabmenuIndex];

        // toggle
        let nTabCount = aTabmenuItems.length;
        for (let nTabIndex = 0; nTabIndex < nTabCount; nTabIndex++)
        {
            // register
            let tabmenuItem = aTabmenuItems[nTabIndex];

            // verify
            if (tabmenuItem.elTab === elTab)
            {
                this._focusTab(tabmenuItem.elTab, tabmenuItem.elPanel);
            }
            else
            {
                this._blurTab(tabmenuItem.elTab, tabmenuItem.elPanel);
            }
        }
    },

    /**
     * Focus tab
     */
    _focusTab: function(elTab, elPanel)
    {
        // 1. update display
        elTab.classList.add("active");
        elPanel.classList.remove("Mimoto--hidden");

        // 2. update address bar
        window.location.href = "#" + this._getTabName(elTab);
    },

    /**
     * Blur tab
     */
    _blurTab: function(elTab, elPanel)
    {
        elTab.classList.remove("active");
        elPanel.classList.add("Mimoto--hidden");
    },

    _getTabName: function(elTab)
    {
        // 1. read, convert and send
        return elTab.textContent.replace(/\s+/g, '-').toLowerCase();
    }

}
