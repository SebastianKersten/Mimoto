/**
 * Mimoto - Data utils
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


module.exports = function() {


};

module.exports.prototype = {


    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Solid cleanup of empty spaces in an array
     * @param aArray
     * @returns array
     */
    cleanupArray: function(aArray)
    {
        // 1. cleanup
        for (let nDirectiveIndex = 0; nDirectiveIndex < aArray.length; nDirectiveIndex++)
        {
            if (aArray[nDirectiveIndex] === undefined)
            {
                aArray.splice(nDirectiveIndex, 1);
                nDirectiveIndex--;
            }
        }

        // 2. send
        return aArray;
    },

    empty: function(data)
    {
        if (typeof(data) == 'number' || typeof(data) == 'boolean') { return false; }
        if (typeof(data) == 'undefined' || data === null) { return true; }
        if (typeof(data.length) != 'undefined') {return data.length == 0; }

        var count = 0;
        for(var i in data)
        {
            if(data.hasOwnProperty(i))
            {
                count ++;
            }
        }
        return count == 0;
    }

}
