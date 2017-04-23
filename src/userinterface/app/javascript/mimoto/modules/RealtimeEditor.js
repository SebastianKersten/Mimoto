/**
 * Mimoto.CMS - Realtime editor
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';

var io = require('socket.io-client');
var QuillDelta = require("quill-delta");


module.exports = function(socket, sPropertySelector, editOptions, editableValue) {


    // start
    this.__construct(socket, sPropertySelector, editOptions, editableValue);
};

module.exports.prototype = {

    _quill: null,
    _deltaPending: null,
    _documentPending: null,
    _deltaBuffer: null,

    _socket: null,

    _sPropertySelector: null,
    _otid: null,


    _baseDocument: null,

    _user: null,


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(socket, sPropertySelector, editOptions, editableValue)
    {
        // register
        this._socket = socket;
        this._sPropertySelector = sPropertySelector;




        var classRoot = this;


        document.showPending = function()
        {
            console.log('pending', JSON.stringify(classRoot._deltaPending, null, 2));
        };


        document.sendPending = function()
        {
            console.log('Sending pending ...');
            classRoot._sendPending();
        };

        document.showBuffer = function()
        {
            console.log('buffer', classRoot._deltaBuffer);
        };



        this._socket.on('baseDocument', function(delta) { classRoot._socketOnBaseDocument(delta); });
        this._socket.on('ot-self', function(delta) { classRoot._socketOnTextChangeSelf(delta); });
        this._socket.on('ot-other', function(delta) { classRoot._socketOnTextChangeOther(delta); });
        this._socket.on('selectionChange', function(delta) { classRoot._socketOnSelectionChange(delta); });
        this._socket.on('message', function(sMessage) { classRoot._socketOnMessage(sMessage); });



        // init
        var formats = null;
        var toolbar = null;


        if (editOptions) {

            //console.log('editOptions', editOptions);

            if (editOptions.options && editOptions.options.formats) {
                formats = editOptions.options.formats;
                toolbar = editOptions.options.formats;
            }
        }

        //console.log('formats', formats);


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


        this._socket.emit('edit', this._sPropertySelector);
    },




    _socketOnBaseDocument: function(baseDocument)
    {
        // register
        this._baseDocument = baseDocument;


        console.log('this._baseDocument', JSON.stringify(this._baseDocument, null, 2));

        //documentUpdate = {}


        // show content
        this._quill.setContents(baseDocument.content);
    },

    _socketOnTextChangeOther: function(parsedChange)
    {
        // register
        this._nCurrentDeltaIndex = parsedChange.otid; // per kamer opslaan

        // 1. convert
        var delta = new QuillDelta(parsedChange.delta);


        console.log(parsedChange.user.name + ' sent: ', JSON.stringify(delta, null, 2), ' with index = ' + this._nCurrentDeltaIndex);


        if (this._deltaPending) delta = new QuillDelta(this._deltaPending.transform(delta, false));

        if (this._deltaBuffer)
        {
            // console.log('---');
            // console.warn('buffer before', JSON.stringify(this._deltaBuffer, null, 2));
            // this._deltaBuffer = delta.transform(this._deltaBuffer, true);
            // console.warn('buffer ater ', JSON.stringify(this._deltaBuffer, null, 2));
        }


        this._quill.updateContents(delta);
    },

    _socketOnTextChangeSelf: function(parsedChange)
    {
        // register
        this._nCurrentDeltaIndex = parsedChange.otid; // per kamer opslaan

        // 1. convert
        var delta = new QuillDelta(parsedChange.delta);

        console.log('My (' + parsedChange.user.name + ') own delta returned: ', JSON.stringify(delta, null, 2), ' with index = ' + this._nCurrentDeltaIndex);



        // 1. queue van pakketjes sinds ontvangen recentValue?


        if (this._deltaBuffer)
        {
            //
            this._deltaPending = this._deltaBuffer;

            // reset
            this._deltaBuffer = null;

            // #fixme - temp disabled
            //this._sendPending();
        }
        else
        {
            this._deltaPending = null;
        }
    },

    _socketOnMessage: function(sMessage)
    {
        console.warn('Message ' + sMessage);
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
            //console.warn("An API call triggered this change.", delta);

        }
        else if (source == 'user')
        {
            //console.log("The user triggered this change.", delta, oldContents);


            if (!this._deltaPending)
            {
                this._deltaPending = {
                    sPropertySelector: this._sPropertySelector,
                    delta: delta,
                    otid: this._nCurrentDeltaIndex
                }



                this._deltaPending = delta;

                //console.log('New delta = ' + JSON.stringify(this._deltaPending, null, 2));


                // #fixme - temp disabled
                //this._sendPending();
            }
            else
            {
                // init
                if (!this._deltaBuffer) this._deltaBuffer = new Mimoto.modules.QuillDelta();

                // stack
                this._deltaBuffer = this._deltaBuffer.compose(delta);

                console.warn('Buffer = ' + JSON.stringify(this._deltaBuffer, null, 2));
            }


            // console.warn('Pending contents = ' + JSON.stringify(this._deltaPending, null, 2));
            // console.warn('Buffer contents = ' + JSON.stringify(this._deltaBuffer, null, 2));

        }
    },

    _sendPending: function()
    {
        var change = {
            sPropertySelector: this._sPropertySelector,
            delta: this._deltaPending,
            otid: this._nCurrentDeltaIndex
        }


        this._socket.emit('ot', change);
    }


}
