/**
 * Mimoto.Publisher - Demo - How to build a publication platform
 *
 * @author Sebastian Kersten (@supertaboo)
 */


'use strict';


module.exports = function(nArticleId)
{
    // start
    this.__construct(nArticleId);
};

module.exports.prototype = {


    _nArticleId: null,


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(nArticleId)
    {
        // register
        this._nArticleId = nArticleId;
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Add a comment to the article
     * @param nArticleId
     */
    addComment: function()
    {
        // register
        let commentForm = document.getElementById('commentForm');

        // call
        Mimoto.utils.callAPI({
            type: 'post',
            url: "/publisher/article/" + this._nArticleId + "/comment/add",
            data: {message: commentForm.value},
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething) {
                commentForm.value = '';
                window.scrollTo(0,document.body.scrollHeight);
            }
        });
    },

    /**
     * Report a comment
     * @param nCommentId
     */
    reportComment: function(nCommentId)
    {
        // call
        Mimoto.utils.callAPI({
            type: 'post',
            url: "/publisher/comment/" + nCommentId + "/remove",
            data: {message: commentForm.value},
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething) {
                console.log('Comment reported');
            }
        });
    },

    /**
     * Highlight comment
     * @param nCommentId
     */
    highlightComment: function(nCommentId)
    {
        // call
        Mimoto.utils.callAPI({
            type: 'post',
            url: "/publisher/comment/" + nCommentId + "/highlight",
            data: null,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething) {
                console.log('Comment highlighted');
            }
        });
    },

    /**
     * Unhighlight comment
     * @param nCommentId
     */
    unhighlightComment: function(nCommentId)
    {
        // call
        Mimoto.utils.callAPI({
            type: 'post',
            url: "/publisher/comment/" + nCommentId + "/unhighlight",
            data: null,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething) {
                console.log('Comment unhighlighted');
            }
        });
    }

};
