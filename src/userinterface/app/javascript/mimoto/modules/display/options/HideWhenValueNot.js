/**
 * Mimoto - Display option - AddClassWhenNotValue
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


let DisplayUtils = require('../utils/DisplayUtils');


module.exports = function(directive, value)
{
    // start
    this.__construct(directive, value);
};

module.exports.prototype = {

    __construct: function(directive, value)
    {
        // 1. init
        let displayUtils = new DisplayUtils();

        // 2. verify and toggle
        if (!displayUtils.hasAnyMatch(value, directive.instructions.values))
        {
            // 2a. hide
            displayUtils.hideElement(directive.element);
        }
        else
        {
            // 2b. show
            displayUtils.showElement(directive.element);
        }
    }

}
