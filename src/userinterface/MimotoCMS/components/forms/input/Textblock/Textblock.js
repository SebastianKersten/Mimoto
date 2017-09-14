/**
 * Mimoto - InputField - Textblock
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Quill classes
let Quill = require('quill');


module.exports = function(elFormField, fBroadcast, elInput) {

    // start
    this.__construct(elFormField, fBroadcast, elInput);
};

module.exports.prototype = {

    // dom
    _elFormField: null,
    _fBroadcast: null,
    _elInput: null,

    // utils
    _quill: null,



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(elFormField, fBroadcast, elInput)
    {
        // store
        this._elFormField = elFormField;
        this._fBroadcast = fBroadcast;
        this._elInput = elInput;




        // init
        var toolbar = null;
        var formats = null;

        var sFormattingOptions = this._elInput.getAttribute('data-mimoto-form-input-formattingoptions');

        if (sFormattingOptions)
        {
            var formattingOptions = JSON.parse(sFormattingOptions);

            toolbar = formattingOptions.toolbar;
            formats = formattingOptions.formats;
        }

        let sPlaceHolder = this._elInput.getAttribute('data-mimoto-form-input-textblock-placeholder');


        // create
        this._quill = new Quill(this._elInput, {
            theme: 'bubble',
            modules: {
                toolbar: toolbar,
                // toolbar: [
                //     ['bold', 'italic', 'underline', 'strike'],
                //     ['blockquote', 'code-block', 'link'],
                //     [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                //     [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                //     [{ 'indent': '-1'}, { 'indent': '+1' }],
                // ],
                history: {
                    delay: 2000,
                    maxStack: 500,
                    userOnly: true
                }
            },
            placeholder: sPlaceHolder || '', // #todo
            // formats: ['bold', 'italic', 'underline', 'strike', 'blockquote', 'code-block', 'link', 'header', 'list', 'indent']
            formats: formats
        });


        // 1. set initial value
        //this._elInput.getElementsByClassName("ql-editor")[0].innerHTML;


        this._quill.on('text-change', function(delta, oldContents, source)
        {
            //textblockField.fieldInput.val(valueContainer.getElementsByClassName("ql-editor")[0].innerHTML);
            this._fBroadcast();

        }.bind(this));
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    getValue: function()
    {
        return this._elInput.getElementsByClassName("ql-editor")[0].innerHTML;
    },

    setValue: function(value)
    {
        this._elInput.getElementsByClassName("ql-editor")[0].innerHTML = value;
    }

}
