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


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function ()
    {
        // setup
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
        // collect
        let aPanelElements = elTabmenu.querySelectorAll('[data-mimotocms-tabmenu-tab]');
        let elTabTemplate = elTabmenu.querySelector('[data-mimotocms-tabmenu-tab-template]');
        let elTabContainer = elTabmenu.querySelector('[data-mimotocms-tabmenu-tab-container]');

        // cleanup
        elTabTemplate.parentNode.removeChild(elTabTemplate);
        elTabTemplate.classList.remove('hidden');

        // init
        let nTabmenuIndex = this._aTabmenus.length;
        this._aTabmenus[nTabmenuIndex] = [];

        // setup
        let nPanelCount = aPanelElements.length;
        for (let nPanelIndex = 0; nPanelIndex < nPanelCount; nPanelIndex++)
        {
            // register
            let elPanel = aPanelElements[nPanelIndex];

            // create and connect
            let elTab = elTabContainer.appendChild(elTabTemplate.cloneNode(true));

            // setup
            this._setupTab(elTab, elPanel, nPanelIndex === 0, nTabmenuIndex);

            // store
            this._aTabmenus[nTabmenuIndex].push( { elTab: elTab, elPanel: elPanel } );
        }
    },

    _setupTab: function(elTab, elPanel, bIsFirst, nTabmenuIndex)
    {
        // setup
        elTab.innerText = elPanel.getAttribute('data-mimotocms-tabmenu-tab');

        // focus
        if (bIsFirst) { this._focusTab(elTab, elPanel); }

        // register
        let classRoot = this;

        // configure
        elTab.addEventListener('click', function(elTab, elPanel, e)
        {
            // forward
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
        elTab.classList.add("active");
        elPanel.classList.remove("hidden");
    },

    /**
     * Blur tab
     */
    _blurTab: function(elTab, elPanel)
    {
        elTab.classList.remove("active");
        elPanel.classList.add("hidden");
    }

}
