/**
 * Aimless - DomRealtime - Manage realtime collaboration
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


module.exports = function() {
    
    // start
    this.__construct();
};

module.exports.prototype = {
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    __construct: function()
    {
        
    },
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Load component
     */
    loadComponent: function ($component, sEntityTypeName, nId, sTemplate)
    {
        
    },
    
    updateComponent: function(ajax, dom)
    {
        
    }
    
    
//     Mimoto.Aimless.realtime.broadcastedValues = [];
// Mimoto.Aimless.realtime.changes = [];
// Mimoto.Aimless.realtime.registerChange = function(sFormName, sInputFieldId, value)
// {
//     if (!Mimoto.Aimless.realtime.changes[sInputFieldId])
//     {
//         Mimoto.Aimless.realtime.changes[sInputFieldId] = {
//             sFormName: sFormName,
//             newValue: value
//         }
//     }
//     else
//     {
//         Mimoto.Aimless.realtime.changes[sInputFieldId].newValue = value;
//     }
// }
//
//
//
// Mimoto.Aimless.realtime.dmp = new diff_match_patch();
//
//
// setInterval(function()
// {
//     for (var sInputFieldId in Mimoto.Aimless.realtime.changes)
//     {
//         var field = Mimoto.Aimless.realtime.changes[sInputFieldId];
//
//
//         // #todo - presence - lastvalue of field store in user object
//
//
//         // calculate new value
//         var originalText = Mimoto.Aimless.realtime.broadcastedValues[sInputFieldId].value;
//         var modifiedText = Mimoto.Aimless.realtime.changes[sInputFieldId].newValue;
//
//         //var ms_start = (new Date).getTime();
//         var diff = Mimoto.Aimless.realtime.dmp.diff_main(originalText, modifiedText, true);
//         //var ms_end = (new Date).getTime();
//
//         if (diff.length > 2) {
//             Mimoto.Aimless.realtime.dmp.diff_cleanupSemantic(diff);
//         }
//
//         var patch_list = Mimoto.Aimless.realtime.dmp.patch_make(originalText, modifiedText, diff);
//         patch_text = Mimoto.Aimless.realtime.dmp.patch_toText(patch_list);
//
//
//         // setup
//         var data = {
//             fieldId: sInputFieldId,
//             //value: modifiedText,
//             diff: patch_text
//         };
//
//         // broadcast update
//         Mimoto.Aimless.privateChannel.trigger('client-Aimless:formfield_update_' + field.sFormName, data);
//
//         // store
//         Mimoto.Aimless.realtime.broadcastedValues[sInputFieldId].value = field.newValue;
//         delete Mimoto.Aimless.realtime.changes[sInputFieldId];
//
//     }
//
// }, 100); // send every 100 milliseconds if position has changed
//
//
    
}
