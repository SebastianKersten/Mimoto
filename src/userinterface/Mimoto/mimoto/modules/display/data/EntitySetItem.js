/**
 * Mimoto - Data manipulation - EntitySetItem
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


module.exports = function(directive, item)
{
    // start
    this.__construct(directive, item);
};

module.exports.prototype = {

    __construct: function(directive, item)
    {
        // verify
        if (directive.sComponentName !== undefined)
        {
            Mimoto.utils.loadComponent(directive.element, item.connection.childEntityTypeName, item.connection.childId, directive.sComponentName, directive.sPropertySelector, item.connection.id);
        }
    }

}
