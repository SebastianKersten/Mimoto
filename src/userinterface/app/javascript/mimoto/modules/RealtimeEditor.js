/**
 * Mimoto.CMS - Realtime editor
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Socket.io classes
var io = require('socket.io-client');

// Quill classes
var Quill = require("quill");
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
            console.warn('buffer', JSON.stringify(classRoot._deltaBuffer, null, 2));
        };



        this._socket.on('baseDocument', function(delta) { classRoot._socketOnBaseDocument(delta); });
        this._socket.on('ot-self', function(delta) { classRoot._socketSelfOT(delta); });
        this._socket.on('ot-other', function(delta) { classRoot._socketOtherOT(delta); });
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
        this._quill = new Quill(editableValue, {
            theme: 'bubble',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, false]}],
                    ['infocard'],
                    formats
                ],
                history: {
                    delay: 2000,
                    maxStack: 500,
                    userOnly: true
                }
            },
            placeholder: 'Start typing',
            formats: ['bold', 'italic', 'underline', 'header', 'infocard']
        });


        let toolbarModule = this._quill.getModule('toolbar');
        toolbarModule.addHandler('infocard', editInfocard);


        function editInfocard(e)
        {
            console.log('editInfocard');

            // 1. range meeveranderen met delta's

            let range = classRoot._quill.getSelection();

            if (range)
            {
                var aFormats = classRoot._quill.getFormat(range);

                if (!aFormats.infocard)
                {
                    console.log('Set format ...');

                    var popup = MimotoX.popup('/Mimoto.Aimless/form/infocard');

                    //console.log('popup', popup);

                    //popup.addEventListener('data', function() { } );


                    // 2. after addition -> trigger javascript to add functionality to edit


                    var value = 'infocard.3'; // 1. get from popup

                    // set format
                    classRoot._quill.format('infocard', value, 'user');
                }
                else
                {
                    // clear format
                    classRoot._quill.format('infocard', false, 'user');
                }
            };
        }

        // listen
        this._quill.on('selection-change', function() { classRoot._onSelectionChange(); });
        this._quill.on('text-change', function(delta, oldContents, source) { classRoot._onTextChange(delta, oldContents, source); } );


        this._socket.emit('edit', this._sPropertySelector);
    },




    _socketOnBaseDocument: function(baseDocument)
    {
        // skip if not relevant #todo - make more efficient (room per field o.i.d.)
        if (baseDocument.sPropertySelector != this._sPropertySelector) return;

        // register
        this._baseDocument = baseDocument;

        // show content
        this._quill.setContents(baseDocument.content);
    },


    _socketSelfOT: function(parsedDelta)
    {
        // delta debugging
        //console.log('My own delta has returned: ', JSON.stringify(parsedDelta.delta, null, 2), ' with index = ' + parsedDelta.nNewDeltaIndex);

        // skip if not relevant #todo - make more efficient (room per field o.i.d.)
        if (parsedDelta.sPropertySelector != this._sPropertySelector) return;


        // register
        this._baseDocument.nDeltaIndex = parsedDelta.nNewDeltaIndex;

        // reset
        this._deltaPending = null;


        // next send changes
        if (this._deltaBuffer)
        {
            // move in queue
            this._deltaPending = this._deltaBuffer;

            // reset
            this._deltaBuffer = null;

            // #fixme - temp disabled
            this._sendPending();
        }
    },


    _socketOtherOT: function(parsedDelta)
    {
        // delta debugging
        //console.log('OTHER - parsedDelta.nNewDeltaIndex = ', parsedDelta.nNewDeltaIndex);


        // skip if not relevant #todo - make more efficient (room per field o.i.d.)
        if (parsedDelta.sPropertySelector != this._sPropertySelector) return;


        // register
        this._baseDocument.nDeltaIndex = parsedDelta.nNewDeltaIndex;



        // 1. convert
        var delta = new QuillDelta(parsedDelta.delta);


        // delta debugging
        //console.log(parsedDelta.user.name + ' sent: ', JSON.stringify(delta, null, 2), ' with index = ' + parsedDelta.nNewDeltaIndex);


        // update pending
        if (this._deltaPending)
        {
            //console.log('this._deltaPending.delta before ', JSON.stringify(this._deltaPending.delta, null, 2));
            // transform pending to delta
            this._deltaPending.delta = new QuillDelta(delta.transform(this._deltaPending.delta, true));
            //console.log('this._deltaPending.delta after ', JSON.stringify(this._deltaPending.delta, null, 2));


            //console.warn('Delta before', JSON.stringify(delta, null, 2));
            // transform delta to pending
            delta = new QuillDelta(this._deltaPending.delta.transform(delta, false));
            //console.warn('Delta after ', JSON.stringify(delta, null, 2));
        }


        // update buffer
        if (this._deltaBuffer)
        {
            this._deltaBuffer.delta = new QuillDelta(delta.transform(this._deltaBuffer.delta, true));


            delta = new QuillDelta(this._deltaBuffer.delta.transform(delta, false));
        }




        // update content
        this._quill.updateContents(delta);
    },


    _socketOnMessage: function(sMessage)
    {
        console.warn(sMessage);
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


        if (source == 'user')
        {

            if (!this._deltaPending)
            {
                this._deltaPending = {
                    sPropertySelector: this._sPropertySelector,
                    delta: delta,
                    nCurrentlyKnownDeltaIndex: this._baseDocument.nDeltaIndex
                };

                // delta debugging
                //console.log('New delta pending = ' + JSON.stringify(this._deltaPending, null, 2));


                // #fixme - temp disabled
                this._sendPending();
            }
            else
            {
                // init
                if (!this._deltaBuffer)
                {
                    this._deltaBuffer = {
                        sPropertySelector: this._sPropertySelector,
                        delta: new QuillDelta(),
                        nCurrentlyKnownDeltaIndex: this._baseDocument.nDeltaIndex
                    };
                }

                // stack
                this._deltaBuffer.delta = this._deltaBuffer.delta.compose(delta);

                // delta debugging
                //console.warn('Buffer = ', JSON.stringify(this._deltaBuffer, null, 2));
            }
        }
    },

    _sendPending: function()
    {
        // update to latest
        this._deltaPending.nCurrentlyKnownDeltaIndex = this._baseDocument.nDeltaIndex;


        // delta debugging
        //console.log('Ready to send delta ' + JSON.stringify(this._deltaPending, null, 2));

        // send
        this._socket.emit('ot', this._deltaPending);
    }


}
