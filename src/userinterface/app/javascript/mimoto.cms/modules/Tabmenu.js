'use strict';

module.exports = function(sTabmenuId, aTabs) {

    // register
    this._sTabmenuId = sTabmenuId;
    this._aTabs = aTabs;

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
    __construct: function()
    {
        // setup
        this._setupTabs();
    },



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Setup tabs
     */
    _setupTabs: function()
    {
        // init
        var classRoot = this;

        var nTabCount = this._aTabs.length;
        for (var i = 0; i < nTabCount; i++)
        {
            // register
            var tab = this._aTabs[i];

            // connect
            tab.$tab = document.getElementById(tab.id);
            tab.$panel = document.getElementById(tab.panel_id);

            // setup
            if (i == 0) { this._showPanel(tab.$panel); } else { this._hidePanel(tab.$panel); }

            // connect
            tab.$tab.addEventListener('click', function(tab) {
                this._selectTab(tab);
            }.bind(this, tab));
        }
    },

    /**
     * Check menu state
     */
    _selectTab: function(selectedTab)
    {
        var nTabCount = this._aTabs.length;
        for (var i = 0; i < nTabCount; i++)
        {
            // register
            var tab = this._aTabs[i];

            if (tab == selectedTab)
            {
                this._showPanel(tab.$panel);
                this._activateTab(tab.$tab);
            }
            else
            {
                this._hidePanel(tab.$panel);
                this._deactivateTab(tab.$tab);
            }
        }
    },

    /**
     * Activate tab
     */
    _activateTab: function($tab)
    {
        $tab.classList.add("active");
    },

    /**
     * Deactivate tab
     */
    _deactivateTab: function($tab)
    {
        $tab.classList.remove("active");
    },

    /**
     * Show panel
     */
    _showPanel: function($panel)
    {
        $panel.classList.remove("hidden");
    },

    /**
     * Hide panel
     */
    _hidePanel: function($panel)
    {
        $panel.classList.add("hidden");
    }

};
