/**
 * Mimoto - Display Service for realtime data management
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Mimoto data manipulation classes
let CollectionAddItems = require('./data/CollectionAddItems');
let CollectionRemoveItems = require('./data/CollectionRemoveItems');
let CollectionChangeSortOrder = require('./data/CollectionChangeSortOrder');

// Mimoto display classes
let HideWhenEmpty = require('./directives/HideWhenEmpty');
let HideWhenEmptyNot = require('./directives/HideWhenEmptyNot');
let HideWhenRegex = require('./directives/HideWhenRegex');
let HideWhenRegexNot = require('./directives/HideWhenRegexNot');
let HideWhenValue = require('./directives/HideWhenValue');
let HideWhenValueNot = require('./directives/HideWhenValueNot');

let ShowWhenEmpty = require('./directives/ShowWhenEmpty');
let ShowWhenEmptyNot = require('./directives/ShowWhenEmptyNot');
let ShowWhenRegex = require('./directives/ShowWhenRegex');
let ShowWhenRegexNot = require('./directives/ShowWhenRegexNot');
let ShowWhenValue = require('./directives/ShowWhenValue');
let ShowWhenValueNot = require('./directives/ShowWhenValueNot');

let AddClassWhenEmpty = require('./directives/AddClassWhenValue');
let AddClassWhenEmptyNot = require('./directives/AddClassWhenEmptyNot');
let AddClassWhenRegex = require('./directives/AddClassWhenRegex');
let AddClassWhenRegexNot = require('./directives/AddClassWhenRegexNot');
let AddClassWhenValue = require('./directives/AddClassWhenValue');
let AddClassWhenValueNot = require('./directives/AddClassWhenValueNot');

let RemoveClassWhenEmpty = require('./directives/RemoveClassWhenValue');
let RemoveClassWhenEmptyNot = require('./directives/RemoveClassWhenEmptyNot');
let RemoveClassWhenRegex = require('./directives/RemoveClassWhenRegex');
let RemoveClassWhenRegexNot = require('./directives/RemoveClassWhenRegexNot');
let RemoveClassWhenValue = require('./directives/RemoveClassWhenValue');
let RemoveClassWhenValueNot = require('./directives/RemoveClassWhenValueNot');

// utils
let DataUtils = require('./utils/DataUtils');



module.exports = function() {

    // start
    this.__construct();
};

module.exports.prototype = {


    // data directives
    TAG_MIMOTO_VALUE:      'data-mimoto-value',
    TAG_MIMOTO_ENTITY:     'data-mimoto-entity',
    TAG_MIMOTO_COLLECTION: 'data-mimoto-collection',
    TAG_MIMOTO_IMAGE:      'data-mimoto-image',
    TAG_MIMOTO_VIDEO:      'data-mimoto-video',
    TAG_MIMOTO_AUDIO:      'data-mimoto-audio',
    TAG_MIMOTO_ID:         'data-mimoto-id',

    // data manipulation directives
    DIRECTIVE_MIMOTO_DATA_EDIT:    'data-mimoto-edit',
    DIRECTIVE_MIMOTO_DATA_ADD:     'data-mimoto-add',
    DIRECTIVE_MIMOTO_DATA_REMOVE:  'data-mimoto-remove',
    DIRECTIVE_MIMOTO_DATA_SELECT:  'data-mimoto-select',
    DIRECTIVE_MIMOTO_DATA_SET:     'data-mimoto-set',
    DIRECTIVE_MIMOTO_DATA_CREATE:  'data-mimoto-create',
    DIRECTIVE_MIMOTO_DATA_CLEAR:   'data-mimoto-clear',

    // display directives
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

    // directive tags
    TAG_DIRECTIVE_MIMOTO_RELOADONCHANGE: 'data-mimoto-reloadonchange',

    // elements
    _aTaggedItems: [],
    _aTaggedProperties: [],
    _aSelectors: [],

    _nDirectiveIndex: 0,
    _aDirectives: [],


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
        //MimotoX.log('Display Service startup ...');
        let nStartTime = Date.now();

        // register
        let aTags = this._collectDirectives(element);

        let nEndTime = Date.now();
        MimotoX.log('End of registration phase .. took ', nEndTime - nStartTime  + ' milliseconds');

        this._prepareAllTaggedElements(aTags);

        nEndTime = Date.now();
        MimotoX.log('Display Service took ' + (nEndTime - nStartTime) + ' milliseconds to process ..');


        //MimotoX.warn('aTags', aTags);
        //MimotoX.log('aSelectors', this._aSelectors);
    },

    cleanupDirectives: function(element)
    {
        // 1. init
        let dataUtils = new DataUtils();


        // ---


        // 2. collect
        let aDirectives = this._collectDirectives(element);

        // 3. cleanup
        for (let sDirective in aDirectives)
        {
            let nElementCount = aDirectives[sDirective].length;
            for (let nElementIndex = 0; nElementIndex < nElementCount; nElementIndex++)
            {
                // a. register
                let element = aDirectives[sDirective][nElementIndex];

                // b. read
                let nDirectiveId = element.getAttribute('data-mimoto');

                // c. read
                let directive = this._aDirectives[nDirectiveId];



                // #todo - FIX
                if (!directive)
                {
                    MimotoX.log('element id = ', nDirectiveId, directive, element);
                    MimotoX.log('Need to handle double value selector xxx.xxx.xxx.xxx[yyy.yyy]');
                    continue;
                }


                // 1. find in selector array and cleanup
                let sPropertySelector = directive.sPropertySelector;

                // verify
                if (this._aSelectors[sPropertySelector])
                {
                    let nSelectorCount = this._aSelectors[sPropertySelector].length;
                    for (let nSelectorIndex = 0; nSelectorIndex < nSelectorCount; nSelectorIndex++)
                    {
                        // verify
                        if (this._aSelectors[sPropertySelector][nSelectorIndex] === directive)
                        {
                            // remove
                            this._aSelectors[sPropertySelector].splice(nSelectorIndex, 1);

                            // verify
                            if (this._aSelectors[sPropertySelector].length === 0)
                            {
                                // cleanup
                                delete this._aSelectors[sPropertySelector];

                                // solid cleanup of empty spaces
                                this._aSelectors = dataUtils.cleanupArray(this._aSelectors);
                            }
                            break;
                        }
                    }
                }

                // f. cleanup
                delete this._aDirectives[nDirectiveId];
            }
        }

        // 4. solid cleanup of empty spaces
        this._aDirectives = dataUtils.cleanupArray(this._aDirectives);
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
    _collectDirectives: function(element)
    {
        // 1. init
        let aDirectives = [];

        // 2. prepare (the order is important, because first the changes are implemented, and afterwards the display)
        let aPrimaryDirectives = [

            // data directives
            this.TAG_MIMOTO_VALUE,
            this.TAG_MIMOTO_ENTITY,
            this.TAG_MIMOTO_COLLECTION,
            this.TAG_MIMOTO_IMAGE,
            this.TAG_MIMOTO_VIDEO,
            this.TAG_MIMOTO_AUDIO,
            this.TAG_MIMOTO_ID,

            // data manipulation directives
            this.DIRECTIVE_MIMOTO_DATA_EDIT,
            this.DIRECTIVE_MIMOTO_DATA_ADD,
            this.DIRECTIVE_MIMOTO_DATA_REMOVE,
            this.DIRECTIVE_MIMOTO_DATA_SELECT,
            this.DIRECTIVE_MIMOTO_DATA_SET,
            this.DIRECTIVE_MIMOTO_DATA_CREATE,
            this.DIRECTIVE_MIMOTO_DATA_CLEAR,

            // display directives
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
        let nPrimaryDirectiveCount = aPrimaryDirectives.length;
        for (let nPrimaryDirectiveIndex = 0; nPrimaryDirectiveIndex < nPrimaryDirectiveCount; nPrimaryDirectiveIndex++)
        {
            // 3a. register
            let sPrimaryDirective = aPrimaryDirectives[nPrimaryDirectiveIndex];

            // 3b. find
            let aElementsWithDirectives = element.querySelectorAll('[' + sPrimaryDirective + ']');

            // 3b. find and store
            if (aElementsWithDirectives.length > 0) aDirectives[sPrimaryDirective] = aElementsWithDirectives;
        }

        // 4. send
        return aDirectives;
    },

    _prepareAllTaggedElements: function(aTags)
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

                // register
                let nDirectiveId = this._createDirectiveId();

                // read
                let sPropertySelector = element.getAttribute(sTag);

                // init and register
                let directive = {
                    id: nDirectiveId,
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
                if (!this._aSelectors[directive.sPropertySelector]) this._aSelectors[directive.sPropertySelector] = [];

                // register
                this._aSelectors[directive.sPropertySelector].push(directive);



                // store directive
                element.setAttribute('data-mimoto', nDirectiveId);
                this._aDirectives[nDirectiveId] = directive;



                // read tag specific settings
                switch(sTag)
                {
                    case this.TAG_MIMOTO_VALUE:


                        //MimotoX.log('Value', directive);
                        break;

                    case this.TAG_MIMOTO_ID:

                        // verify and register
                        directive.sEntitySelector = element.getAttribute(this.TAG_MIMOTO_ID);

                        //MimotoX.log('Item', directive);


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
                            MimotoX.warn('Element', element, 'is missing a component setting', this.TAG_SETTING_MIMOTO_COMPONENT);
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


                        //MimotoX.log('directive', directive);

                        break;

                    case this.TAG_MATH_MIMOTO_COUNT:

                        //MimotoX.log('Count', directive);

                        break;

                    // --- data manipulation


                    case this.DIRECTIVE_MIMOTO_DATA_EDIT:

                        // configure
                        directive.element.addEventListener('click', function(sEntitySelector, sFormName, options, e)
                        {
                            // forward
                            MimotoX.data.edit(sEntitySelector, sFormName, options);

                        }.bind(directive.element, directive.sPropertySelector, directive.instructions.form, directive.instructions.options), true);

                        break;

                    case this.DIRECTIVE_MIMOTO_DATA_ADD:

                        // configure
                        directive.element.addEventListener('click', function(sPropertySelector, sFormName, options, e)
                        {
                            // forward
                            MimotoX.data.add(sPropertySelector, sFormName, options);

                        }.bind(directive.element, directive.sPropertySelector, directive.instructions.form, directive.instructions.options), true);

                        break;

                    case this.DIRECTIVE_MIMOTO_DATA_REMOVE:

                        // configure
                        directive.element.addEventListener('click', function(sEntitySelector, options, e)
                        {
                            // forward
                            MimotoX.data.remove(sEntitySelector, options);

                        }.bind(directive.element, directive.sPropertySelector, directive.instructions.options), true);

                        break;

                    case this.DIRECTIVE_MIMOTO_DATA_SELECT:

                        // configure
                        directive.element.addEventListener('click', function(sPropertySelector, xSelection, options, e)
                        {
                            // forward
                            MimotoX.data.select(sPropertySelector, xSelection, options);

                        }.bind(directive.element, directive.sPropertySelector, directive.instructions.selection, directive.instructions.options), true);

                        break;

                    case this.DIRECTIVE_MIMOTO_DATA_SET:

                        // configure
                        directive.element.addEventListener('click', function(sPropertySelector, value, options, e)
                        {
                            // forward
                            MimotoX.data.set(sPropertySelector, value, options);

                        }.bind(directive.element, directive.sPropertySelector, directive.instructions.value, directive.instructions.options), true);

                        break;

                    case this.DIRECTIVE_MIMOTO_DATA_CREATE:

                        // configure
                        directive.element.addEventListener('click', function(sPropertySelector, sEntityName, options, e)
                        {
                            // forward
                            MimotoX.data.create(sPropertySelector, sEntityName, options);

                        }.bind(directive.element, directive.sPropertySelector, directive.instructions.entityName, directive.instructions.options), true);

                        break;

                    case this.DIRECTIVE_MIMOTO_DATA_CLEAR:

                        // configure
                        directive.element.addEventListener('click', function(sPropertySelector,options, e)
                        {
                            // forward
                            MimotoX.data.clear(sPropertySelector, options);

                        }.bind(directive.element, directive.sPropertySelector, directive.instructions.options), true);

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
    },

    _createDirectiveId: function()
    {
        // 1. set
        let nDirectiveId = this._nDirectiveIndex;

        // 2. update
        this._nDirectiveIndex++;

        // 3. send
        return nDirectiveId;
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------






    onDataChange: function(data)
    {

        MimotoX.log('data', data);





        // compose
        let sEntitySelector = data.entityType + '.' + data.entityId;




        // --- value changes

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

                        //MimotoX.log('---------- directive', directive.sTag, 'for', directive.sPropertySelector, directive);


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


                                    directive.element.innerHTML = change.value;




                                }
                                break;

                            case this.TAG_MIMOTO_ENTITY:


                                //MimotoX.log();

                                break;

                            case this.TAG_MIMOTO_COLLECTION:

                                // 1. verify and add items
                                if (change.collection.added) new CollectionAddItems(directive, change.collection.added);

                                // 2. verify and remove items
                                if (change.collection.removed) new CollectionRemoveItems(directive, change.collection.removed);

                                // 3. verify and change sort order
                                if (change.collection.connections) new CollectionChangeSortOrder(directive, change.collection.connections);

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
                                    case 'entity': currentValue = change.entity; break;
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



        // --- entity changes


        if (this._aSelectors[sEntitySelector])
        {
            if (data.changes && data.changes.length > 0)
            {
                // register
                let aDirectives = this._aSelectors[sEntitySelector];


                // parse elements
                let nDirectiveCount = aDirectives.length;
                for (let nDirectiveIndex = 0; nDirectiveIndex < nDirectiveCount; nDirectiveIndex++)
                {
                    // register
                    let directive = aDirectives[nDirectiveIndex];

                    // verify
                    if (directive.bReloadOnChange)
                    {
                        MimotoX.utils.updateComponent(directive.element, directive.sEntitySelector, directive.sComponentName, directive.nConnectionId)
                    }

                }
            }
        }



        // --- selection changes


        if (data.connections && data.connections.length > 0)
        {
            MimotoX.log('data.connections', data.connections);

            let nConnectionCount = data.connections.length;
            for (let nConnectionIndex = 0; nConnectionIndex < nConnectionCount; nConnectionIndex++)
            {
                // register
                let connection = data.connections[nConnectionIndex];

                // compose
                let sPropertySelector = connection.parentEntityType + "." + connection.parentId + "." + connection.parentPropertyName;

                // verify
                if (this._aSelectors[sPropertySelector])
                {
                    // register
                    let aDirectives = this._aSelectors[sPropertySelector];


                    // 1. execute directive
                    // 2. pass value

                    MimotoX.log('Known collection / selection', aDirectives);
                }
            }


            // 1. check if entity exists
        }
    }
    
}
