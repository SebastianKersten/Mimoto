/**
 * Mimoto - InputField - Multiselect
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


module.exports = function(elFormField, fBroadcast, aInputElements) {

    // start
    this.__construct(elFormField, fBroadcast, aInputElements);
};

module.exports.prototype = {

    // dom
    _elFormField: null,
    _fBroadcast: null,
    _aInputElements: null,



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(elFormField, fBroadcast, aInputElements)
    {
        // store
        this._elFormField = elFormField;
        this._fBroadcast = fBroadcast;
        this._aInputElements = aInputElements;

        // configure
        let nInputElementCount = this._aInputElements.length;
        for (let nInputElementIndex = 0; nInputElementIndex < nInputElementCount; nInputElementIndex++)
        {
            // register
            let elInput = this._aInputElements[nInputElementIndex];

            // configure
            elInput.addEventListener('input', function(e) { this._fBroadcast(); }.bind(this));
            elInput.addEventListener('change', function(e) { this._fBroadcast(); }.bind(this));
        }
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    getValue: function()
    {
        // init
        let aValues = [];

        // configure
        let nInputElementCount = this._aInputElements.length;
        for (let nInputElementIndex = 0; nInputElementIndex < nInputElementCount; nInputElementIndex++)
        {
            // register
            let elInput = this._aInputElements[nInputElementIndex];

            // verify
            if (elInput.checked) { aValues.push(elInput.value); }
        }

        // send
        return JSON.stringify(aValues);
    },

    setValue: function(value)
    {
        // convert
        let aValues = (value.length > 0) ? JSON.parse(value) : [];

        // configure
        let nInputElementCount = this._aInputElements.length;
        for (let nInputElementIndex = 0; nInputElementIndex < nInputElementCount; nInputElementIndex++)
        {
            // register
            let elInput = this._aInputElements[nInputElementIndex];

            // verify
            elInput.checked = (aValues.includes(elInput.value));
        }
    }

}
