/**
 * Mimoto.CMS - Data service for data manipulation
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


module.exports = function() {

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
        MimotoX.log('Initializing data service ...');



    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    page: null,
    popup: null,
    hidden: null,


    edit: function(sEntitySelector, sFormName, options) {

        let postData = {
            sEntitySelector: sEntitySelector,
            sFormName: sFormName,
            options: options
        };

        MimotoX.popup('/mimoto/data/edit', postData);
    },

    add: function(sPropertySelector, sFormName, options) {

        let postData = {
            sPropertySelector: sPropertySelector,
            sFormName: sFormName,
            options: options
        };

        MimotoX.popup('/mimoto/data/add', postData);
    },


    remove: function(sEntitySelector, options)
    {
        // bDontConfirm
        // onInit=confirmMethod,
        // onSubmit:waiting,
        // onSuccess,
        // onError,
        // onConfirm:null -> new Confirmation()->confirm() or ->deny() or nothing)


        console.log('Remove this entity .. ' + sEntitySelector);

        let postData = {
            sEntitySelector: sEntitySelector,
            options: options
        };


        MimotoX.utils.callAPI({
            type: 'POST',
            url: '/mimoto/data/remove',
            data: postData,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething)
            {
                console.log('Item removed', resultData);
            }
        });
    },

    select: function(sPropertySelector, xSelection, options) {

        let postData = {
            sPropertySelector: sPropertySelector,
            xSelection: xSelection,
            options: options
        };

        MimotoX.popup('/mimoto/data/select', postData);
    },

    set: function(sPropertySelector, value, options) {

        let postData = {
            sPropertySelector: sPropertySelector,
            value: value,
            options: options
        };

        MimotoX.utils.callAPI({
            type: 'post',
            url: '/mimoto/data/set',
            data: postData,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething) {
                MimotoX.closePopup();
            }
        });
    },

    create: function(sPropertySelector, sEntityName, options) {

        let postData = {
            sPropertySelector: sPropertySelector,
            sEntityName: sEntityName,
            options: options
        };

        MimotoX.utils.callAPI({
            type: 'post',
            url: '/mimoto/data/create',
            data: postData,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething) {

            }
        });
    },

    clear: function(sPropertySelector, options) {

        let postData = {
            sPropertySelector: sPropertySelector,
            options: options
        };

        MimotoX.utils.callAPI({
            type: 'post',
            url: '/mimoto/data/clear',
            data: postData,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething) {

            }
        });
    },
    
}
