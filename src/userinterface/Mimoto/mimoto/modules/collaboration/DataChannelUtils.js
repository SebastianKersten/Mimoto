/**
 * Mimoto - DataChannelUtils
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';



module.exports = function(sSelector)
{
    // start
    this.__construct(sSelector);



};

module.exports.prototype = {


    /**
     * Compose a channel-unique event name
     * @param sEvent string The name of the event
     * @returns {string}
     * @private
     */
    composeEvent: function(sEvent)
    {
        return sEvent + '-' + this._sSelector;
    }

}