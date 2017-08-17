/**
 * Mimoto.CMS - Collaboration service for data manipulation
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


    remove: function(sEntityselector, options)
    {
        // bDontConfirm
        // onInit=confirmMethod,
        // onSubmit:waiting,
        // onSuccess,
        // onError,
        // onConfirm:null -> new Confirmation()->confirm() or ->deny() or nothing)
    },

    update: function(sPropertySelector, value)
    {

    },





    createAndConnect: function(sType, sPropertySelector, options) // -> sets onclick
    {
        MimotoX.log('Clicked on createAndConnect .. start the call');
    },




    // /**
    //  * Handle data CHANGED
    //  */
    // setValue: function(sPropertySelector, xSelection, xVars)
    // {
    //
    //     // 1. xSelection = ..
    //     // .. string (name of the predefined selection)
    //     // .. json (with query params)
    //
    //     // 2. xVars = ..
    //     // .. object (with vars)
    //     // .. string (propertyselector)
    // },

    selectAndAdd: function(sPropertySelector, xSelection, xVars)
    {

        console.log(sPropertySelector, xSelection);





        let request = {
            sPropertySelector: sPropertySelector,
            xSelection: xSelection,
            xVars: xVars
        };

        MimotoX.popup('/mimoto/data/select', request);

        // 1. render component (direct of with mapping)
        // 2. mapping info in dom
        // 3. open popup
        // 4. show result of simple selection (with mapping?)
        // 5. connect vars
        // 6. select item
        // 7. close popup


        // 1. setValue(value)
        // 2. Mimoto.data.select('article.3.author', )
        // 3. selectAndAddToCollection()

        // 4. clearValue
        // 5. removeValue(connectionId)


        // flatten selection and store in Selection definition


        // Mimoto.data.selectAndSet('selectionRule.3.type', 'allEntities', {vars});
        // Mimoto.data.selectAndSet('selectionRule.3.id', 'allInstancesOfType', {type:<selectionRule.3.type>});
        // Mimoto.data.selectAndSet('selectionRule.3.property', 'allPropertiesOfInstance', {type:<selectionRule.3.type>, id:<selectionRule.3.id>});


        // Mimoto.data.addValue('selectionRule.3.type', {type:'_Mimoto_entity'});

    },


    // 1. delete
    // 2. create


    /**
     * Handle data CHANGED
     */
    addValue: function(sPropertySelector, xSelection, xVars)
    {

        // 1. xSelection = ..
        // .. string (name of the predefined selection)
        // .. json (with query params)

        // 2. xVars = ..
        // .. object (with vars)
        // .. string (propertyselector)
    }
    
}
