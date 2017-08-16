/**
 * Mimoto - Display option - AddClassWhenNotEmpty
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

        // 2. verify
        let bValidated = (value !== undefined) ? !displayUtils.isEmpty(value) : displayUtils.getInitialState(directive);

        // 3. toggle
        if (bValidated)
        {
            // 2a. add
            displayUtils.addClassesToElement(directive.element, directive.instructions.classes);
        }
        else
        {
            // 2b. remove
            displayUtils.removeClassesFromElement(directive.element, directive.instructions.classes);
        }
    }

}
