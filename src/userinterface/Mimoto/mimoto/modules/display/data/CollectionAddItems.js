/**
 * Mimoto - Data manipulation - CollectionAddItems
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


let DisplayUtils = require('../utils/DisplayUtils');


module.exports = function(directive, aAddedItems)
{
    // start
    this.__construct(directive, aAddedItems);
};

module.exports.prototype = {

    __construct: function(directive, aAddedItems)
    {
        // 1. init
        let displayUtils = new DisplayUtils();

        // 2. add items
        aAddedItems.forEach(function(item)
        {

            // #todo - check if the component is already there (and duplicate items are allowed OR connection-id's

            // validate
            if (displayUtils.passesFilter(directive, item))
            {
                if (directive.sComponentName !== undefined)
                {
                    Mimoto.utils.loadComponent(directive.element, item.connection.childEntityTypeName, item.connection.childId, directive.sComponentName, directive.sPropertySelector, item.connection.id);
                }
            }
        });
    }

}
