/**
 * Mimoto - InputField
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// RubaXa classes
var Sortable = require('sortablejs');


module.exports = function(sFieldSelector, elInputField) {

    // start
    this.__construct(sFieldSelector, elInputField);
};

module.exports.prototype = {


    // form field directives
    DIRECTIVE_MIMOTO_FORM_FIELD_TYPE:  'data-mimoto-form-field-type',
    DIRECTIVE_MIMOTO_FORM_FIELD_INPUT: 'data-mimoto-form-field-input',
    DIRECTIVE_MIMOTO_FORM_FIELD_ERROR: 'data-mimoto-form-field-error',

    // settings
    _sType: null,
    _sFieldSelector: null,

    // elements
    _elInput: null,
    _elError: null,

    // state
    _bHasChanged: false,
    _bHasPendingChanges: false,



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



        // verify
        if (sAimlessInputType == 'list')
        {
            // find
            var listInputField = document.querySelectorAll('[data-mimoto-form-field="' + sInputFieldId + '"]');
            var listElement = listInputField[0].querySelectorAll('.js-list');

            // read
            var bIsSortable = listElement[0].classList.contains('js-list-sortable');

            // verify
            if (bIsSortable)
            {
                var sortable = new Sortable(listElement[0], {
                    group: sInputFieldId,
                    handle: '.MimotoCMS_forms_input_ListItem-handle',
                    dragClass: 'MimotoCMS_forms_input_ListItem--drag',
                    ghostClass: 'MimotoCMS_forms_input_ListItem--ghost',
                    onEnd: function (e)
                    {
                        // adjust
                        classPath._changeOrder(e.from, e.item, e.oldIndex, e.newIndex)
                    }
                });
            }
        }
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





    _changeOrder: function(htmlParentElement, htmlChildElement, nOldIndex, nNewIndex)
    {
        // register
        var sPropertySelector = htmlParentElement.getAttribute('data-mimoto-collection');
        var nConnectionId = htmlChildElement.getAttribute('data-mimoto-connection');
        var nCurrentSortindex = htmlChildElement.getAttribute('data-mimoto-sortindex');

        // validate
        if (!sPropertySelector || !nConnectionId || !nCurrentSortindex) return;

        // store
        Mimoto.utils.callAPI({
            type: 'get',
            url: '/mimoto.cms/form/list/sort/' + sPropertySelector + '/' + nConnectionId + '/' + nOldIndex + '/' + nNewIndex,
            success: function(resultData, resultStatus, resultSomething)
            {
                //console.log('Mimoto ===> I received a response from the FormController::updateSortindex!');
            }
        });
    },



}
