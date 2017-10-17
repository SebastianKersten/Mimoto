/**
 * Mimoto.Publisher - Demo "Cursor position"
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
    _aOthersCurrentlyTyping: [],

    // dom
    _elIsTypingMessage: null,



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
        this._elIsTypingMessage = document.querySelector('[data-publisher-conversation-istypingmessage]');

        //configure
        channel.onSelfConnected = this._onSelfConnected.bind(this);

        // configure
        channel.receive('isTyping', this._onOtherIsTyping.bind(this));

        //configure
        channel.element.addEventListener('input', this._onInput.bind(this));
    },



    // ----------------------------------------------------------------------------
    // --- Event listeners --------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Handle SELF-CONNECTED
     * @private
     */
    _onSelfConnected: function()
    {
        // broadcast
        this._channel.identify({ firstName: Mimoto.user.firstName });
    },

    /**
     * Handle INPUT
     * @private
     */
    _onInput: function()
    {
        // send
        this._channel.send('isTyping');
    },

    /**
     * Handle OTHER-ISTYPING
     * @param clientId The client's id
     * @private
     */
    _onOtherIsTyping: function(clientId)
    {
        // 1. register
        let publicInfo = this._channel.getInfo(clientId);

        // 2. validate  or init
        if (!this._aOthersCurrentlyTyping[clientId]) this._aOthersCurrentlyTyping[clientId] = { clientId:clientId, firstName:publicInfo.firstName };

        // 3. load
        let other = this._aOthersCurrentlyTyping[clientId];

        // 4. store (in milliseconds)
        other.since = new Date().getTime();

        // 5. update
        this._updateIsTypingMessage();
    },


    _updateIsTypingMessage: function()
    {
        // stop
        if (this._timer){ clearTimeout(this._timer); delete this._timer; }


        // ---


        // 1. init
        let aOthersNames = [];

        // 2. register (in milliseconds)
        let nCurrentTimestamp = new Date().getTime();

        // 3. search or cleanup
        for (let clientId in this._aOthersCurrentlyTyping)
        {
            // validate
            if (this._aOthersCurrentlyTyping[clientId].since + 2500 < nCurrentTimestamp)
            {
                // a. cleanup
                delete this._aOthersCurrentlyTyping[clientId];
            }
            else
            {
                // b. register
                aOthersNames.push(this._aOthersCurrentlyTyping[clientId].firstName)
            }
        }


        // ---


        // init
        let sMessage = '';

        // compose
        let nUserCount = aOthersNames.length;
        for (let nUserIndex = 0; nUserIndex < nUserCount; nUserIndex++)
        {
            // build
            sMessage += aOthersNames[nUserIndex];

            // connect
            if (nUserIndex < nUserCount - 1)
            {
                sMessage += (nUserCount === 2 || nUserIndex === nUserCount - 2) ? ' and ' : ', ';
            }
        }

        // update interface
        if (nUserCount === 0)
        {
            // cleanup
            this._elIsTypingMessage.innerHTML = '&nbsp;';
        }
        else
        {
            this._elIsTypingMessage.innerText = sMessage + ' ' + ((nUserCount === 1) ? 'is' : 'are') + ' typing ..';
        }


        // ---


        // validate
        if (aOthersNames.length > 0) this._timer = setTimeout(function() { this._updateIsTypingMessage(); }.bind(this), 100);
    }

};
