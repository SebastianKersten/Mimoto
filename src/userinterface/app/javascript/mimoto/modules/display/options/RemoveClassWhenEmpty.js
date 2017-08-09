/**
 * Mimoto - Display option - RemoveClassWhenEmpty
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
        if (value.length == 0)
        {
            // 2a. remove
            displayUtils.removeClassesFromElement(directive.element, directive.instructions.classes);
        }
        else
        {
            // 2b. add
            displayUtils.addClassesToElement(directive.element, directive.instructions.classes);
        }
    }

}
