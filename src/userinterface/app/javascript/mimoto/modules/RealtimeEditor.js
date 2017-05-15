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
    _valueContainer: null,
    _otid: null,


    _baseDocument: null,

    _user: null,


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(socket, sPropertySelector, valueContainer)
    {
        // register
        this._socket = socket;
        this._sPropertySelector = sPropertySelector;
        this._valueContainer = valueContainer;

        // register
        var classRoot = this;

        // configure
        this._socket.on('baseDocument', function(delta) { classRoot._socketOnBaseDocument(delta); });
        this._socket.on('ot-self', function(delta) { classRoot._socketSelfOT(delta); });
        this._socket.on('ot-other', function(delta) { classRoot._socketOtherOT(delta); });
        this._socket.on('selectionChange', function(delta) { classRoot._socketOnSelectionChange(delta); });
        this._socket.on('message', function(sMessage) { classRoot._socketOnMessage(sMessage); });

        // send edit request
        this._socket.emit('edit', this._sPropertySelector); // #todo - rename to "request.edit"
    },

    _socketOnBaseDocument: function(baseDocument)
    {
        // skip if not relevant #todo - make more efficient (room per field o.i.d.)
        if (baseDocument.sPropertySelector != this._sPropertySelector) return;

        // register
        this._baseDocument = baseDocument;


        //console.warn('baseDocument', baseDocument);


        // determine
        let bContentAsDelta = baseDocument.contentAsDelta;


        if (!bContentAsDelta)
        {
            // reset
            this._valueContainer.innerHTML = baseDocument.content;
        }

        // show content
        this._quill = this._setupEditor(baseDocument.formattingOptions);

        if (bContentAsDelta)
        {
            //console.warn('contentAsDelta FROM SERVER', baseDocument.contentAsDelta);
            this._quill.setContents(baseDocument.contentAsDelta);
        }


        if (!bContentAsDelta)
        {
            let data = {
                sPropertySelector: this._sPropertySelector,
                contentAsDelta: this._quill.getContents()
            };

            //console.log('data after conversion', data);

            this._socket.emit('setContentAsDelta', data);
        }
    },


    _socketSelfOT: function(parsedDelta)
    {
        // delta debugging
        //console.log('My own delta has returned: ', JSON.stringify(parsedDelta.delta, null, 2), ' with index = ' + parsedDelta.nNewDeltaIndex);

        // skip if not relevant #todo - make more efficient (room per field o.i.d.)
        if (parsedDelta.sPropertySelector != this._sPropertySelector) return;


        // register
        this._baseDocument.nDeltaIndex = parsedDelta.nNewDeltaIndex;

        //console.warn('SELF: this._baseDocument.nDeltaIndex', this._baseDocument.nDeltaIndex);


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

        //console.warn('OTHER: this._baseDocument.nDeltaIndex', this._baseDocument.nDeltaIndex);


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
    },


    _setupEditor: function(formattingOptions)
    {
        console.log('Setup formattingOptions', formattingOptions);


        // register
        let classRoot = this;

        // init
        var toolbar = null;
        var formats = null;


        if (formattingOptions)
        {
            if (formattingOptions.toolbar && formattingOptions.toolbar.length > 0) toolbar = formattingOptions.toolbar;
            if (formattingOptions.formats && formattingOptions.formats.length > 0) formats = formattingOptions.formats;
        }

        // create
        let quill = new Quill(this._valueContainer, {
            theme: 'bubble',
            modules: {
                toolbar: toolbar,
                history: {
                    delay: 2000,
                    maxStack: 500,
                    userOnly: true
                }
            },
            placeholder: 'Start typing', // #todo
            formats: formats
        });


        // configure
        quill.on('selection-change', function() { classRoot._onSelectionChange(); });
        quill.on('text-change', function(delta, oldContents, source) { classRoot._onTextChange(delta, oldContents, source); } );


        // send
        return quill;
    }

}
