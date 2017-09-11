/**
 * Mimoto - InputField - Checkbox
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


module.exports = function(elInput) {

    // start
    this.__construct(elInput);
};

module.exports.prototype = {

    // dom
    _elInput: null,



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(elInput)
    {
        // store
        this._elInput = elInput;

        // configure
        this._elInput.addEventListener('input', function(e) { this._broadcastChange(); }.bind(this));
        this._elInput.addEventListener('change', function(e) { this._broadcastChange(); }.bind(this));
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    getValue: function()
    {
        // send
        return this._elInput.checked;
    },

    setValue: function(value)
    {

        this._elInput.checked = (value === true);
    },



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    _broadcastChange: function(elInput)
    {
        this._elInput.dispatchEvent(new Event('onMimotoInputChanged'));
    }

}
