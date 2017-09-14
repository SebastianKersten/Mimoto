/**
 * Mimoto - InputField
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Quill classes
var Quill = require('quill');


module.exports = function(sFieldSelector, elInputField) {

    // start
    this.__construct(sFieldSelector, elInputField);
};

module.exports.prototype = {






    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(sFieldSelector, elInputField)
    {
        // store
        this._sFieldSelector = sFieldSelector;

        // parse
        this._parseInputField(elInputField);
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    getValue: function()
    {

    },



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    setupTextblock: function(sFieldId, sFlatFieldId, sInputFieldId, sPlaceHolder)
    {
        // read
        var currentForm = this._aForms[this._sCurrentOpenForm];

        // validate
        if (!currentForm) return;



        // 1. locate form in dom
        var $form = $('form[name="' + currentForm.sName + '"]');

        // register
        var field = $('[data-mimoto-form-field="' + sInputFieldId + '"]', $form);
        var fieldInput = $("input", field);

        // setup
        var textblockField = {
            domElement: document.getElementById(sFieldId),
            sFieldId: sFieldId,
            field: field,
            fieldInput: fieldInput
        };

        // store
        this._aTextblockFields[sFieldId] = textblockField;


        // register
        var classRoot = document;


        let valueContainer = document.getElementById('js-' + sFlatFieldId + '-textblock-container');
        let $valueHolder = $('js-' + sFlatFieldId + '-textblock-value', $form);


        //console.warn('fieldInput', fieldInput.attr('data-mimoto-form-input-formattingoptions'));
        //var fieldForFormattingOptions = $('[data-mimoto-form-field="' + sInputFieldId + '"]', $form);

        let s


        // init
        var toolbar = null;
        var formats = null;

        var sFormattingOptions = fieldInput.attr('data-mimoto-form-input-formattingoptions');

        if (sFormattingOptions)
        {
            var formattingOptions = JSON.parse(sFormattingOptions);

            toolbar = formattingOptions.toolbar;
            formats = formattingOptions.formats;
        }



        // create
        textblockField.quill = new Quill(valueContainer, {
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
        fieldInput.val(valueContainer.getElementsByClassName("ql-editor")[0].innerHTML);


        textblockField.quill.on('text-change', function(delta, oldContents, source)
        {
            textblockField.fieldInput.val(valueContainer.getElementsByClassName("ql-editor")[0].innerHTML);
        });
    },



}
