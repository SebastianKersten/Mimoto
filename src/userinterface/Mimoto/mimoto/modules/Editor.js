/**
 * Mimoto.CMS - Editor
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Quill classes
var Quill = require("quill");
var QuillDelta = require("quill-delta");


module.exports = function(sPropertySelector, elEditableField, formattingOptions) {


    // start
    this.__construct(sPropertySelector, elEditableField, formattingOptions);
};

module.exports.prototype = {

    _quill: null,
    _deltaPending: null,
    _documentPending: null,
    _deltaBuffer: null,

    _sPropertySelector: null,
    _elEditableField: null,
    _formattingOptions: null,
    _otid: null,


    _baseDocument: null,

    _user: null,


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(sPropertySelector, elEditableField, formattingOptions)
    {
        // register
        this._sPropertySelector = sPropertySelector;
        this._elEditableField = elEditableField;
        this._formattingOptions = formattingOptions;
        
        // show content
        this._quill = this._setupEditor(formattingOptions);
    },


    enable: function()
    {
        Mimoto.log('Enabled ?');
        this._quill.enable();
    },

    disable: function()
    {
        this._quill.disable();
    },

    getValue: function()
    {
        return this._elEditableField.getElementsByClassName("ql-editor")[0].innerHTML;
    },



    // ----------------------------------------------------------------------------
    // --- Private methods text management ----------------------------------------
    // ----------------------------------------------------------------------------



    _setupEditor: function(formattingOptions)
    {
        // init
        var toolbar = null;
        var formats = null;


        if (formattingOptions)
        {
            if (formattingOptions.toolbar && formattingOptions.toolbar.length > 0) toolbar = formattingOptions.toolbar;
            if (formattingOptions.formats && formattingOptions.formats.length > 0) formats = formattingOptions.formats;
        }

        // create
        let quill = new Quill(this._elEditableField, {
            theme: 'bubble',
            modules: {
                toolbar: toolbar,
                history: {
                    delay: 2000,
                    maxStack: 500,
                    userOnly: true
                }
            },
            placeholder: 'Start typing', // #todo
            formats: formats
        });


        // configure
        //quill.on('selection-change', function() { this._onSelectionChange(); }.bind(this);
        //quill.on('text-change', function(delta, oldContents, source) { this._onTextChange(delta, oldContents, source); }.bind(this) );


        // send
        return quill;
    }

}
