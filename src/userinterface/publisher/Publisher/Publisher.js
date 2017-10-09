/**
 * Mimoto.Publisher - Demo - How to build a publication platform
 *
 * @author Sebastian Kersten (@supertaboo)
 */


'use strict';


// Mimoto classes
let Article = require('../Article/Article');
let Editor = require('../Editor/Editor');


module.exports = function() {

    // start
    this.__construct();
};

module.exports.prototype = {


    // feature: is typing
    _aUsersInCommentField: [],
    _elIsTypingMessage: null,
    _isTypingChannel: null,
    _alsoOnThisPageChannel: null,
    _aClientsOnThisPage: [],



    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------


    article: null,
    editor: null,



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function()
    {
        // connect
        this._setupArticle();
    },



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    alsoOnThisPage: function(channel)
    {
        // register
        this._alsoOnThisPageChannel = channel;

        //channel.onOtherJoined = function(client) {
        channel.onConnected = function() {

            // broadcast
            channel.send('join', { firstName: Mimoto.user.firstName, lastName: Mimoto.user.lastName, avatar: Mimoto.user.avatar });

        }.bind(this);

        // //channel.onOtherJoined = function(client) {
        // channel.onOtherConnected = function(clientId) {
        //
        //     this._aClientsOnThisPage[clientId] = {
        //         isNew: true
        //     }
        //
        // }.bind(this);

        //channel.onOtherLeft = function(client) {
        channel.onOtherDisconnected = function(clientId)
        {
            Mimoto.log('OTHER DISCONNECTED');

            if (!this._aClientsOnThisPage[clientId]) return;



            this._aClientsOnThisPage[clientId].isToBeRemoved = true;

            this._updateAlsoOnThisPage(data, clientId);
            
            delete this._aClientsOnThisPage[clientId];

        }.bind(this);



        channel.receive('join', function(data, clientId)
        {
            this._aClientsOnThisPage[clientId] = {
                isNew: true,
                firstName: data.firstName,
                lastName: data.lastName,
                avatar: data.avatar
            };

            this._updateAlsoOnThisPage(data, clientId);

        }.bind(this));
    },



    _updateAlsoOnThisPage: function(data, userId)
    {
        
        for (let clientId in this._aClientsOnThisPage)
        {
            // register
            let client = this._aClientsOnThisPage[clientId];
            

            if (client.isNew)
            {
                // reset
                delete client.isNew;

                // init
                client.element = this._alsoOnThisPageChannel.element.querySelector('[data-publisher-article-others-other-template]').cloneNode();

                // add
                this._alsoOnThisPageChannel.element.querySelector('[data-publisher-article-others-container]').appendChild(client.element);

                // register
                let elAvatarInitials = this._alsoOnThisPageChannel.element.querySelector('[data-publisher-article-others-other-initials]');

                // set data
                if (client.avatar) client.element.setAttribute('style', 'background-image:url(' + client.avatar + ');');


                elAvatarInitials.innerText = client.firstName.substr(0, 1).toUpperCase() + client.lastName.substr(0, 1).toUpperCase();


                console.log('isNew!');
            }

            if (client.isToBeRemoved)
            {
                // reset
                delete client.isToBeRemoved;

                console.log('isToBeRemoved!');


                client.element.parentNode.removeChild(client.element);
            }
        }
    },



    // -----------
    
    

    isTypingComment: function(channel)
    {
        // register
        this._isTypingChannel = channel;

        // find and register
        this._elIsTypingMessage = document.querySelector('[data-publisher-conversation-istypingmessage]');



        // initial setup
        this._updateIsTypingMessage(channel.element);



        channel.element.addEventListener('focus', function() {

            // broadcast
            channel.send('startsTyping', { firstName: Mimoto.user.firstName });
        });

        channel.element.addEventListener('blur', function() {

            // broadcast
            channel.send('stopsTyping', { firstName: Mimoto.user.firstName });
        });

        channel.receive('startsTyping', function(data)
        {
            // register
            this._aUsersInCommentField.push(data.firstName);

            // update
            this._updateIsTypingMessage(channel.element);

        }.bind(this));

        channel.receive('stopsTyping', function(data)
        {
            // cleanup - #todo needs public id or id provided by realtime.js
            let nUserCount = this._aUsersInCommentField.length;
            for (let nUserIndex = 0; nUserIndex < nUserCount; nUserIndex++)
            {
                // verify
                if (this._aUsersInCommentField[nUserIndex] === data.firstName)
                {
                    // remove
                    this._aUsersInCommentField.splice(nUserIndex, 1);
                    break;
                }
            }

            // update
            this._updateIsTypingMessage(channel.element);

        }.bind(this))
    },

    _updateIsTypingMessage: function(element)
    {
        // init
        let sMessage = '';

        // compose
        let nUserCount = this._aUsersInCommentField.length;
        for (let nUserIndex = 0; nUserIndex < nUserCount; nUserIndex++)
        {
            // build
            sMessage += this._aUsersInCommentField[nUserIndex];

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

    },
    


    /**
     * Setup article
     * @private
     */
    _setupArticle: function()
    {
        // init
        const ARTICLE_SELECTOR = 'data-js-article';

        // search
        let articleElement = document.querySelector('[' + ARTICLE_SELECTOR + ']');

        // verify
        if (!articleElement) return;


        console.log('Setting up article and editor ...');


        // read
        let nArticleId = articleElement.getAttribute(ARTICLE_SELECTOR);

        // create
        this.article = new Article(nArticleId);
        this.editor = new Editor(nArticleId);
    }

};
