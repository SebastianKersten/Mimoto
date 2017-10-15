/**
 * Mimoto.Publisher - Demo "Is typing"
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


    _onSelfConnected: function()
    {
        // broadcast
        this._channel.identify({ firstName: Mimoto.user.firstName });
    },

    _onInput: function()
    {

        Mimoto.log('Is typing ... onInput ...');


        this._channel.send('isTyping');
    },

    _onOtherIsTyping: function(clientId, message)
    {

        // add to array if not in_array

        Mimoto.log('Is typing', this._channel.getInfo(clientId));


        // register
        this._aOthersCurrentlyTyping.push(data.firstName);

        // update
        //this._updateIsTypingMessage(channel.element);


    },


    _updateIsTypingMessage: function(element)
    {
        // init
        let sMessage = '';

        // compose
        let nUserCount = this._aOthersCurrentlyTyping.length;
        for (let nUserIndex = 0; nUserIndex < nUserCount; nUserIndex++)
        {
            // build
            sMessage += this._aOthersCurrentlyTyping[nUserIndex];

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

    }

};
