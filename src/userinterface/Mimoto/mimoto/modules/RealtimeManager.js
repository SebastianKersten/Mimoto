/**
 * Mimoto - RealtimeManager - Manages realtime updates and collaboration
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Mimoto classes
let RealtimeEditor = require('./RealtimeEditor');
let DataChannel = require('./collaboration/DataChannel');

// Socket.io classes
let io = require('socket.io-client');

// Quill classes
let Quill = require("quill");



module.exports = function(sGateway)
{
    // start
    this.__construct(sGateway);
};

module.exports.prototype = {


    // connection
    _socket: null,
    _sGateway: null,
    _aDataChannels: [],



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(sGateway)
    {
        // log
        Mimoto.log('Connecting user');

        // store
        this._sGateway = sGateway;


        if (!sGateway)
        {
            // register
            let classRoot = this;

            // 2. authenticate
            Mimoto.utils.callAPI({
                type: 'get',
                url: '/' + Mimoto.projectName + '/initialize',
                dataType: 'json',
                success: function(resultData, resultStatus, resultSomething)
                {
                    if (resultData.formattingOptions)
                    {
                        classRoot._configureEditor(resultData.formattingOptions);
                    }

                    // store
                    classRoot._sGateway = resultData.gateway;

                    // connect
                    classRoot._connect();
                }
            });
        }
        else
        {
            // connect
            this._connect();
        }
    },




    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Create data channel
     * @param sSelector
     * @param sDelegate
     * @returns false is error in paramaters | channel object if everything ok
     */
    createDataChannel: function(sSelector)
    {
        // init
        let dataChannel = new DataChannel(sSelector);

        // store
        this._aDataChannels.push(dataChannel);

        // send
        return dataChannel;
    },

    _connectDataChannels: function()
    {
        // connect all
        let nDataChannelCount = this._aDataChannels.length;
        for (let nDataChannelIndex = 0; nDataChannelIndex < nDataChannelCount; nDataChannelIndex++)
        {
            this._aDataChannels[nDataChannelIndex]._connect(this._socket);
        }
    },



    // ----------------------------------------------------------------------------
    // --- Private methods text management ----------------------------------------
    // ----------------------------------------------------------------------------


    _connect: function()
    {
        // register


        // setup
        this._socket = new io(this._sGateway);

        // register
        let classRoot = this;

        // logon events
        this._socket.on('connect', function() { classRoot._socketOnConnect(); });
        this._socket.on('connect_failed', function() { classRoot._socketConnectFailed(); });
        this._socket.on('disconnect', function() { classRoot._socketOnDisconnect(); });
        this._socket.on('logon', function(data) { classRoot._socketOnLogon(data); });

        // data events
        this._socket.on('data.changed', function(data) { Mimoto.dom.onDataChanged(data); });
        //this._socket.on('data.created', function(data) { Mimoto.dom.onDataCreated(data); });

        // user interface events
        this._socket.on('page.change', function(data) { Mimoto.dom.onPageChange(data); });
        this._socket.on('component.load', function(data) { Mimoto.dom.onComponentLoad(data); });
        this._socket.on('popup.open', function(data) { Mimoto.dom.onPopupOpen(data); });
    },

    _socketOnConnect: function()
    {
        // 1. logon with php
        Mimoto.log('User connected'); // (socket id = ' + this._socket.id + ')');
        Mimoto.log('Logging on user ...');

        // 2. authenticate
        Mimoto.utils.callAPI({
            type: 'post',
            url: '/' + Mimoto.projectName + '/logon',
            data: { id: this._socket.id },
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething)
            {
                //console.log('Authenticate request finished');
            }
        });

    },

    _socketConnectFailed: function()
    {
        console.log('You are logged off .. trying to connect ...');

    },

    _socketOnDisconnect: function()
    {
        Mimoto.warn('Connection with server was lost .. reconnecting ..');

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
        // store
        Mimoto.user = data.user;

        // report
        Mimoto.log('User `' + Mimoto.user.firstName + ' ' + Mimoto.user.lastName + '` is logged on.');
        Mimoto.log('===========================================================');

        // connect editable values
        this._setupEditableValues();

        // connect
        this._connectDataChannels();
    },

    /**
     * Configure editor
     */
    _configureEditor: function(aFormattingOptions)
    {
        //Mimoto.log('Configuring editor ...');


        // init
        let classes = {};

        // register
        let classRoot = this;


        // add formatting options
        let nFormattingOptionCount = aFormattingOptions.length;
        for (let nFormattingOptionIndex = 0; nFormattingOptionIndex < nFormattingOptionCount; nFormattingOptionIndex++)
        {
            // register
            let formattingOption = aFormattingOptions[nFormattingOptionIndex];


            //console.log('Formatting options ' + nFormattingOptionIndex, JSON.stringify(formattingOption, null, 2));


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



                            // compose
                            let formatAdapter = {
                                node: node,
                            };


                            if (formattingOption.jsOnAdd)
                            {
                                // execute
                                let bResult = classRoot._executeEventHandler(formattingOption.jsOnAdd, formatAdapter);

                                // report
                                if (!bResult) Mimoto.log('Cannot find onAdd formatting function `' + formattingOption.jsOnAdd + '`. Check the admin /mimoto.cms/configuration/formatting to check is you are using the correct function name');
                            }

                            // connect
                            if (formattingOption.jsOnEdit)
                            {
                                node.addEventListener('click', function()
                                {
                                    // execute
                                    let bResult = classRoot._executeEventHandler(formattingOption.jsOnEdit, formatAdapter);

                                    // report
                                    if (!bResult) Mimoto.log('Cannot find onEdit formatting function `' + formattingOption.jsOnEdit + '`. Check the admin /mimoto.cms/configuration/formatting to check is you are using the correct function name');
                                });

                                // style
                                node.style['cursor'] = 'pointer';
                            }

                            // send
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
    },

    /**
     * Setup editable values
     * @private
     */
    _executeEventHandler: function(sHandler, formatAdapter)
    {
        // split
        let aMethodElements = sHandler.split('.');

        // validate
        let fHandler = window;
        let bExecuted = false;
        let nMethodElementCount = aMethodElements.length;
        for (let nMethodElementIndex = 0; nMethodElementIndex < nMethodElementCount; nMethodElementIndex++)
        {
            // register
            fHandler = fHandler[aMethodElements[nMethodElementIndex]];

            // verify
            if (nMethodElementIndex === nMethodElementCount - 1)
            {
                // validate
                if (fHandler && typeof fHandler === 'function')
                {
                    // execute
                    fHandler(formatAdapter);
                    bExecuted = true;
                    break;
                }
            }
            else
            {
                if (!fHandler) break;
            }
        }

        // send
        return bExecuted;
    },

}
