/**
 * Mimoto - InputField - Checkbox
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


module.exports = function(aInputElements) {

    // start
    this.__construct(aInputElements);
};

module.exports.prototype = {

    // dom
    _aInputElements: null,



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(aInputElements)
    {
        // store
        this._aInputElements = aInputElements;

        // configure
        let nInputElementCount = this._aInputElements.length;
        for (let nInputElementIndex = 0; nInputElementIndex < nInputElementCount; nInputElementIndex++)
        {
            // register
            let elInput = this._aInputElements[nInputElementIndex];

            // configure
            elInput.addEventListener('input', function(e) { this._broadcastChange(elInput); }.bind(this));
            elInput.addEventListener('change', function(e) { this._broadcastChange(elInput); }.bind(this));
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
    },



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    _broadcastChange: function(elInput)
    {
        elInput.dispatchEvent(new Event('onMimotoInputChanged'));
    }

}
