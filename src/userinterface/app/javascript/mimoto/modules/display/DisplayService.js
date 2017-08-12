/**
 * Mimoto - Display Service for realtime data management
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Mimoto display classes
let HideWhenEmpty = require('./options/HideWhenEmpty');
let HideWhenEmptyNot = require('./options/HideWhenEmptyNot');
let HideWhenRegex = require('./options/HideWhenRegex');
let HideWhenRegexNot = require('./options/HideWhenRegexNot');
let HideWhenValue = require('./options/HideWhenValue');
let HideWhenValueNot = require('./options/HideWhenValueNot');

let ShowWhenEmpty = require('./options/ShowWhenEmpty');
let ShowWhenEmptyNot = require('./options/ShowWhenEmptyNot');
let ShowWhenRegex = require('./options/ShowWhenRegex');
let ShowWhenRegexNot = require('./options/ShowWhenRegexNot');
let ShowWhenValue = require('./options/ShowWhenValue');
let ShowWhenValueNot = require('./options/ShowWhenValueNot');

let AddClassWhenEmpty = require('./options/AddClassWhenValue');
let AddClassWhenEmptyNot = require('./options/AddClassWhenEmptyNot');
let AddClassWhenRegex = require('./options/AddClassWhenRegex');
let AddClassWhenRegexNot = require('./options/AddClassWhenRegexNot');
let AddClassWhenValue = require('./options/AddClassWhenValue');
let AddClassWhenValueNot = require('./options/AddClassWhenValueNot');

let RemoveClassWhenEmpty = require('./options/RemoveClassWhenValue');
let RemoveClassWhenEmptyNot = require('./options/RemoveClassWhenEmptyNot');
let RemoveClassWhenRegex = require('./options/RemoveClassWhenRegex');
let RemoveClassWhenRegexNot = require('./options/RemoveClassWhenRegexNot');
let RemoveClassWhenValue = require('./options/RemoveClassWhenValue');
let RemoveClassWhenValueNot = require('./options/RemoveClassWhenValueNot');


module.exports = function() {

    // start
    this.__construct();
};

module.exports.prototype = {


    // data tags
    TAG_MIMOTO_VALUE:      'data-mimoto-value',
    TAG_MIMOTO_ENTITY:     'data-mimoto-entity',
    TAG_MIMOTO_COLLECTION: 'data-mimoto-collection',
    TAG_MIMOTO_IMAGE:      'data-mimoto-image',
    TAG_MIMOTO_VIDEO:      'data-mimoto-video',
    TAG_MIMOTO_AUDIO:      'data-mimoto-audio',

    TAG_MIMOTO_ID:         'data-mimoto-id',

    // display tags
    TAG_MIMOTO_DISPLAY_HIDEWHENEMPTY:        'data-mimoto-display-hidewhenempty',
    TAG_MIMOTO_DISPLAY_HIDEWHENNOTEMPTY:     'data-mimoto-display-hidewhennotempty',
    TAG_MIMOTO_DISPLAY_HIDEWHENREGEX:        'data-mimoto-display-hidewhenregex',
    TAG_MIMOTO_DISPLAY_HIDEWHENNOTREGEX:     'data-mimoto-display-hidewhennotregex',
    TAG_MIMOTO_DISPLAY_HIDEWHENVALUE:        'data-mimoto-display-hidewhenvalue',
    TAG_MIMOTO_DISPLAY_HIDEWHENNOTVALUE:     'data-mimoto-display-hidewhennotvalue',

    TAG_MIMOTO_DISPLAY_SHOWWHENEMPTY:        'data-mimoto-display-showwhenempty',
    TAG_MIMOTO_DISPLAY_SHOWWHENNOTEMPTY:     'data-mimoto-display-showwhennotempty',
    TAG_MIMOTO_DISPLAY_SHOWWHENREGEX:        'data-mimoto-display-showwhenregex',
    TAG_MIMOTO_DISPLAY_SHOWWHENNOTREGEX:     'data-mimoto-display-showwhennotregex',
    TAG_MIMOTO_DISPLAY_SHOWWHENVALUE:        'data-mimoto-display-showwhenvalue',
    TAG_MIMOTO_DISPLAY_SHOWWHENNOTVALUE:     'data-mimoto-display-showwhennotvalue',

    TAG_MIMOTO_DISPLAY_ADDCLASSWHENEMPTY:    'data-mimoto-display-addclasswhenempty',
    TAG_MIMOTO_DISPLAY_ADDCLASSWHENNOTEMPTY: 'data-mimoto-display-addclasswhennotempty',
    TAG_MIMOTO_DISPLAY_ADDCLASSWHENREGEX:    'data-mimoto-display-addclasswhenregex',
    TAG_MIMOTO_DISPLAY_ADDCLASSWHENNOTREGEX: 'data-mimoto-display-addclasswhennotregex',
    TAG_MIMOTO_DISPLAY_ADDCLASSWHENVALUE:    'data-mimoto-display-addclasswhenvalue',
    TAG_MIMOTO_DISPLAY_ADDCLASSWHENNOTVALUE: 'data-mimoto-display-addclasswhennotvalue',

    TAG_MIMOTO_DISPLAY_REMOVECLASSWHENEMPTY:    'data-mimoto-display-removeclasswhenempty',
    TAG_MIMOTO_DISPLAY_REMOVECLASSWHENNOTEMPTY: 'data-mimoto-display-removeclasswhennotempty',
    TAG_MIMOTO_DISPLAY_REMOVECLASSWHENREGEX:    'data-mimoto-display-removeclasswhenregex',
    TAG_MIMOTO_DISPLAY_REMOVECLASSWHENNOTREGEX: 'data-mimoto-display-removeclasswhennotregex',
    TAG_MIMOTO_DISPLAY_REMOVECLASSWHENVALUE:    'data-mimoto-display-removeclasswhenvalue',
    TAG_MIMOTO_DISPLAY_REMOVECLASSWHENNOTVALUE: 'data-mimoto-display-removeclasswhennotvalue',

    // utility tags
    TAG_MATH_MIMOTO_COUNT: 'data-mimoto-count',

    // setting tags
    TAG_SETTING_MIMOTO_FILTER:     'data-mimoto-filter',
    TAG_SETTING_MIMOTO_COMPONENT:  'data-mimoto-component',
    TAG_SETTING_MIMOTO_CONNECTION: 'data-mimoto-connection',
    TAG_SETTING_MIMOTO_SORTINDEX:  'data-mimoto-sortindex',
    TAG_SETTING_MIMOTO_WRAPPER:    'data-mimoto-wrapper',

    // directive tags
    TAG_DIRECTIVE_MIMOTO_RELOADONCHANGE: 'data-mimoto-reloadonchange',

    // elements
    _aTaggedItems: [],
    _aTaggedProperties: [],
    _aSelectors: [],


    // classes
    _aDisplayOptionClasses: [],


    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function()
    {
        // 1. add core css classes
        var style = document.createElement('style');
        style.type = 'text/css';
        style.innerHTML = '.Mimoto_CoreCSS_hidden { display: none !important; }';
        document.getElementsByTagName('head')[0].appendChild(style);


        // prepare
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_HIDEWHENEMPTY] = HideWhenEmpty;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_HIDEWHENNOTEMPTY] = HideWhenEmptyNot;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_HIDEWHENREGEX] = HideWhenRegex;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_HIDEWHENNOTREGEX] = HideWhenRegexNot;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_HIDEWHENVALUE] = HideWhenValue;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_HIDEWHENNOTVALUE] = HideWhenValueNot;

        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_SHOWWHENEMPTY] = ShowWhenEmpty;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_SHOWWHENNOTEMPTY] = ShowWhenEmptyNot;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_SHOWWHENREGEX] = ShowWhenRegex;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_SHOWWHENNOTREGEX] = ShowWhenRegexNot;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_SHOWWHENVALUE] = ShowWhenValue;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_SHOWWHENNOTVALUE] = ShowWhenValueNot;

        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENEMPTY] = AddClassWhenEmpty;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENNOTEMPTY] = AddClassWhenEmptyNot;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENREGEX] = AddClassWhenRegex;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENNOTREGEX] = AddClassWhenRegexNot;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENVALUE] = AddClassWhenValue;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENNOTVALUE] = AddClassWhenValueNot;

        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENEMPTY] = RemoveClassWhenEmpty;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENNOTEMPTY] = RemoveClassWhenEmptyNot;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENREGEX] = RemoveClassWhenRegex;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENNOTREGEX] = RemoveClassWhenRegexNot;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENVALUE] = RemoveClassWhenValue;
        this._aDisplayOptionClasses[this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENNOTVALUE] = RemoveClassWhenValueNot;


        // 2. prepare interface
        this.parseInterface(document);
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------



    parseInterface: function(element)
    {
        console.log('Display Service startup ...');
        let nStartTime = Date.now();

        // register
        let aTags = this._collectAllTagsFromElement(element);

        let nEndTime = Date.now();
        //console.log('End of registration phase .. took ', nEndTime - nStartTime  + ' milliseconds');

        this._aSelectors = this._prepareAllTaggedElements(aTags, this._aSelectors);

        nEndTime = Date.now();
        console.log('Display Service startup took ' + (nEndTime - nStartTime) + ' milliseconds in total');


        //console.warn('aTags', aTags);
        //console.log('aSelectors', this._aSelectors);
    },



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Collect all tagged elements from document
     * @param element The element to be parsed
     * @returns aTags array All tagged elements grouped by tag type
     * @private
     */
    _collectAllTagsFromElement: function(element)
    {
        // 1. init
        let aTags = [];

        // 2. prepare (the order is important, because first the changes are implemented, and afterwards the display)
        let aPrimaryTags = [

            // data tags
            this.TAG_MIMOTO_VALUE,
            this.TAG_MIMOTO_ENTITY,
            this.TAG_MIMOTO_COLLECTION,
            this.TAG_MIMOTO_IMAGE,
            this.TAG_MIMOTO_VIDEO,
            this.TAG_MIMOTO_AUDIO,
            this.TAG_MIMOTO_ID,

            // display tags
            this.TAG_MIMOTO_DISPLAY_HIDEWHENEMPTY,
            this.TAG_MIMOTO_DISPLAY_HIDEWHENNOTEMPTY,
            this.TAG_MIMOTO_DISPLAY_HIDEWHENREGEX,
            this.TAG_MIMOTO_DISPLAY_HIDEWHENNOTREGEX,
            this.TAG_MIMOTO_DISPLAY_HIDEWHENVALUE,
            this.TAG_MIMOTO_DISPLAY_HIDEWHENNOTVALUE,

            this.TAG_MIMOTO_DISPLAY_SHOWWHENEMPTY,
            this.TAG_MIMOTO_DISPLAY_SHOWWHENNOTEMPTY,
            this.TAG_MIMOTO_DISPLAY_SHOWWHENREGEX,
            this.TAG_MIMOTO_DISPLAY_SHOWWHENNOTREGEX,
            this.TAG_MIMOTO_DISPLAY_SHOWWHENVALUE,
            this.TAG_MIMOTO_DISPLAY_SHOWWHENNOTVALUE,

            this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENEMPTY,
            this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENNOTEMPTY,
            this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENREGEX,
            this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENNOTREGEX,
            this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENVALUE,
            this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENNOTVALUE,

            this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENEMPTY,
            this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENNOTEMPTY,
            this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENREGEX,
            this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENNOTREGEX,
            this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENVALUE,
            this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENNOTVALUE,

            // utility tags
            this.TAG_MATH_MIMOTO_COUNT
        ];

        // 3. collect
        let nPrimaryTagCount = aPrimaryTags.length;
        for (let nPrimaryTagIndex = 0; nPrimaryTagIndex < nPrimaryTagCount; nPrimaryTagIndex++)
        {
            // 3a. register
            let sPrimaryTag = aPrimaryTags[nPrimaryTagIndex];

            // 3b. find and store
            aTags[sPrimaryTag] = element.querySelectorAll('[' + sPrimaryTag + ']');
        }

        // 4. send
        return aTags;
    },

    _prepareAllTaggedElements: function(aTags, aSelectors)
    {
        // 1. parse all directives
        for (let sTag in aTags)
        {
            // register
            let aElements = aTags[sTag];

            // prepare
            let nElementCount = aElements.length;
            for (let nElementIndex = 0; nElementIndex < nElementCount; nElementIndex++)
            {
                // register
                let element = aElements[nElementIndex];


                let sPropertySelector = element.getAttribute(sTag);


                // init and register
                let directive = {
                    sTag: sTag,
                    sPropertySelector: sPropertySelector,
                    element: element
                };


                // exctract instructions
                let nInstructionPos = sPropertySelector.indexOf('|');
                if (nInstructionPos !== -1)
                {
                    directive.sPropertySelector = sPropertySelector.substr(0, nInstructionPos);
                    directive.instructions = JSON.parse(sPropertySelector.substr(nInstructionPos + 1));
                }



                // verify or init
                if (!aSelectors[directive.sPropertySelector]) aSelectors[directive.sPropertySelector] = [];

                // register
                aSelectors[directive.sPropertySelector].push(directive);


                // read tag specific settings
                switch(sTag)
                {
                    case this.TAG_MIMOTO_VALUE:


                        //console.log('Value', directive);
                        break;

                    case this.TAG_MIMOTO_ID:

                        // verify and register
                        directive.sEntitySelector = element.getAttribute(this.TAG_MIMOTO_ID);

                        //console.log('Item', directive);


                        // verify and register
                        if (element.hasAttribute(this.TAG_SETTING_MIMOTO_CONNECTION))
                        {
                            directive.nConnectionId = element.getAttribute(this.TAG_SETTING_MIMOTO_CONNECTION);
                        }

                        // verify and register
                        if (element.hasAttribute(this.TAG_SETTING_MIMOTO_SORTINDEX))
                        {
                            directive.nSortIndex = element.getAttribute(this.TAG_SETTING_MIMOTO_SORTINDEX);
                        }

                        // verify and register
                        if (element.hasAttribute(this.TAG_SETTING_MIMOTO_COMPONENT))
                        {
                            directive.sComponentName = element.getAttribute(this.TAG_SETTING_MIMOTO_COMPONENT);
                        }

                        // verify and register
                        if (element.hasAttribute(this.TAG_SETTING_MIMOTO_WRAPPER))
                        {
                            directive.sWrapperName = element.getAttribute(this.TAG_SETTING_MIMOTO_WRAPPER);
                        }



                        // verify and register
                        if (element.hasAttribute(this.TAG_DIRECTIVE_MIMOTO_RELOADONCHANGE))
                        {
                            directive.bReloadOnChange = true;
                        }


                        // 1. voeg settings van entity en collection toe
                        // 1. register items
                        // 2. register containers
                        // 3. register values
                        // 4. wordt al gedaan

                        // 5. register by propertySelector aPropertySelectors en aEntitySelectors

                        break;


                    case this.TAG_MIMOTO_ENTITY:
                    case this.TAG_MIMOTO_COLLECTION:


                        // validate
                        if (!element.hasAttribute(this.TAG_SETTING_MIMOTO_COMPONENT))
                        {
                            if (MimotoX.debug) console.warn('Element', element, 'is missing a component setting', this.TAG_SETTING_MIMOTO_COMPONENT);
                            continue;
                        }

                        // register
                        directive.sComponentName = element.getAttribute(this.TAG_SETTING_MIMOTO_COMPONENT);

                        // verify
                        if (sTag === this.TAG_MIMOTO_COLLECTION && element.hasAttribute(this.TAG_SETTING_MIMOTO_FILTER))
                        {
                            // register
                            directive.aFilterValues = JSON.parse(element.getAttribute(this.TAG_SETTING_MIMOTO_FILTER));
                        }

                        // verify and register
                        if (element.hasAttribute(this.TAG_SETTING_MIMOTO_WRAPPER))
                        {
                            directive.sWrapperName = element.getAttribute(this.TAG_SETTING_MIMOTO_WRAPPER);
                        }


                        console.log('directive', directive);

                        break;

                    case this.TAG_MATH_MIMOTO_COUNT:

                        //console.log('Count', directive);

                        break;


                    // --- display updates

                    case this.TAG_MIMOTO_DISPLAY_HIDEWHENEMPTY:
                    case this.TAG_MIMOTO_DISPLAY_HIDEWHENNOTEMPTY:
                    case this.TAG_MIMOTO_DISPLAY_HIDEWHENREGEX:
                    case this.TAG_MIMOTO_DISPLAY_HIDEWHENNOTREGEX:
                    case this.TAG_MIMOTO_DISPLAY_HIDEWHENVALUE:
                    case this.TAG_MIMOTO_DISPLAY_HIDEWHENNOTVALUE:

                    case this.TAG_MIMOTO_DISPLAY_SHOWWHENEMPTY:
                    case this.TAG_MIMOTO_DISPLAY_SHOWWHENNOTEMPTY:
                    case this.TAG_MIMOTO_DISPLAY_SHOWWHENREGEX:
                    case this.TAG_MIMOTO_DISPLAY_SHOWWHENNOTREGEX:
                    case this.TAG_MIMOTO_DISPLAY_SHOWWHENVALUE:
                    case this.TAG_MIMOTO_DISPLAY_SHOWWHENNOTVALUE:

                    case this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENEMPTY:
                    case this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENNOTEMPTY:
                    case this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENREGEX:
                    case this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENNOTREGEX:
                    case this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENVALUE:
                    case this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENNOTVALUE:

                    case this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENEMPTY:
                    case this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENNOTEMPTY:
                    case this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENREGEX:
                    case this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENNOTREGEX:
                    case this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENVALUE:
                    case this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENNOTVALUE:

                        new this._aDisplayOptionClasses[directive.sTag](directive);
                        break;
                }
            }
        }

        // send
        return aSelectors;
    },







    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------






    onDataChange: function(data)
    {
        // compose
        let sEntitySelector = data.entityType + '.' + data.entityId;


        if (data.changes && data.changes.length > 0)
        {
            let nChangeCount = data.changes.length;
            for (let nChangeIndex = 0; nChangeIndex < nChangeCount; nChangeIndex++)
            {
                // register
                let change = data.changes[nChangeIndex];

                // compose
                let sPropertySelector = sEntitySelector + '.' + change.propertyName;

                // search
                if (this._aSelectors[sPropertySelector])
                {
                    // register
                    let aDirectives = this._aSelectors[sPropertySelector];

                    // parse elements
                    let nElementCount = aDirectives.length;
                    for (let nElementIndex = 0; nElementIndex < nElementCount; nElementIndex++)
                    {
                        // register
                        let directive = aDirectives[nElementIndex];

                        console.log('---------- directive', directive.sTag, 'for', directive.sPropertySelector, directive);


                        switch(directive.sTag)
                        {

                            // --- values updates

                            case this.TAG_MIMOTO_VALUE:

                                if (change.type === 'value')
                                {
                                    // 1. also allow delta's and keep track of delta-index
                                    // 2. what about innerHTML (setting per property)


                                    // parse list of found elements and check for data.changes


                                    // hideOnEmpty in aparte helper functie


                                    directive.element.innerText = change.value;




                                }
                                break;

                            case this.TAG_MIMOTO_ENTITY:


                                break;

                            case this.TAG_MIMOTO_COLLECTION:

                                console.warn('COLLECTION CHANGED!');

                                if (change.collection.added) {

                                    for (var iAdded = 0; iAdded < change.collection.added.length; iAdded++) {

                                        // register
                                        var item = change.collection.added[iAdded];

                                        var bFilterApproved = true;
                                        if (directive.aFilterValues) {
                                            for (var s in item.data) {
                                                if (directive.aFilterValues[s] && item.data[s] != directive.aFilterValues[s]) {
                                                    bFilterApproved = false;
                                                    break;
                                                }
                                            }
                                        }


                                        // 1. #todo check if the component is already there (and duplicate items are allowed OR connection-id's

                                        // load
                                        if (bFilterApproved)
                                        {
                                            if (directive.sWrapperName !== undefined)
                                            {
                                                MimotoX.utils.loadWrapperNEW(directive.element, item.connection.childEntityTypeName, item.connection.childId, directive.sWrapperName, directive.sComponentName, directive.sPropertySelector, item.connection.id);
                                            }
                                            else
                                            {
                                                if (directive.sComponentName !== undefined)
                                                {
                                                    MimotoX.utils.loadComponentNEW(directive.element, item.connection.childEntityTypeName, item.connection.childId, directive.sComponentName, directive.sPropertySelector, item.connection.id);

                                                }
                                            }
                                        }
                                    }
                                }

                                if (change.collection.removed)
                                {
                                    let nRemovedCount = change.collection.removed.length;
                                    for (let nRemovedIndex = 0; nRemovedIndex < nRemovedCount; nRemovedIndex++)
                                    {

                                        // 1. register
                                        let item = change.collection.removed[nRemovedIndex];

                                        // 2. compose
                                        let sEntitySelector = item.connection.childEntityTypeName + "." + item.connection.childId;

                                        // 3. find
                                        let element = directive.element.querySelector('[data-mimoto-id="' + sEntitySelector + '"][data-mimoto-connection="' + item.connection.id + '"]');

                                        // 4. verify
                                        if (element && this._aSelectors[sEntitySelector])
                                        {
                                            // 4b. find
                                            let nCleanupCount = this._aSelectors[sEntitySelector].length;
                                            for (let nCleanupIndex = 0; nCleanupIndex < nCleanupCount; nCleanupIndex++)
                                            {


                                                // register
                                                let cleanupCandidate = this._aSelectors[sEntitySelector][nCleanupIndex];

                                                // verify
                                                if (cleanupCandidate.nConnectionId == item.connection.id)
                                                {
                                                    // remove
                                                    this._aSelectors[sEntitySelector].splice(nCleanupIndex, 1);

                                                    // correct
                                                    if (this._aSelectors[sEntitySelector].length > 0) nCleanupIndex--;

                                                    // cleanup
                                                    if (this._aSelectors[sEntitySelector].length === 0)
                                                    {
                                                        delete this._aSelectors[sEntitySelector];
                                                        break;
                                                    }
                                                }
                                            }

                                            directive.element.removeChild(element);
                                        }
                                    }
                                }

                                break;


                            // --- display updates

                            case this.TAG_MIMOTO_DISPLAY_HIDEWHENEMPTY:
                            case this.TAG_MIMOTO_DISPLAY_HIDEWHENNOTEMPTY:

                            case this.TAG_MIMOTO_DISPLAY_SHOWWHENEMPTY:
                            case this.TAG_MIMOTO_DISPLAY_SHOWWHENNOTEMPTY:

                            case this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENEMPTY:
                            case this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENNOTEMPTY:

                            case this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENEMPTY:
                            case this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENNOTEMPTY:

                                // init
                                let currentValue = null;

                                switch(change.type)
                                {
                                    case 'value': currentValue = change.value; break;
                                    case 'entity': currentValue = change.value; break;
                                    case 'collection': currentValue = change.collection.count; break;
                                }

                                // execute
                                new this._aDisplayOptionClasses[directive.sTag](directive, currentValue);

                                break;

                            case this.TAG_MIMOTO_DISPLAY_HIDEWHENREGEX:
                            case this.TAG_MIMOTO_DISPLAY_HIDEWHENNOTREGEX:
                            case this.TAG_MIMOTO_DISPLAY_HIDEWHENVALUE:
                            case this.TAG_MIMOTO_DISPLAY_HIDEWHENNOTVALUE:

                            case this.TAG_MIMOTO_DISPLAY_SHOWWHENREGEX:
                            case this.TAG_MIMOTO_DISPLAY_SHOWWHENNOTREGEX:
                            case this.TAG_MIMOTO_DISPLAY_SHOWWHENVALUE:
                            case this.TAG_MIMOTO_DISPLAY_SHOWWHENNOTVALUE:


                            case this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENREGEX:
                            case this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENNOTREGEX:
                            case this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENVALUE:
                            case this.TAG_MIMOTO_DISPLAY_ADDCLASSWHENNOTVALUE:


                            case this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENREGEX:
                            case this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENNOTREGEX:
                            case this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENVALUE:
                            case this.TAG_MIMOTO_DISPLAY_REMOVECLASSWHENNOTVALUE:


                                // verify
                                if (change.type === 'value')
                                {
                                    // execute
                                    new this._aDisplayOptionClasses[directive.sTag](directive, change.value);
                                }

                                break;
                        }

                    }


                }
            }

        }
    }
    
}
