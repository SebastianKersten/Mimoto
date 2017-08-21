/**
 * Mimoto - Data manipulation - CollectionRemoveItems
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


let DisplayUtils = require('../utils/DisplayUtils');


module.exports = function(directive, aRemovedItems)
{
    // start
    this.__construct(directive, aRemovedItems);
};

module.exports.prototype = {

    __construct: function(directive, aRemovedItems)
    {
        // 1. init
        let displayUtils = new DisplayUtils();

        // 2. add items
        aRemovedItems.forEach(function(item)
        {
            // 2. compose
            let sEntitySelector = item.connection.childEntityTypeName + "." + item.connection.childId;

            // 3. find
            let element = directive.element.querySelector('[' + MimotoX.display.TAG_MIMOTO_ID + '="' + sEntitySelector + '"][' + MimotoX.display.TAG_SETTING_MIMOTO_CONNECTION + '="' + item.connection.id + '"]');

            // 4. cleanup
            MimotoX.utils.removeComponent(element);
        });
    }

}
