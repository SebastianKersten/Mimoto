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
        console.log('Connecting user');

        // setup
        //this._socket = new io('http://localhost:4000');
        this._socket = new io('http://192.168.178.42.xip.io:4000');


        var classRoot = this;

        // listen to socket
        this._socket.on('connect', function() { classRoot._socketOnConnect(); });
        this._socket.on('disconnect', function() { classRoot._socketOnDisconnect(); });
        this._socket.on('logon', function(data) { classRoot._socketOnLogon(data); });
    },



    // ----------------------------------------------------------------------------
    // --- Private methods text management ----------------------------------------
    // ----------------------------------------------------------------------------


    _socketOnConnect: function()
    {

        // 1. logon with php
        console.log('User connected.');
        console.log('Logging on user ...');

        // 2. authenticate
        Mimoto.Aimless.utils.callAPI({
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
        console.warn('Connection with server was lost .. reconnecting ..');

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
        console.log('User `' + data.user.name + '` is logged on.');
        console.log('===========================================================');

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
