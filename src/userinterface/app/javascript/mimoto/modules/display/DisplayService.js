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
let EntitySetItem = require('./data/EntitySetItem');
let EntityUnsetItem = require('./data/EntityUnsetItem');

// Mimoto input classes
let Form = require('./input/Form');

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
    DIRECTIVE_MIMOTO_VALUE:      'data-mimoto-value',
    DIRECTIVE_MIMOTO_ENTITY:     'data-mimoto-entity',
    DIRECTIVE_MIMOTO_COLLECTION: 'data-mimoto-collection',
    DIRECTIVE_MIMOTO_IMAGE:      'data-mimoto-image',
    DIRECTIVE_MIMOTO_VIDEO:      'data-mimoto-video',
    DIRECTIVE_MIMOTO_AUDIO:      'data-mimoto-audio',
    DIRECTIVE_MIMOTO_ID:         'data-mimoto-id',

    // data manipulation directives
    DIRECTIVE_MIMOTO_DATA_EDIT:    'data-mimoto-edit',
    DIRECTIVE_MIMOTO_DATA_ADD:     'data-mimoto-add',
    DIRECTIVE_MIMOTO_DATA_REMOVE:  'data-mimoto-remove',
    DIRECTIVE_MIMOTO_DATA_SELECT:  'data-mimoto-select',
    DIRECTIVE_MIMOTO_DATA_SET:     'data-mimoto-set',
    DIRECTIVE_MIMOTO_DATA_CREATE:  'data-mimoto-create',
    DIRECTIVE_MIMOTO_DATA_CLEAR:   'data-mimoto-clear',

    // input directives
    DIRECTIVE_MIMOTO_FORM:        'data-mimoto-form',
    DIRECTIVE_MIMOTO_FORM_SUBMIT: 'data-mimoto-form-submit',

    // display directives
    DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENEMPTY:             'data-mimoto-display-hidewhenempty',
    DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTEMPTY:          'data-mimoto-display-hidewhennotempty',
    DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENREGEX:             'data-mimoto-display-hidewhenregex',
    DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTREGEX:          'data-mimoto-display-hidewhennotregex',
    DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENVALUE:             'data-mimoto-display-hidewhenvalue',
    DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTVALUE:          'data-mimoto-display-hidewhennotvalue',

    DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENEMPTY:             'data-mimoto-display-showwhenempty',
    DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTEMPTY:          'data-mimoto-display-showwhennotempty',
    DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENREGEX:             'data-mimoto-display-showwhenregex',
    DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTREGEX:          'data-mimoto-display-showwhennotregex',
    DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENVALUE:             'data-mimoto-display-showwhenvalue',
    DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTVALUE:          'data-mimoto-display-showwhennotvalue',

    DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENEMPTY:         'data-mimoto-display-addclasswhenempty',
    DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTEMPTY:      'data-mimoto-display-addclasswhennotempty',
    DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENREGEX:         'data-mimoto-display-addclasswhenregex',
    DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTREGEX:      'data-mimoto-display-addclasswhennotregex',
    DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENVALUE:         'data-mimoto-display-addclasswhenvalue',
    DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTVALUE:      'data-mimoto-display-addclasswhennotvalue',

    DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENEMPTY:      'data-mimoto-display-removeclasswhenempty',
    DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTEMPTY:   'data-mimoto-display-removeclasswhennotempty',
    DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENREGEX:      'data-mimoto-display-removeclasswhenregex',
    DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTREGEX:   'data-mimoto-display-removeclasswhennotregex',
    DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENVALUE:      'data-mimoto-display-removeclasswhenvalue',
    DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTVALUE:   'data-mimoto-display-removeclasswhennotvalue',

    // utility tags
    DIRECTIVE_MATH_MIMOTO_COUNT: 'data-mimoto-count',
    DIRECTIVE_MIMOTO_API: 'data-mimoto-api',

    // setting tags
    DIRECTIVE_SETTING_MIMOTO_FILTER:     'data-mimoto-filter',
    DIRECTIVE_SETTING_MIMOTO_COMPONENT:  'data-mimoto-component',
    DIRECTIVE_SETTING_MIMOTO_CONNECTION: 'data-mimoto-connection',
    DIRECTIVE_SETTING_MIMOTO_SORTINDEX:  'data-mimoto-sortindex',

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

    // forms
    _aForms: [],


    
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
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENEMPTY] = HideWhenEmpty;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTEMPTY] = HideWhenEmptyNot;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENREGEX] = HideWhenRegex;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTREGEX] = HideWhenRegexNot;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENVALUE] = HideWhenValue;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTVALUE] = HideWhenValueNot;

        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENEMPTY] = ShowWhenEmpty;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTEMPTY] = ShowWhenEmptyNot;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENREGEX] = ShowWhenRegex;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTREGEX] = ShowWhenRegexNot;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENVALUE] = ShowWhenValue;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTVALUE] = ShowWhenValueNot;

        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENEMPTY] = AddClassWhenEmpty;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTEMPTY] = AddClassWhenEmptyNot;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENREGEX] = AddClassWhenRegex;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTREGEX] = AddClassWhenRegexNot;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENVALUE] = AddClassWhenValue;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTVALUE] = AddClassWhenValueNot;

        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENEMPTY] = RemoveClassWhenEmpty;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTEMPTY] = RemoveClassWhenEmptyNot;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENREGEX] = RemoveClassWhenRegex;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTREGEX] = RemoveClassWhenRegexNot;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENVALUE] = RemoveClassWhenValue;
        this._aDisplayOptionClasses[this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTVALUE] = RemoveClassWhenValueNot;


        // 2. prepare interface
        this.parseInterface(document);
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------



    parseInterface: function(element)
    {
        //Mimoto.log('Display Service startup ...');
        let nStartTime = Date.now();

        // register
        let aTags = this._collectDirectives(element);

        let nEndTime = Date.now();
        Mimoto.log('End of registration phase .. took ', nEndTime - nStartTime  + ' milliseconds');

        this._prepareAllTaggedElements(aTags);

        nEndTime = Date.now();
        Mimoto.log('Display Service took ' + (nEndTime - nStartTime) + ' milliseconds to process ..');


        //Mimoto.warn('aTags', aTags);
        //Mimoto.log('aSelectors', this._aSelectors);
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


                // $todo - support array


                // c. read
                let directive = this._aDirectives[nDirectiveId];



                // #todo - FIX
                if (!directive)
                {
                    Mimoto.log('element id = ', nDirectiveId, directive, element);
                    Mimoto.log('Need to handle double value selector xxx.xxx.xxx.xxx[yyy.yyy]');
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
            this.DIRECTIVE_MIMOTO_VALUE,
            this.DIRECTIVE_MIMOTO_ENTITY,
            this.DIRECTIVE_MIMOTO_COLLECTION,
            this.DIRECTIVE_MIMOTO_IMAGE,
            this.DIRECTIVE_MIMOTO_VIDEO,
            this.DIRECTIVE_MIMOTO_AUDIO,
            this.DIRECTIVE_MIMOTO_ID,

            // data manipulation directives
            this.DIRECTIVE_MIMOTO_DATA_EDIT,
            this.DIRECTIVE_MIMOTO_DATA_ADD,
            this.DIRECTIVE_MIMOTO_DATA_REMOVE,
            this.DIRECTIVE_MIMOTO_DATA_SELECT,
            this.DIRECTIVE_MIMOTO_DATA_SET,
            this.DIRECTIVE_MIMOTO_DATA_CREATE,
            this.DIRECTIVE_MIMOTO_DATA_CLEAR,

            // intput directives
            this.DIRECTIVE_MIMOTO_FORM,
            this.DIRECTIVE_MIMOTO_FORM_SUBMIT,

            // display directives
            this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENEMPTY,
            this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTEMPTY,
            this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENREGEX,
            this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTREGEX,
            this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENVALUE,
            this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTVALUE,

            this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENEMPTY,
            this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTEMPTY,
            this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENREGEX,
            this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTREGEX,
            this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENVALUE,
            this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTVALUE,

            this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENEMPTY,
            this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTEMPTY,
            this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENREGEX,
            this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTREGEX,
            this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENVALUE,
            this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTVALUE,

            this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENEMPTY,
            this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTEMPTY,
            this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENREGEX,
            this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTREGEX,
            this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENVALUE,
            this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTVALUE,

            // utility tags
            this.DIRECTIVE_MATH_MIMOTO_COUNT,
            this.DIRECTIVE_MIMOTO_API
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

    _prepareAllTaggedElements: function(aDirectives)
    {
        // init
        let aSubmitButtonDirectives = [];
        let aForms = [];


        // 1. parse all directives
        for (let sDirective in aDirectives)
        {
            // register
            let aElements = aDirectives[sDirective];

            // prepare
            let nElementCount = aElements.length;
            for (let nElementIndex = 0; nElementIndex < nElementCount; nElementIndex++)
            {
                // register
                let element = aElements[nElementIndex];

                // register
                let nDirectiveId = this._createDirectiveId();

                // read
                let sPropertySelector = element.getAttribute(sDirective);

                // init and register
                let directive = {
                    id: nDirectiveId,
                    sDirective: sDirective,
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


                // ---


                // store directive
                if (element.hasAttribute('data-mimoto'))
                {
                    let xRegisteredIds = element.getAttribute('data-mimoto');

                    if (!xRegisteredIds) // empty
                    {
                        element.setAttribute('data-mimoto', nDirectiveId);
                    }
                    else
                    if (!isNaN(xRegisteredIds)) // single id
                    {
                        element.setAttribute('data-mimoto', JSON.stringify([parseInt(xRegisteredIds), nDirectiveId]));
                    }
                    else // multiple ids
                    {
                        element.setAttribute('data-mimoto', JSON.stringify(JSON.parse(xRegisteredIds).push(nDirectiveId)));
                    }
                }
                else
                {
                    element.setAttribute('data-mimoto', nDirectiveId);
                }
                this._aDirectives[nDirectiveId] = directive;


                // ---


                // read tag specific settings
                switch(sDirective)
                {
                    case this.DIRECTIVE_MIMOTO_VALUE:

                        if (directive.instructions && directive.instructions.origin)
                        {
                            Mimoto.warn('origin for', directive.sPropertySelector, 'is', directive.instructions.origin);
                            Mimoto.warn('alias for', directive.sPropertySelector, 'is', directive.instructions.alias);
                        }



                        break;

                    case this.DIRECTIVE_MIMOTO_ID:

                        // verify and register
                        directive.sEntitySelector = element.getAttribute(this.DIRECTIVE_MIMOTO_ID);

                        //Mimoto.log('Item', directive);


                        // verify and register
                        if (element.hasAttribute(this.DIRECTIVE_SETTING_MIMOTO_CONNECTION))
                        {
                            directive.nConnectionId = element.getAttribute(this.DIRECTIVE_SETTING_MIMOTO_CONNECTION);
                        }

                        // verify and register
                        if (element.hasAttribute(this.DIRECTIVE_SETTING_MIMOTO_SORTINDEX))
                        {
                            directive.nSortIndex = element.getAttribute(this.DIRECTIVE_SETTING_MIMOTO_SORTINDEX);
                        }

                        // verify and register
                        if (element.hasAttribute(this.DIRECTIVE_SETTING_MIMOTO_COMPONENT))
                        {
                            directive.sComponentName = element.getAttribute(this.DIRECTIVE_SETTING_MIMOTO_COMPONENT);
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


                    case this.DIRECTIVE_MIMOTO_ENTITY:
                    case this.DIRECTIVE_MIMOTO_COLLECTION:


                        // validate
                        if (!element.hasAttribute(this.DIRECTIVE_SETTING_MIMOTO_COMPONENT))
                        {
                            Mimoto.warn('Element', element, 'is missing a component setting', this.DIRECTIVE_SETTING_MIMOTO_COMPONENT);
                            continue;
                        }

                        // register
                        directive.sComponentName = element.getAttribute(this.DIRECTIVE_SETTING_MIMOTO_COMPONENT);

                        // verify
                        if (sDirective === this.DIRECTIVE_MIMOTO_COLLECTION && element.hasAttribute(this.DIRECTIVE_SETTING_MIMOTO_FILTER))
                        {
                            // register
                            directive.aFilterValues = JSON.parse(element.getAttribute(this.DIRECTIVE_SETTING_MIMOTO_FILTER));
                        }


                        //Mimoto.log('directive', directive);

                        break;

                    case this.DIRECTIVE_MATH_MIMOTO_COUNT:

                        //Mimoto.log('Count', directive);

                        break;

                    // --- data manipulation


                    case this.DIRECTIVE_MIMOTO_DATA_EDIT:

                        // configure
                        directive.element.addEventListener('click', function(sEntitySelector, sFormName, options, e)
                        {
                            // forward
                            Mimoto.data.edit(sEntitySelector, sFormName, options);

                        }.bind(directive.element, directive.sPropertySelector, directive.instructions.form, directive.instructions.options), true);

                        break;

                    case this.DIRECTIVE_MIMOTO_DATA_ADD:

                        // configure
                        directive.element.addEventListener('click', function(sPropertySelector, sFormName, options, e)
                        {
                            // forward
                            Mimoto.data.add(sPropertySelector, sFormName, options);

                        }.bind(directive.element, directive.sPropertySelector, directive.instructions.form, directive.instructions.options), true);

                        break;

                    case this.DIRECTIVE_MIMOTO_DATA_REMOVE:

                        // init
                        let nConnectionId = null;

                        // find parent
                        let elParent = this._findParentWithType('data-mimoto-id', directive.element);

                        // get connection id
                        if (elParent && elParent.getAttribute('data-mimoto-id') === directive.sPropertySelector)
                        {
                            if (elParent.hasAttribute('data-mimoto-connection'))
                            {
                                nConnectionId = elParent.getAttribute('data-mimoto-connection');
                            }
                        }

                        // configure
                        directive.element.addEventListener('click', function(sEntitySelector, nConnectionId, options, e)
                        {
                            // forward
                            Mimoto.data.remove(sEntitySelector, nConnectionId, options);

                        }.bind(directive.element, directive.sPropertySelector, nConnectionId, directive.instructions.options), true);

                        break;

                    case this.DIRECTIVE_MIMOTO_DATA_SELECT:

                        // configure
                        directive.element.addEventListener('click', function(sPropertySelector, xSelection, options, e)
                        {
                            // forward
                            Mimoto.data.select(sPropertySelector, xSelection, options);

                        }.bind(directive.element, directive.sPropertySelector, directive.instructions.selection, directive.instructions.options), true);

                        break;

                    case this.DIRECTIVE_MIMOTO_DATA_SET:

                        // configure
                        directive.element.addEventListener('click', function(sPropertySelector, value, options, e)
                        {
                            // forward
                            Mimoto.data.set(sPropertySelector, value, options);

                        }.bind(directive.element, directive.sPropertySelector, directive.instructions.value, directive.instructions.options), true);

                        break;

                    case this.DIRECTIVE_MIMOTO_DATA_CREATE:

                        // configure
                        directive.element.addEventListener('click', function(sPropertySelector, sEntityName, options, e)
                        {
                            // forward
                            Mimoto.data.create(sPropertySelector, sEntityName, options);

                        }.bind(directive.element, directive.sPropertySelector, directive.instructions.entityName, directive.instructions.options), true);

                        break;

                    case this.DIRECTIVE_MIMOTO_DATA_CLEAR:

                        // configure
                        directive.element.addEventListener('click', function(sPropertySelector,options, e)
                        {
                            // forward
                            Mimoto.data.clear(sPropertySelector, options);

                        }.bind(directive.element, directive.sPropertySelector, directive.instructions.options), true);

                        break;



                    // --- input directives

                    case this.DIRECTIVE_MIMOTO_FORM:

                        console.warn('DIRECTIVE_MIMOTO_FORM', directive.element);

                        // init
                        let form = new Form(directive.element);

                        // store
                        this._aForms.push(form);

                        // add
                        aForms.push(form);

                        // 1. create form
                        // 2. add input fields
                        // 3. add submit (indien erin, dan meteen, indien erbuiten met naam, search form, open form)

                        // if (element.hasAttribute(this.DIRECTIVE_SETTING_MIMOTO_CONNECTION))


                        break;


                    case this.DIRECTIVE_MIMOTO_FORM_SUBMIT:

                        // add
                        aSubmitButtonDirectives.push(directive);
                        break;

                    // --- display directives

                    case this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENEMPTY:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTEMPTY:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENREGEX:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTREGEX:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENVALUE:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTVALUE:

                    case this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENEMPTY:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTEMPTY:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENREGEX:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTREGEX:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENVALUE:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTVALUE:

                    case this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENEMPTY:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTEMPTY:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENREGEX:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTREGEX:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENVALUE:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTVALUE:

                    case this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENEMPTY:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTEMPTY:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENREGEX:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTREGEX:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENVALUE:
                    case this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTVALUE:

                        new this._aDisplayOptionClasses[directive.sDirective](directive);
                        break;


                    case this.DIRECTIVE_MIMOTO_API:

                        // configure
                        directive.element.addEventListener('click', function(sEntitySelector, sURL, options, e)
                        {
                            // 2. authenticate
                            Mimoto.utils.callAPI({
                                type: 'get',
                                url: sURL,
                                //data: { id: this._socket.id },
                                //dataType: 'json',
                                success: function(resultData, resultStatus, resultSomething)
                                {
                                    Mimoto.log('Call to ' + sURL + ' executed!');
                                }
                            });

                        }.bind(directive.element, directive.sEntitySelector, directive.instructions.url), true);

                }
            }
        }


        // ---


        // connect submit buttons
        let nSubmitButtonCount = aSubmitButtonDirectives.length;
        if (nSubmitButtonCount > 0)
        {
            for (let nSubmitButtonIndex = 0; nSubmitButtonIndex < nSubmitButtonCount; nSubmitButtonIndex++)
            {
                // register
                let directive = aSubmitButtonDirectives[nSubmitButtonIndex];
                let elSubmitButton = directive.element;

                // read
                let sFormName = directive.element.getAttribute(this.DIRECTIVE_MIMOTO_FORM_SUBMIT);

                // connect
                let nFormCount = aForms.length;
                for (let nFormIndex = 0; nFormIndex < nFormCount; nFormIndex++)
                {
                    // register
                    let form = aForms[nFormIndex];

                    if (sFormName.length === 0 || sFormName.length > 0 && form.getName() === sFormName)
                    {
                        // configure
                        elSubmitButton.addEventListener('click', function(e) { form.submit(); });
                    }
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

        Mimoto.log('data', data);





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

                        //Mimoto.log('---------- directive', directive.sDirective, 'for', directive.sPropertySelector, directive);


                        switch(directive.sDirective)
                        {

                            // --- values updates

                            case this.DIRECTIVE_MIMOTO_VALUE:

                                // 1. if type = entity
                                // 2. look for changed fields
                                // 3. check alias
                                // 4. output full change object

                                console.warn('DIRECTIVE_MIMOTO_VALUE - check origins from separate array', change);



                                if (change.type === 'value')
                                {
                                    // 1. also allow delta's and keep track of delta-index
                                    // 2. what about innerHTML (setting per property)


                                    // parse list of found elements and check for data.changes


                                    // hideOnEmpty in aparte helper functie


                                    directive.element.innerHTML = change.value;

                                }
                                break;

                            case this.DIRECTIVE_MIMOTO_ENTITY:

                                // 1. check if alias of type value
                                console.warn('DIRECTIVE_MIMOTO_ENTITY', change);


                                // 1. verify and add items
                                if (change.entity)
                                {
                                    new EntitySetItem(directive, change.entity);
                                }
                                else
                                {
                                    new EntityUnsetItem(directive);
                                }
                                break;

                            case this.DIRECTIVE_MIMOTO_COLLECTION:

                                // 1. verify and add items
                                if (change.collection.added) new CollectionAddItems(directive, change.collection.added);

                                // 2. verify and remove items
                                if (change.collection.removed) new CollectionRemoveItems(directive, change.collection.removed);

                                // 3. verify and change sort order
                                if (change.collection.connections) new CollectionChangeSortOrder(directive, change.collection.connections);

                                break;


                            // --- display updates

                            case this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENEMPTY:
                            case this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTEMPTY:

                            case this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENEMPTY:
                            case this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTEMPTY:

                            case this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENEMPTY:
                            case this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTEMPTY:

                            case this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENEMPTY:
                            case this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTEMPTY:

                                // init
                                let currentValue = null;

                                switch(change.type)
                                {
                                    case 'value': currentValue = change.value; break;
                                    case 'entity': currentValue = change.entity; break;
                                    case 'collection': currentValue = change.collection.count; break;
                                }

                                // execute
                                new this._aDisplayOptionClasses[directive.sDirective](directive, currentValue);

                                break;

                            case this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENREGEX:
                            case this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTREGEX:
                            case this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENVALUE:
                            case this.DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTVALUE:

                            case this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENREGEX:
                            case this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTREGEX:
                            case this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENVALUE:
                            case this.DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTVALUE:


                            case this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENREGEX:
                            case this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTREGEX:
                            case this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENVALUE:
                            case this.DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTVALUE:


                            case this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENREGEX:
                            case this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTREGEX:
                            case this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENVALUE:
                            case this.DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTVALUE:


                                // verify
                                if (change.type === 'value')
                                {
                                    // execute
                                    new this._aDisplayOptionClasses[directive.sDirective](directive, change.value);
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
                        Mimoto.utils.updateComponent(directive.element, directive.sEntitySelector, directive.sComponentName, directive.nConnectionId)
                    }

                }
            }
        }



        // --- selection changes


        if (data.connections && data.connections.length > 0)
        {
            Mimoto.log('data.connections', data.connections);

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

                    Mimoto.log('Known collection / selection', aDirectives);
                }
            }


            // 1. check if entity exists
        }
    },



    _findParentWithType: function(sType, element)
    {
        // init
        let parent = element;

        // bubble up
        while (parent && !parent.hasAttribute(sType))
        {
            // register
            parent = parent.parentNode;

            // toggle
            if (parent === document) return false;
        }

        // send
        return parent;
    },
}
