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




    _updateAlsoOnThisPage: function(userId)
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




                console.log('isNew!');
            }


        }
    },


    _toggleAlsoOnThisPageVisibility: function()
    {



        let bHasItems = false;
        for (let sKey in this._aClientsOnThisPage) { bHasItems = true; break; }


        Mimoto.warn('!this._aClientsOnThisPage', !this._aClientsOnThisPage, bHasItems);

        // toggle visibility
        if (!bHasItems)
        {
            this._alsoOnThisPageChannel.element.classList.add('Mimoto_CoreCSS_hidden');
        }
        else
        {
            this._alsoOnThisPageChannel.element.classList.remove('Mimoto_CoreCSS_hidden');
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
