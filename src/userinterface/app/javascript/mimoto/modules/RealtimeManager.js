/**
 * Mimoto - RealtimeManager - Manages realtime updates and collaboration
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Mimoto classes
var RealtimeEditor = require('./RealtimeEditor');

// Socket.io classes
var io = require('socket.io-client');

// Quill classes
var Quill = require("quill");



module.exports = function(sGateway)
{
    // start
    this.__construct(sGateway);
};

module.exports.prototype = {


    // connection
    _socket: null,


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(sGateway)
    {
        // log
        if (MimotoX.debug) console.log('Connecting user');


        if (!sGateway)
        {
            // register
            let classRoot = this;

            // 2. authenticate
            MimotoX.utils.callAPI({
                type: 'get',
                url: '/mimoto.cms/initialize',
                dataType: 'json',
                success: function(resultData, resultStatus, resultSomething)
                {
                    if (resultData.formattingOptions)
                    {
                        classRoot._configureEditor(resultData.formattingOptions);
                    }

                    classRoot._connect(resultData.gateway);
                }
            });
        }
        else
        {
            this._connect(sGateway);
        }
    },



    // ----------------------------------------------------------------------------
    // --- Private methods text management ----------------------------------------
    // ----------------------------------------------------------------------------


    _connect: function(sGateway)
    {
        // setup
        this._socket = new io(sGateway);

        // register
        let classRoot = this;

        // logon events
        this._socket.on('connect', function() { classRoot._socketOnConnect(); });
        this._socket.on('disconnect', function() { classRoot._socketOnDisconnect(); });
        this._socket.on('logon', function(data) { classRoot._socketOnLogon(data); });

        // data events
        this._socket.on('data.changed', function(data) { MimotoX.dom.onDataChanged(data); });
        this._socket.on('data.created', function(data) { MimotoX.dom.onDataCreated(data); });

        // user interface events
        this._socket.on('page.change', function(data) { MimotoX.dom.onPageChange(data); });
        this._socket.on('component.load', function(data) { MimotoX.dom.onComponentLoad(data); });
        this._socket.on('popup.open', function(data) { MimotoX.dom.onPopupOpen(data); });
    },

    _socketOnConnect: function()
    {
        // 1. logon with php
        if (MimotoX.debug) console.log('User connected.');
        if (MimotoX.debug) console.log('Logging on user ...');

        // 2. authenticate
        MimotoX.utils.callAPI({
            type: 'get',
            url: '/mimoto.cms/logon',
            data: { id: this._socket.id },
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething)
            {
                //console.log('Authenticate request finished');
            }
        });

    },

    _socketOnDisconnect: function()
    {
        if (MimotoX.debug) console.warn('Connection with server was lost .. reconnecting ..');

        // cleanup
        delete this._aRealtimeEditors;
    },

    /**
     * Handle socket on 'logon'
     * This event is received when this client is successfully authenticated by Mimoto
     * @param data
     * @private
     */
    _socketOnLogon: function(data)
    {
        if (MimotoX.debug) console.log('User `' + data.user.name + '` is logged on.');
        if (MimotoX.debug) console.log('===========================================================');

        // connect editable values
        this._setupEditableValues();
    },

    /**
     * Configure editor
     */
    _configureEditor: function(aFormattingOptions)
    {
        if (MimotoX.debug) console.log('Configuring editor ...', aFormattingOptions);



        let classes = {};


        // add formatting options
        let nFormattingOptionCount = aFormattingOptions.length;
        for (let nFormattingOptionIndex = 0; nFormattingOptionIndex < nFormattingOptionCount; nFormattingOptionIndex++)
        {
            // register
            let formattingOption = aFormattingOptions[nFormattingOptionIndex];


            console.log('Formatting options ' + nFormattingOptionIndex, JSON.stringify(formattingOption, null, 2));


            switch(formattingOption.type)
            {
                case 'inline':


                    classes['item_' + nFormattingOptionIndex] = Quill.import('blots/inline');
                    //let Inline = Quill.import('blots/inline');

                    //console.warn(Inline);

                    //let customInlineBlot = formattingOption.name;



                    classes[formattingOption.name] = class extends classes['item_' + nFormattingOptionIndex]
                    {
                        static create(value)
                        {

                            let node = super.create(value);

                            // Sanitize url value if desired
                            //node.setAttribute('data-mimoto-type-id', value);
                            node.setAttribute('data-mimoto-format-' + formattingOption.name, value);
                            node.setAttribute('class', formattingOption.name);

                            // Okay to set other non-format related attributes
                            // These are invisible to Parchment so must be static
                            //node.setAttribute('target', 'ohyeah');

                            console.log('xx', node, this.name);

                            node.addEventListener('click', function() { window[formattingOption.jsEditor](); });

                            node.style['cursor'] = 'pointer';

                            return node;
                        }

                        static formats(node) {
                            // We will only be called with a node already
                            // determined to be a Link blot, so we do
                            // not need to check ourselves
                            return node.getAttribute('data-mimoto-format-' + formattingOption.name); // 1. type check bij meerdere types
                        }
                    }

                    classes[formattingOption.name].blotName = formattingOption.name;
                    classes[formattingOption.name].tagName = formattingOption.tagName;

                    Quill.register('formats/' + formattingOption.name, classes[formattingOption.name]);

                    break;
            }
        }


        console.warn(Quill.imports);

        // 1. build options
        // 1. add options



    },






    /**
     * Setup editable values
     * @private
     */
    _setupEditableValues: function()
    {
        // search
        let aEditableValues = document.querySelectorAll('[data-mimoto-editable]');

        // init
        this._aRealtimeEditors = [];

        // setup
        let nEditableValueCount = aEditableValues.length;
        for (let nEditableValueIndex = 0; nEditableValueIndex < nEditableValueCount; nEditableValueIndex++)
        {
            // register
            let editableValue = aEditableValues[nEditableValueIndex];

            // read
            let sPropertySelector = editableValue.getAttribute('data-mimoto-editable');

            //console.log('editable', sPropertySelector, editOptions, editableValue);

            // init
            let realtimeEditor = new RealtimeEditor(this._socket, sPropertySelector, editableValue);


            // store
            this._aRealtimeEditors.push(realtimeEditor);
        }
    }

}
