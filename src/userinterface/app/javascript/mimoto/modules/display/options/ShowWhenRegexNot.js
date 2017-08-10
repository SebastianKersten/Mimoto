/**
 * Mimoto - Display option - ShowWhenNotRegex
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
        let bValidated = (value !== undefined) ? !displayUtils.hasAnyRegexMatch(value, directive.instructions.patterns) : displayUtils.getInitialState(directive);

        // 3. toggle
        if (bValidated)
        {
            // 2a. show
            displayUtils.showElement(directive.element);
        }
        else
        {
            // 2b. hide
            displayUtils.hideElement(directive.element);
        }
    }

}
