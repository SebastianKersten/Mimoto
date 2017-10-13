/**
 * Mimoto.Publisher - Demo - How to build a publication platform
 *
 * @author Sebastian Kersten (@supertaboo)
 */


'use strict';


// Mimoto classes
let Article = require('../Article/Article');
let Editor = require('../Editor/Editor');

let AlsoOnThisPage = require('./presence/AlsoOnThisPage');
let IsTypingComment = require('./presence/IsTypingComment');


module.exports = function() {

    // start
    this.__construct();
};

module.exports.prototype = {

    // presence
    _alsoOnThisPage: null,
    _isTypingComment: null,



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
        this._alsoOnThisPage = new AlsoOnThisPage(channel);
    },

    isTypingComment: function(channel)
    {
        this._isTypingComment = new IsTypingComment(channel);
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
