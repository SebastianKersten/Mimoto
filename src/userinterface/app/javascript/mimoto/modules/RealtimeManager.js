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



module.exports = function()
{
    // start
    this.__construct();
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
    __construct: function()
    {
        // log
        if (MimotoX.debug) console.log('Connecting user');


        // 1. get correct port if not supplied via constructor

        // setup
        this._socket = new io('http://localhost:4000');
        //this._socket = new io('http://192.168.178.227.xip.io:4000');

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



    // ----------------------------------------------------------------------------
    // --- Private methods text management ----------------------------------------
    // ----------------------------------------------------------------------------


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
        delete this.aRealtimeEditors;
    },

    /**
     * Handle socket on 'logon'
     * This event is received when this client is successfully authenticated by Mimoto
     * @param user
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
     * Setup editable values
     * @private
     */
    _setupEditableValues: function()
    {
        // search
        var aEditableValues = document.querySelectorAll('[data-mimoto-editable]');

        // init
        this._aRealtimeEditors = [];

        // setup
        var nEditableValueCount = aEditableValues.length;
        for (var nEditableValueIndex = 0; nEditableValueIndex < nEditableValueCount; nEditableValueIndex++)
        {
            // register
            var editableValue = aEditableValues[nEditableValueIndex];

            // read
            var sPropertySelector = editableValue.getAttribute('data-mimoto-editable');
            var editOptions = JSON.parse(editableValue.getAttribute('data-mimoto-editable-options'));

            //console.log('editable', sPropertySelector, editOptions, editableValue);


            // init
            var realtimeEditor = new RealtimeEditor(this._socket, sPropertySelector, editOptions, editableValue);


            // store
            this._aRealtimeEditors.push(realtimeEditor);
        }
    }

}
