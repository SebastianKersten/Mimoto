/**
 * Mimoto - Data manipulation - CollectionChangeSortOrder
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


module.exports = function(directive, aConnections)
{
    // start
    this.__construct(directive, aConnections);
};

module.exports.prototype = {

    __construct: function(directive, aConnections)
    {
        // 1. init
        let previousElement = null;

        // 2. change order
        aConnections.forEach(function(connection, nConnectionIndex)
        {
            // register
            let currentElement = directive.element.querySelector('[' + Mimoto.display.DIRECTIVE_SETTING_MIMOTO_CONNECTION + '="' + connection.id + '"]');
            currentElement.setAttribute(Mimoto.display.DIRECTIVE_SETTING_MIMOTO_SORTINDEX, connection.sortindex);

            // verify
            if (nConnectionIndex == 0)
            {
                directive.element.insertBefore(currentElement, directive.element.firstChild);
            }
            else
            {
                directive.element.insertBefore(currentElement, previousElement.nextSibling);
            }

            // update
            previousElement = currentElement;
        });
    }

}
