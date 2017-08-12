/**
 * Mimoto - Data manipulation - CollectionRemoveItems
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


let DisplayUtils = require('../utils/DisplayUtils');
let DisplayService = require('../DisplayService');


module.exports = function(directive, aRemovedItems, aSelectors)
{
    // start
    this.__construct(directive, aRemovedItems, aSelectors);
};

module.exports.prototype = {

    __construct: function(directive, aRemovedItems, aSelectors)
    {
        // 1. init
        let displayUtils = new DisplayUtils();

        // 2. add items
        aRemovedItems.forEach(function(item)
        {
            // 2. compose
            let sEntitySelector = item.connection.childEntityTypeName + "." + item.connection.childId;

            // 3. find
            let element = directive.element.querySelector('[' + DisplayService.TAG_MIMOTO_ID + '="' + sEntitySelector + '"][' + DisplayService.TAG_SETTING_MIMOTO_CONNECTION + '="' + item.connection.id + '"]');

            // 4. verify
            if (element && aSelectors[sEntitySelector])
            {
                // 4b. find
                let nCleanupCount = aSelectors[sEntitySelector].length;
                for (let nCleanupIndex = 0; nCleanupIndex < nCleanupCount; nCleanupIndex++)
                {


                    // register
                    let cleanupCandidate = aSelectors[sEntitySelector][nCleanupIndex];

                    // verify
                    if (cleanupCandidate.nConnectionId == item.connection.id)
                    {
                        // remove
                        aSelectors[sEntitySelector].splice(nCleanupIndex, 1);

                        // correct
                        if (aSelectors[sEntitySelector].length > 0) nCleanupIndex--;

                        // cleanup
                        if (aSelectors[sEntitySelector].length === 0)
                        {
                            delete aSelectors[sEntitySelector];
                            break;
                        }
                    }
                }

                directive.element.removeChild(element);
            }
        });
    }

}
