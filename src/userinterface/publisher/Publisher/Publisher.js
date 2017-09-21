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

    //
    // isTyping: function(channel)
    // {
    //     channel.element.addEventListener('focus', function() {
    //
    //        channel.send({
    //            action: 'isTyping',
    //            user_firstName: Mimoto.user.firstName
    //        })
    //     });
    //
    //     channel.receive( function(data){
    //         if (data.action == 'isTyping')
    //         {
    //             elIsTyping.innerText = data.user_firstName + ' is typing'
    //         }
    //
    //     })
    // },


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
