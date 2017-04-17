/**
 * Mimoto.CMS - Realtime editor
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';

var io = require('socket.io-client');


module.exports = function(sPropertySelector, editOptions, editableValue) {


    // start
    this.__construct(sPropertySelector, editOptions, editableValue);
};

module.exports.prototype = {

    _quill: null,
    _deltaPending: null,
    _documentPending: null,
    _deltaBuffer: null,

    _socket: null,

    _sPropertySelector: null,


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(sPropertySelector, editOptions, editableValue)
    {
        // register
        this._sPropertySelector = sPropertySelector;

        // setup
        this._socket = new io('http://localhost:4000');
        //this._socket = new io('http://192.168.178.72.xip.io:4000');


        var classRoot = this;

        // listen to socket
        this._socket.on('connect', function() { classRoot._socketOnConnect(); });
        this._socket.on('logon', function() { classRoot._socketOnLogon(); });


        this._socket.on('mostRecentDraft', function(delta) { classRoot._socketOnMostRecentDraft(delta); });
        this._socket.on('ot-self', function(delta) { classRoot._socketOnTextChangeSelf(delta); });
        this._socket.on('ot-other', function(delta) { classRoot._socketOnTextChangeOther(delta); });
        this._socket.on('selectionChange', function(delta) { classRoot._socketOnSelectionChange(delta); });



        // init
        var formats = null;
        var toolbar = null;


        if (editOptions) {

            console.log('editOptions', editOptions);

            if (editOptions.options && editOptions.options.formats) {
                formats = editOptions.options.formats;
                toolbar = editOptions.options.formats;
            }
        }

        console.log('formats', formats);


        // create
        this._quill = new Mimoto.modules.Quill(editableValue, {
            theme: 'bubble',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, false]}],
                    formats
                ],
                history: {
                    delay: 2000,
                    maxStack: 500,
                    userOnly: true
                }
            },
            placeholder: 'Start typing',
            formats: ['bold', 'italic', 'underline', 'header']
        });

        // listen
        this._quill.on('selection-change', function() { classRoot._onSelectionChange(); });
        this._quill.on('text-change', function(delta, oldContents, source) { classRoot._onTextChange(delta, oldContents, source); } );
    },


    // ----------------------------------------------------------------------------
    // --- Private methods text management ----------------------------------------
    // ----------------------------------------------------------------------------



    _onSelectionChange: function()
    {
        // getBounds
        this._socket.emit('selectionChange', this._quill.getSelection());
    },

    _onTextChange: function(delta, oldContents, source)
    {
        // getBounds
        this._socket.emit('selectionChange', this._quill.getSelection());


        if (source == 'api')
        {
            console.warn("An API call triggered this change.", delta);

        }
        else if (source == 'user')
        {
            console.log("The user triggered this change.", delta, oldContents);


            if (!this._deltaPending)
            {
                this._deltaPending = delta;

                this._socket.emit('ot', this._deltaPending);
            }
            else
            {
                // init
                if (!this._deltaBuffer) this._deltaBuffer = new Mimoto.modules.QuillDelta();

                // stack
                this._deltaBuffer = this._deltaBuffer.compose(delta);
            }


            console.warn('Pending contents = ' + JSON.stringify(this._deltaPending, null, 2));
            console.warn('Buffer contents = ' + JSON.stringify(this._deltaBuffer, null, 2));

        }
    },




    // ----------------------------------------------------------------------------
    // --- Private methods text management ----------------------------------------
    // ----------------------------------------------------------------------------


    _socketOnConnect: function()
    {
        this._socket.emit('connectToValue', this._sPropertySelector);


        //socket.emit
    },

    _socketOnMostRecentDraft: function(delta)
    {
        this._quill.setContents(delta);
    },

    _socketOnTextChangeOther: function(delta)
    {
        console.log('OTHER - delta received', delta);

        this._quill.updateContents(delta);
    },

    _socketOnTextChangeSelf: function(delta)
    {
        console.log("SELF = delta received", delta);


        if (this._deltaPending)
        {

            if (this._deltaPending.toString() == delta.toString())
            {
                console.log('The deltas are EQUAL', delta);

                this._deltaPending  = null;
            }

            if (this._deltaBuffer)
            {
                //
                this._deltaPending = this._deltaBuffer;

                this._socket.emit('ot', this._deltaPending);

                // reset
                this._deltaBuffer = null;
            }
            else
            {
                this._deltaPending = null;
                this._documentPending = null;
            }
        }
    },

    _socketOnSelectionChange: function(range)
    {
        // var cursor = document.getElementById('cursor');
        //
        //
        // if (!range)
        // {
        //     console.log('User lost focus');
        //
        //     cursor.style.display = 'none';
        // }
        // else
        // {
        //     var bounds = quill.getBounds(range.index, range.length);
        //
        //     cursor.style.display = 'inline-block';
        //
        //     if (range.length == 0)
        //     {
        //         console.log('Cursor', bounds);
        //     }
        //     else if (range.length > 0)
        //     {
        //         console.log('Selection', bounds);
        //     }
        //
        //     cursor.style.left = (bounds.left - 2) + 'px';
        //     //cursor.style.right = bounds.right + 'px';
        //     cursor.style.top = (bounds.top  - 2) + 'px';
        //     //cursor.style.bottom = (bounds.bottom + 2) + 'px';
        //
        //     cursor.style.width = Math.max(3, bounds.width) + 'px';
        //     cursor.style.height = (bounds.height + 5) + 'px';
        // }

    }

}
