/**
 * Mimoto - InputField - Radiobutton
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
        let value = null;

        // configure
        let nInputElementCount = this._aInputElements.length;
        for (let nInputElementIndex = 0; nInputElementIndex < nInputElementCount; nInputElementIndex++)
        {
            // register
            let elInput = this._aInputElements[nInputElementIndex];

            // verify
            if (elInput.checked)
            {
                value = elInput.value;
                break;
            }
        }

        // send
        return value;
    },

    setValue: function(value)
    {
        // configure
        let nInputElementCount = this._aInputElements.length;
        for (let nInputElementIndex = 0; nInputElementIndex < nInputElementCount; nInputElementIndex++)
        {
            // register
            let elInput = this._aInputElements[nInputElementIndex];

            // verify
            if (elInput.value == value)
            {
                elInput.checked = true;
                break;
            }
        }
    },



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    _broadcastChange: function(elInput)
    {
        elInput.dispatchEvent(new Event('changed'));
    }

}
