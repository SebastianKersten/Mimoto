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



class RealtimeManagerX
{

    private _socket = null;


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    constructor()
    {
        // log
        console.log('X Connecting user');

        // setup
        this._socket = new io('http://localhost:4000');
        //this._socket = new io('http://192.168.178.227.xip.io:4000');


        let classRoot = this;

        // listen to socket
        this._socket.on('connect', function() { classRoot._socketOnConnect(); });
        this._socket.on('disconnect', function() { classRoot._socketOnDisconnect(); });
        this._socket.on('logon', function(data) { classRoot._socketOnLogon(data); });
    }



    // ----------------------------------------------------------------------------
    // --- Private methods text management ----------------------------------------
    // ----------------------------------------------------------------------------


    private _socketOnConnect()
    {

        // 1. logon with php
        console.log('User connected.');
        console.log('Logging on user ...');

        // 2. authenticate
        Mimoto.utils.callAPI({
            type: 'get',
            url: '/mimoto.cms/logon',
            data: { id: this._socket.id },
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething)
            {
                //console.log('Authenticate request finished');
            }
        });
    }

    private _socketOnDisconnect()
    {
        console.warn('Connection with server was lost .. reconnecting ..');

        // cleanup
        delete this.aRealtimeEditors;
    }

    /**
     * Handle socket on 'logon'
     * This event is received when this client is successfully authenticated by Mimoto
     * @param user
     * @private
     */
    private _socketOnLogon(data)
    {
        console.log('User `' + data.user.name + '` is logged on.');
        console.log('===========================================================');

        // connect editable values
        this._setupEditableValues();
    }

    /**
     * Setup editable values
     * @private
     */
    private _setupEditableValues()
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
            let editOptions = JSON.parse(editableValue.getAttribute('data-mimoto-editable-options'));

            //console.log('editable', sPropertySelector, editOptions, editableValue);


            // init
            let realtimeEditor = new RealtimeEditor(this._socket, sPropertySelector, editOptions, editableValue);


            // store
            this._aRealtimeEditors.push(realtimeEditor);
        }
    }

}
