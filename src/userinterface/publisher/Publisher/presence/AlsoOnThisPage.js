/**
 * Mimoto.Publisher - Demo "Also on this page"
 *
 * @author Sebastian Kersten (@supertaboo)
 */


'use strict';


module.exports = function(channel) {

    // start
    this.__construct(channel);
};

module.exports.prototype = {

    // communication
    _channel: null,
    _others: [],

    // dom
    _elOtherTemplate: null,
    _elOtherContainer: null,



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(channel)
    {
        // store
        this._channel = channel;

        // register
        this._elOtherTemplate = channel.element.querySelector('[data-publisher-article-others-other-template]');
        this._elOtherContainer = channel.element.querySelector('[data-publisher-article-others-container]');

        //configure
        channel.onSelfConnected = this._onSelfConnected.bind(this);
        channel.onOtherConnected = this._onOtherConnected.bind(this);
        channel.onOtherIdentified = this._onOtherIdentified.bind(this);
        channel.onOtherDisconnected = this._onOtherDisconnected.bind(this);
    },



    // ----------------------------------------------------------------------------
    // --- Event listeners --------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * HANDLE SELF-CONNECTED
     * @param aOthers array List of ids of others already on this page
     * @private
     */
    _onSelfConnected: function(aOthers)
    {
        // 1. init
        this._initOthersAlreadyOnPage(aOthers);

        // 2. broadcast
        this._channel.identify({ firstName: Mimoto.user.firstName, lastName: Mimoto.user.lastName, avatar: Mimoto.user.avatar });
    },

    /**
     * HANDLE OTHER-CONNECTED
     * @param clientId
     * @private
     */
    _onOtherConnected: function(clientId)
    {
        // add
        this._addOther(clientId);
    },

    /**
     * HANDLE OTHER-IDENTIFIED
     * @param clientId
     * @private
     */
    _onOtherIdentified: function(clientId)
    {
        this._showPublicInfo(clientId);
    },

    /**
     * HANDLE OTHER-DISCONNECTED
     * @param clientId
     * @private
     */
    _onOtherDisconnected: function(clientId)
    {
        // 1. verify if user was known
        if (!this._others[clientId]) return;

        // 2. register
        let elOther = this._others[clientId].element;

        // 3. remove
        elOther.parentNode.removeChild(elOther);

        // 4. cleanup
        delete this._others[clientId];

        // 5. update
        this._toggleVisibility();
    },



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Init others already on this page
     * @param aOthers
     * @private
     */
    _initOthersAlreadyOnPage: function(aOthers)
    {
        // build
        let nOtherCount = aOthers.length;
        for (let nOtherIndex = 0; nOtherIndex < nOtherCount; nOtherIndex++)
        {
            // register
            let clientId = aOthers[nOtherIndex];

            // add
            this._addOther(clientId);

            // show public info
            this._showPublicInfo(clientId);
        }
    },

    /**
     * Add other client to AlsoOnThisPage som element
     * @param clientId
     * @private
     */
    _addOther: function(clientId)
    {
        // create
        let elOther = this._elOtherTemplate.cloneNode(true);

        // connect
        this._elOtherContainer.appendChild(elOther);

        // store
        this._others[clientId] = { element: elOther };

        // update
        this._toggleVisibility();
    },

    /**
     * Show other client's public info
     * @param clientId
     * @private
     */
    _showPublicInfo: function(clientId)
    {
        // verify if user was known
        if (!this._others[clientId]) return;

        // register
        let clientInfo = this._channel.getInfo(clientId);

        // validate
        if (!clientInfo) return;

        // register
        let elOther = this._others[clientId].element;
        let elAvatarInitials = elOther.querySelector('[data-publisher-article-others-other-initials]');

        // set data
        if (clientInfo.avatar)
        {
            elOther.setAttribute('style', 'background-image: url("' + clientInfo.avatar + '");');
            elAvatarInitials.innerText = '';
        }
        else
        {
            elAvatarInitials.innerText = clientInfo.firstName.substr(0, 1).toUpperCase() + clientInfo.lastName.substr(0, 1).toUpperCase();
        }
    },

    /**
     * Toggle visibility of the AlsoInPage dom element
     * @private
     */
    _toggleVisibility: function()
    {
        // find other
        let bHasItems = false;
        for (let clientId in this._others) { bHasItems = true; break; }

        // toggle
        this._channel.element.style.visibility = (!bHasItems) ? 'hidden' : 'visible';
    }

};
