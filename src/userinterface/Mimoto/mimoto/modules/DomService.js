/**
 * Mimoto.CMS - Form handling
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


module.exports = function() {

    // start
    this.__construct();
};

module.exports.prototype = {
    
    
    _aParsedMessages: [],
    _aEventListeners: [],
    

    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function()
    {
        this._aEventListeners = [];
    },

    registerEventListener: function(sPropertySelector, scope, fJavascriptDelegate)
    {
        this._aEventListeners.push(
            {
                sPropertySelector: sPropertySelector,
                scope: scope,
                fJavascriptDelegate: fJavascriptDelegate
            }
        );
    },


    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Handle data CHANGED
     */
    onDataChanged: function(data, sChannel)
    {
        // validate
        if (module.exports.prototype._validateMessage(module.exports.prototype._aParsedMessages, data.messageID, sChannel) !== false) return;


        //console.log('Aimless - data.changed (via ' + ((sChannel) ? sChannel : 'webevent') + ')');
        //console.log(data);


        Mimoto.display.onDataChange(data);


        // compose
        // var sEntityIdentifier = data.entityType + '.' + data.entityId;
        //
        // // update
        // module.exports.prototype._updateCounters(data.entityType, data.changes);
        // module.exports.prototype._triggerJavascriptListeners(sEntityIdentifier, data.changes);
    },

    onPageChange: function (data)
    {
        //Maido.page.change(data.url) ;//, data.config); -> load in iframe
    },

    onComponentLoad: function (data)
    {
        // o.a. remote dashboard control -> target = panel id
    },
    
    onPopupOpen: function (data)
    {
        // o.a. remote messages
        //Maido.popup.open(data.url);
        // voorzien van URL voor inhoud
        // use delegate -> MimotoLivescreen.onPopup = delegate(data)
        // kan form bevatten
    
        //call option, zoals popup, met URL van popup-view of form
    },
    
    
    
    
    // ----------------------------------------------------------------------------
    // --- Private methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    

    
    // _updateCounters: function (sEntityType, changes)
    // {
    //
    //     // search
    //     var aComponents = $("[data-mimoto-count='" + sEntityType + "']");
    //
    //     aComponents.each( function(index, $component)
    //     {
    //
    //         var mls_filter = $($component).attr("data-mimoto-filter");
    //
    //         if (mls_filter) { mls_filter = $.parseJSON(mls_filter); }
    //
    //
    //         // parse modified values
    //         for (var i = 0; i < changes.length; i++)
    //         {
    //             // register
    //             var change = changes[i];
    //
    //             var bFilterApproved = true;
    //             if (mls_filter)
    //             {
    //                 for (var s in mls_filter)
    //                 {
    //                     if (mls_filter[s] && change.value != mls_filter[s]) {
    //                         bFilterApproved = false;
    //                         break;
    //                     }
    //                 }
    //             }
    //
    //             // load
    //             if (!bFilterApproved)
    //             {
    //                 var mls_config = $($component).attr("data-mimoto-config");
    //
    //                 if (mls_config) { mls_config = $.parseJSON(mls_config); }
    //
    //
    //                 // read
    //                 var nCurrentCount = parseInt($($component).text());
    //
    //                 // update
    //                 nCurrentCount = Math.max(0, nCurrentCount - 1);
    //
    //                 // output
    //                 $($component).text(nCurrentCount);
    //
    //
    //                 if (mls_config.toggleClasses)
    //                 {
    //                     for (var sKey in mls_config.toggleClasses)
    //                     {
    //                         if (sKey == 'onZero' && nCurrentCount == 0)
    //                         {
    //                             $($component).addClass(mls_config.toggleClasses[sKey]);
    //                         }
    //                         else
    //                         {
    //                             $($component).removeClass(mls_config.toggleClasses[sKey]);
    //                         }
    //                     }
    //                 }
    //             }
    //
    //         }
    //
    //     });
    // },
    //
    // _triggerJavascriptListeners: function(sEntityIdentifier, aChanges)
    // {
    //     console.log('_triggerJavascriptListeners triggered ...');
    //
    //     // validate
    //     if (!this._aEventListeners || !aChanges) return;
    //
    //     // parse modified values
    //     var nChangeCount = aChanges.length;
    //     for (var nChangeIndex = 0; nChangeIndex < nChangeCount; nChangeIndex++)
    //     {
    //         // register
    //         var change = aChanges[nChangeIndex];
    //
    //         // find event listeners
    //         var nListenerCount = this._aEventListeners.length;
    //         for (var nListenerIndex = 0; nListenerIndex < nListenerCount; nListenerIndex++)
    //         {
    //             // register
    //             var listener = this._aEventListeners[nListenerIndex];
    //
    //             if (listener.sPropertySelector == sEntityIdentifier + '.' + change.propertyName)
    //             {
    //                 // execute
    //                 listener.fJavascriptDelegate.apply(listener.scope, change);
    //             }
    //         }
    //     }
    // },
    
    /**
     * Get component name and conditionals
     * Format of the value "subproject_phase" or "subproject_phase[phase]"
     * @param sValue
     * @private
     */
    _getComponentName: function (sComponentInfo)
    {
        // init
        var component = {};
    
        
        if (!sComponentInfo)
        {
            component.name = '';
            component.conditionals = [];
        }
        else
        {
            // search
            var nComponentNameConditionalsPos = sComponentInfo.indexOf('[');
    
            if (nComponentNameConditionalsPos != -1)
            {
                // strip
                var sComponentConditionals = sComponentInfo.substring(nComponentNameConditionalsPos + 1, sComponentInfo.length - 1);
        
                // store
                component.name = sComponentInfo.substr(0, nComponentNameConditionalsPos);
                component.conditionals = (sComponentConditionals) ? sComponentConditionals.split(',') : [];
            }
            else
            {
                // store
                component.name = sComponentInfo;
                component.conditionals = [];
            }
        }
    
        // send
        return component;
    },
    
    /**
     * Validate if data modifications already have been locally handled parsed
     * @param messageID
     * @returns boolean
     * @private
     */
    _validateMessage: function (aParsedMessages, message, sChannel)
    {
        // init
        var bHasBeenParsed = false;
        
        // default
        if (!sChannel) sChannel = 'webevent';
        
        if (!aParsedMessages[message.uid])
        {
            // register
            message.channel = sChannel;
            
            // store
            aParsedMessages[message.uid] = message;
        }
        else
        {
            if (aParsedMessages[message.uid].channel != sChannel)
            {
                bHasBeenParsed = true;
            }
        }
    
        // auto cleanup older messages
        var nAgeInSeconds = 5 * 60; // set to 5 minutes
        for (var sUID in aParsedMessages)
        {
            // register
            var parsedMessage = aParsedMessages[sUID];
            
            // check and remove
            if (parseInt(message.timestamp) - parseInt(parsedMessage.timestamp) > nAgeInSeconds)
            {
                delete aParsedMessages[parsedMessage.uid];
            }
        }
        
        // send
        return bHasBeenParsed;
    }
    
    
}
