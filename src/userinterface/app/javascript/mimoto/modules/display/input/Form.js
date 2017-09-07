/**
 * Mimoto - Form
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Mimoto input classes
let InputField = require('./InputField');


module.exports = function(elForm) {

    // start
    this.__construct(elForm);
};

module.exports.prototype = {

    // elements
    _aInputFields: [],

    // settings
    _bAutoSave: false,
    _sPublicKey: null,

    // state
    _bHasChanges: false,


    // form setting directives
    DIRECTIVE_MIMOTO_FORM_AUTOSAVE:    'data-mimoto-form-autosave',
    DIRECTIVE_MIMOTO_FORM_PUBLICKEY:   'data-mimoto-form-publickey',

    // form field directives
    DIRECTIVE_MIMOTO_FORM_FIELD:       'data-mimoto-form-field',


    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(elForm)
    {
        this._parseForm(elForm);
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------





    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    _parseForm: function(elForm)
    {
        // 1. register
        this._sPublicKey = elForm.getAttribute(this.DIRECTIVE_MIMOTO_FORM_PUBLICKEY);
        this._bAutoSave = (elForm.getAttribute(this.DIRECTIVE_MIMOTO_FORM_AUTOSAVE) === 'true');

        // 2. get fields
        let aInputFieldElements = elForm.querySelectorAll('[' + this.DIRECTIVE_MIMOTO_FORM_FIELD + ']');


        console.log('aInputFieldElements', aInputFieldElements);


        // 3. parse input fields
        let nInputFieldCount = aInputFieldElements.length;
        for (let nInputFieldIndex = 0; nInputFieldIndex < nInputFieldCount; nInputFieldIndex++)
        {
            // a. register
            let elInputField = aInputFieldElements[nInputFieldIndex];

            // b. init
            let inputField = new InputField(elInputField);

            // c. store
            this._aInputFields.push(inputField);
        }

    }

}
