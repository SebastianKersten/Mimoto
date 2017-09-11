/**
 * Mimoto - Data manipulation - EntitySetItem
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


let DisplayUtils = require('../utils/DisplayUtils');


module.exports = function(directive, item)
{
    // start
    this.__construct(directive, item);
};

module.exports.prototype = {

    __construct: function(directive, item)
    {
        // 1. init
        let displayUtils = new DisplayUtils();

        // 2. set item
        if (directive.sComponentName !== undefined)
        {
            Mimoto.utils.loadComponent(directive.element, item.connection.childEntityTypeName, item.connection.childId, directive.sComponentName, directive.sPropertySelector, item.connection.id);
        }
    }

}
