/**
 * Mimoto - Data manipulation - EntityUnsetItem
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
        // 1. clear node
        directive.element.innerHTML = '';
    }

}
