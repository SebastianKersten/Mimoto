/**
 * Mimoto - Display Service utils
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


module.exports = function() {


};

module.exports.prototype = {

    // match types
    MATCH_TYPE_EMPTY: 'match_type_empty',
    MATCH_TYPE_VALUE: 'match_type_value',
    MATCH_TYPE_REGEX: 'match_type_regex',



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    addClassesToElement: function(element, aClasses)
    {
        let nClassCount = aClasses.length;
        for (let nClassIndex = 0; nClassIndex < nClassCount; nClassIndex++) {
            element.classList.add(aClasses[nClassIndex]);
        }
    },

    removeClassesFromElement: function(element, aClasses)
    {
        let nClassCount = aClasses.length;
        for (let nClassIndex = 0; nClassIndex < nClassCount; nClassIndex++)
        {
            element.classList.remove(aClasses[nClassIndex]);
        }
    },

    hideElement: function(element)
    {
        element.classList.add('Mimoto_CoreCSS_hidden');
    },

    showElement: function(element)
    {
        element.classList.remove('Mimoto_CoreCSS_hidden');
    },


    hasAnyMatch: function(value, aValues)
    {
        return this._hasMatch(value, aValues, this.MATCH_TYPE_VALUE);
    },

    hasAnyRegexMatch: function(value, aValues)
    {
        return this._hasMatch(value, aValues, this.MATCH_TYPE_REGEX);
    },



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    _hasMatch: function(value, aValues, sMatchType)
    {
        // 1. init
        let bMatchFound = false;

        // 2. find
        let nValueCount = aValues.length;
        for (let nValueIndex = 0; nValueIndex < nValueCount; nValueIndex++)
        {
            switch(sMatchType)
            {
                case this.MATCH_TYPE_VALUE:

                    // verify
                    if (value == aValues[nValueIndex])
                    {
                        bMatchFound = true;
                        continue;
                    }
                    break;

                case this.MATCH_TYPE_REGEX:

                    // init
                    let regex = new RegExp(aValues[nValueIndex], 'g');

                    // verify
                    if (regex.test(value))
                    {
                        bMatchFound = true;
                        continue;
                    }
                    break;
            }
        }

        // 3. send
        return bMatchFound;
    }

}
