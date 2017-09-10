/**
 * Mimoto - InputField - Textline
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
        return this._elInput.value;
    },

    setValue: function(value)
    {
        this._elInput.value = value;
    },



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    _broadcastChange: function()
    {
        this._elInput.dispatchEvent(new Event('changed'));
    }

}
