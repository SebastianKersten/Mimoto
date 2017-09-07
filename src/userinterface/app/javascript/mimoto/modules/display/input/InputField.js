/**
 * Mimoto - Form
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


module.exports = function(elInputField) {

    // start
    this.__construct(elInputField);
};

module.exports.prototype = {


    // form field directives
    DIRECTIVE_MIMOTO_FORM_FIELD_TYPE:  'data-mimoto-form-field-type',
    DIRECTIVE_MIMOTO_FORM_FIELD_INPUT: 'data-mimoto-form-field-input',
    DIRECTIVE_MIMOTO_FORM_FIELD_ERROR: 'data-mimoto-form-field-error',


    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(elInputField)
    {

    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------





    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    _parseForm: function(elForm)
    {

    }

}
