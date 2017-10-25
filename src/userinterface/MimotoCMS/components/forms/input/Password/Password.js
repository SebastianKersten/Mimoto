/**
 * Mimoto - InputField - Textline
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


let PasswordStrengthTest = require('owasp-password-strength-test');


module.exports = function(elFormField, fBroadcast, elInput) {

    // start
    this.__construct(elFormField, fBroadcast, elInput);
};

module.exports.prototype = {

    // dom
    _elFormField: null,
    _fBroadcast: null,
    _elInput: null,

    // elements
    _elPasswordStrength: null,
    _aPasswordStrengthBlocks: [],

    // states
    GOOD: 'good',
    MEDIUM: 'medium',
    BAD: 'bad',



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

        // register
        this._elPasswordStrength = elFormField.querySelector('[data-mimoto-form-input-password-strength]');
        this._aPasswordStrengthBlocks = this._elPasswordStrength.querySelectorAll('div');

        // configure
        this._elInput.addEventListener('input', function(e) { this._checkPasswordStrength(); this._fBroadcast(); }.bind(this));
        this._elInput.addEventListener('change', function(e) { this._checkPasswordStrength(); this._fBroadcast(); }.bind(this));
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


    _checkPasswordStrength: function()
    {
        // test
        let result = PasswordStrengthTest.test(this.getValue());

        // sum
        let nErrorCount = result.errors.length + result.optionalTestErrors.length;

        // toggle colors
        let nBlockCount = this._aPasswordStrengthBlocks.length;
        for (let nBlockIndex = 0; nBlockIndex < nBlockCount; nBlockIndex++)
        {
            // register
            let elBlock = this._aPasswordStrengthBlocks[nBlockIndex];

            // colorize
            if (this.getValue().length < 4)
            {
                this._colorizeStrengthBlock(elBlock, this.BAD);
            }
            else
            {
                if (nErrorCount >= (nBlockIndex * 2 + 2)) this._colorizeStrengthBlock(elBlock, this.BAD);
                else if (nErrorCount >= (nBlockIndex * 2 + 1)) this._colorizeStrengthBlock(elBlock, this.MEDIUM);
                else this._colorizeStrengthBlock(elBlock, this.GOOD);
            }
        }

        // show
        this._elPasswordStrength.classList.remove('Mimoto--hidden');
    },

    _colorizeStrengthBlock: function(elBlock, sState)
    {
        // 1. init
        const STATE_PREFIX = 'MimotoCMS_forms_input_Password-strengthblock--';

        // 2. reset
        elBlock.classList.remove(STATE_PREFIX + this.GOOD);
        elBlock.classList.remove(STATE_PREFIX + this.MEDIUM);
        elBlock.classList.remove(STATE_PREFIX + this.BAD);

        // 3. toggle
        elBlock.classList.add(STATE_PREFIX + sState);
    }

}
