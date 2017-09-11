/**
 * Mimoto - Form
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Mimoto input classes
let FormField = require('./FormField');


module.exports = function(elForm) {

    // start
    this.__construct(elForm);
};

module.exports.prototype = {

    // elements
    _elForm: null,
    _aFormFields: [],

    // settings
    _sFormName: '',
    _sAction: '',
    _sMethod: '',
    _bManualSave: false,
    _sPublicKey: null,
    _actions: null,

    // state
    _bHasChanges: false,

    // utils
    _autosaveTimer: null,

    // form setting directives
    DIRECTIVE_MIMOTO_FORM_NAME:       'data-mimoto-form-name',
    DIRECTIVE_MIMOTO_FORM_ACTION:     'data-mimoto-form-action',
    DIRECTIVE_MIMOTO_FORM_METHOD:     'data-mimoto-form-method',
    DIRECTIVE_MIMOTO_FORM_PUBLICKEY:  'data-mimoto-form-publickey',
    DIRECTIVE_MIMOTO_FORM_INSTANCEID: 'data-mimoto-form-instanceid',
    DIRECTIVE_MIMOTO_FORM_MANUALSAVE: 'data-mimoto-form-manualsave',
    DIRECTIVE_MIMOTO_FORM_ACTIONS:    'data-mimoto-form-actions',

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
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------


    _getName: function()
    {
        return this._sFormName;
    },



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    _parseForm: function(elForm)
    {
        // 1. collect
        this._elForm = elForm;
        this._sFormName = elForm.getAttribute(this.DIRECTIVE_MIMOTO_FORM_NAME);
        this._sAction = elForm.getAttribute(this.DIRECTIVE_MIMOTO_FORM_ACTION);
        this._sMethod = elForm.getAttribute(this.DIRECTIVE_MIMOTO_FORM_METHOD);
        this._sPublicKey = elForm.getAttribute(this.DIRECTIVE_MIMOTO_FORM_PUBLICKEY);
        this._nInstanceId = elForm.getAttribute(this.DIRECTIVE_MIMOTO_FORM_INSTANCEID);
        this._bManualSave = (elForm.getAttribute(this.DIRECTIVE_MIMOTO_FORM_MANUALSAVE) === 'true');

        // 2. collect
        let sActions = elForm.getAttribute(this.DIRECTIVE_MIMOTO_FORM_ACTIONS);
        if (sActions.length > 0) this._actions = JSON.parse(sActions);

        // 3. get fields
        let aFormFields = elForm.querySelectorAll('[' + this.DIRECTIVE_MIMOTO_FORM_FIELD + ']');

        // 4. parse input fields
        let nFormFieldCount = aFormFields.length;
        for (let nFormFieldIndex = 0; nFormFieldIndex < nFormFieldCount; nFormFieldIndex++)
        {
            // a. register
            let elFormField = aFormFields[nFormFieldIndex];

            // b. init
            let formField = new FormField(elFormField);

            // c. configure
            elFormField.addEventListener('onMimotoFormfieldChanged', this._onFormFieldChanged.bind(this), true);

            // d. store
            this._aFormFields.push(formField);
        }

    },

    _onFormFieldChanged: function(e)
    {
        // verify and trigger
        if (!this._bManualSave) this._startAutosave();
    },


    _startAutosave: function()
    {
        if (!this._autosaveTimer)
        {
            // register
            let classRoot = this;

            // init
            this._autosaveTimer = setTimeout(function(){ classRoot._executeAutoSave(); }, 1000);
        }
    },

    _executeAutoSave: function()
    {
        // cleanup
        clearTimeout(this._autosaveTimer);
        delete(this._autosaveTimer);

        Mimoto.log('Auto saving ... ');

        this.submit();
    },

    /**
     * Submit form
     */
    submit: function()
    {
        // init
        let aChangedFields = {};
        let bChangesFound = false;

        // add changed fields
        let nFormFieldCount = this._aFormFields.length;
        for (let nFormFieldIndex = 0; nFormFieldIndex < nFormFieldCount; nFormFieldIndex++)
        {
            // register
            let formField = this._aFormFields[nFormFieldIndex];

            // verify
            if (formField.hasChanges())
            {
                // toggle
                bChangesFound = true;

                // store
                aChangedFields[formField.getFieldValue()] = formField.getChanges();
            }
        }

        // setup
        let requestData = {
            publicKey: this._sPublicKey,
            instanceId: this._nInstanceId,
            actions: this._actions,
            changedFields: aChangedFields
        };

        // 11. send data
        Mimoto.utils.callAPI({
            type: this._sMethod,
            url: this._sAction,
            data: requestData,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething)
            {
                Mimoto.log('Form submitted', resultData);

                this._updateForm(resultData)
            }.bind(this)
        });

    },

    _updateForm: function(resultData)
    {
        if (resultData.errors && resultData.errors.length > 0)
        {
            Mimoto.log('Errors were found');
        }
        else
        {
            Mimoto.log('Form submit SUCCESS');

            // update all fields
            let nFormFieldCount = this._aFormFields.length;
            for (let nFormFieldIndex = 0; nFormFieldIndex < nFormFieldCount; nFormFieldIndex++)
            {
                // register
                let formField = this._aFormFields[nFormFieldIndex];

                // forward
                formField.acceptChanges();
            }
        }

        if (resultData.newEntities)
        {
            for (let sEntityType in resultData.newEntities)
            {

                let newEntity = resultData.newEntities[sEntityType];


                // update all fields
                let nFormFieldCount = this._aFormFields.length;
                for (let nFormFieldIndex = 0; nFormFieldIndex < nFormFieldCount; nFormFieldIndex++)
                {
                    // register
                    let formField = this._aFormFields[nFormFieldIndex];

                    // forward
                    formField.updatePropertySelector(newEntity.selector, newEntity.id);
                }
            }
        }


        if (resultData.newPublicKey)
        {
            // update
            this._sPublicKey = resultData.newPublicKey;
            this._elForm.setAttribute(this.DIRECTIVE_MIMOTO_FORM_PUBLICKEY, this._sPublicKey);
        }

        if (resultData.newEntityId)
        {
            // update
            this._nInstanceId = parseInt(resultData.newEntityId);
            this._elForm.setAttribute(this.DIRECTIVE_MIMOTO_FORM_INSTANCEID, this._nInstanceId);
        }


        // --- execute actions


        if (this._actions && this._actions.response)
        {
            Mimoto.warn('this._actions.response', this._actions.response);

            if (this._actions.response.onSuccess)
            {
                if (this._actions.response.onSuccess.loadPage)
                {
                    window.open(this._actions.response.onSuccess.loadPage, '_self');
                }
                else if (this._actions.response.onSuccess.closePopup)
                {
                    Mimoto.closePopup();
                }
                else if (this._actions.response.onSuccess.reloadPopup)
                {
                    Mimoto.popup.replace(this._actions.response.onSuccess.reloadPopup);
                }
                else if (this._actions.response.onSuccess.dispatchEvent)
                {
                    console.log('form.responseSettings.onSuccess.dispatchEvent', this._actions.response.onSuccess.dispatchEvent);
                }
            }
        }
    }

}
