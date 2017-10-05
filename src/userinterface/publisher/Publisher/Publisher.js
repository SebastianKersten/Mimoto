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



    isTyping: function(channel)
    {
        Mimoto.warn('Publisher.isTyping was called with', channel);
        Mimoto.warn('this', this);


        // register
        this._elIsTypingMessage = document.querySelector('[data-publisher-conversation-istypingmessage]');

        this._updateIsTypingMessage(channel.element);



        // register
        let classRoot = this;


        channel.element.addEventListener('focus', function() {

            console.log('Focus of field');

            // broadcast
            channel.send('startsTyping', { firstName: Mimoto.user.firstName });
        });

        channel.element.addEventListener('blur', function() {

            console.log('Blur of field');

            // broadcast
            channel.send('stopsTyping', { firstName: Mimoto.user.firstName });
        });

        channel.receive('startsTyping', function(data)
        {
            // register
            classRoot._aUsersInCommentField.push(data.firstName);

            // update
            classRoot._updateIsTypingMessage(channel.element);

        });

        channel.receive('stopsTyping', function(data)
        {
            // cleanup - #todo needs public id or id provided by realtime.js
            let nUserCount = classRoot._aUsersInCommentField.length;
            for (let nUserIndex = 0; nUserIndex < nUserCount; nUserIndex++)
            {
                // verify
                if (classRoot._aUsersInCommentField[nUserIndex] === data.firstName)
                {
                    // remove
                    classRoot._aUsersInCommentField.splice(nUserIndex, 1);
                    break;
                }
            }

            // update
            classRoot._updateIsTypingMessage(channel.element);
        })
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
            sMessage += (nUserCount === 2 || nUserIndex === nUserCount - 2) ? ' and ' : ', ';
        }

        console.warn('sMessage', sMessage);

        // update interface
        if (nUserCount === 0)
        {
            // cleanup
            this._elIsTypingMessage.innerHTML = '&nbsp;';
        }
        else
        {
            this._elIsTypingMessage.innerText = sMessage + ' ' + ((nUserCount === 1) ? 'is' : 'are') + 'typing ..';
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
