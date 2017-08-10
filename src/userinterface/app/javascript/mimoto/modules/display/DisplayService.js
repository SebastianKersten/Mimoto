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
        style.innerHTML = '.Mimoto_CoreCSS_hidden { display: none; }';
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

        this._aSelectors = this._prepareAllTaggedElements(aTags);

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

    _prepareAllTaggedElements: function(aTags)
    {
        // 1. init
        let aSelectors = [];


        // 2. parse all tag types
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
                        if (sTag === this.TAG_MIMOTO_ENTITY)
                        {
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
                            if (element.hasAttribute(this.TAG_DIRECTIVE_MIMOTO_RELOADONCHANGE))
                            {
                                directive.bReloadOnChange = true;
                            }
                        }

                        // verify
                        if (sTag === this.TAG_MIMOTO_COLLECTION && element.hasAttribute(this.TAG_SETTING_MIMOTO_FILTER))
                        {
                            // register
                            directive.aFilterValues = JSON.parse(element.getAttribute(this.TAG_SETTING_MIMOTO_FILTER));
                        }



                        //console.log('Property', directive);

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
        //console.error('data', data);


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

                    //console.log('found ' + sPropertySelector, this._aSelectors[sPropertySelector]);


                    // register
                    let aDirectives = this._aSelectors[sPropertySelector];

                    // parse elements
                    let nElementCount = aDirectives.length;
                    for (let nElementIndex = 0; nElementIndex < nElementCount; nElementIndex++)
                    {
                        // register
                        let directive = aDirectives[nElementIndex];

                        console.log('directive.sTag', directive.sTag);

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

                                console.log('collection changed');
                                console.log('change = ', change);
                                console.log('directive = ', directive);


                                // 1. create selection

                                //             if (change.collection.added) {
                                //
                                //                 for (var iAdded = 0; iAdded < change.collection.added.length; iAdded++) {
                                //
                                //                     // register
                                //                     var item = change.collection.added[iAdded];
                                //
                                //                     var bFilterApproved = true;
                                //                     if (mls_filter) {
                                //                         for (var s in item.data) {
                                //                             if (mls_filter[s] && item.data[s] != mls_filter[s]) {
                                //                                 bFilterApproved = false;
                                //                                 break;
                                //                             }
                                //                         }
                                //                     }
                                //
                                //                     // 1. #todo check if the component is already there (and duplicate items are allowed OR connection-id's
                                //
                                //                     // load
                                //                     if (bFilterApproved)
                                //                     {
                                //                         var mls_wrapper = $($container).attr("data-mimoto-wrapper");
                                //
                                //                         if (mls_wrapper)
                                //                         {
                                //                             MimotoX.utils.loadWrapper($container, item.connection.childEntityTypeName, item.connection.childId, mls_wrapper, mls_component.name, mls_contains);
                                //                         }
                                //                         else
                                //                         {
                                //                             if (mls_component !== undefined)
                                //                             {
                                //                                 MimotoX.utils.loadComponent($container, item.connection.childEntityTypeName, item.connection.childId, mls_component.name, mls_contains);
                                //                             }
                                //                         }
                                //                     }
                                //                 }
                                //             }
                                //
                                //             if (change.collection.removed)
                                //             {
                                //                 for (var iRemoved = 0; iRemoved < change.collection.removed.length; iRemoved++)
                                //                 {
                                //
                                //                     // register
                                //                     var item = change.collection.removed[iRemoved];
                                //
                                //                     // find
                                //                     var $item = $("[data-mimoto-id='" + item.connection.childEntityTypeName + "." + item.connection.childId + "']", $container);
                                //
                                //                     // delete
                                //                     $item.remove();
                                //                 }
                                //             }
                                //
                                //


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
                                    case 'collection': currentValue = change.value; break;
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
    },


    //
    //
    // /**
    //  * Handle data CHANGED
    //  */
    // onDataChanged: function(data, sChannel)
    // {
    //     // validate
    //     if (module.exports.prototype._validateMessage(module.exports.prototype._aParsedMessages, data.messageID, sChannel) !== false) return;
    //
    //
    //     console.log('Aimless - data.changed (via ' + ((sChannel) ? sChannel : 'webevent') + ')');
    //     console.log(data);
    //
    //
    //     // compose
    //     var sEntityIdentifier = data.entityType + '.' + data.entityId;
    //
    //     // update
    //     module.exports.prototype._updateValues(sEntityIdentifier, data.changes);
    //     module.exports.prototype._updateEntities(data.entityType, data.entityId, data.changes);
    //     module.exports.prototype._updateCollections(data.entityType, data.entityId, data.changes, data.connections);
    //     module.exports.prototype._updateSelections(data.entityType, data.entityId, data.changes);
    //     module.exports.prototype._updateInputFields(sEntityIdentifier, data.changes);
    //     module.exports.prototype._updateCounters(data.entityType, data.changes);
    //
    //     module.exports.prototype._triggerJavascriptListeners(sEntityIdentifier, data.changes);
    // },
    //
    // /**
    //  * Handle data CREATED
    //  */
    // onDataCreated: function(data, sChannel)
    // {
    //     // validate
    //     if (module.exports.prototype._validateMessage(module.exports.prototype._aParsedMessages, data.messageID, sChannel) !== false) return;
    //
    //     //console.clear();
    //     console.log('Aimless - data.created (via ' + ((sChannel) ? sChannel : 'webevent') + ')');
    //     console.log(data);
    //
    //
    //     // setup
    //     var sEntityType = data.entityType;
    //
    //     // register
    //     var classRoot = module.exports.prototype;
    //
    //
    //     // --- component level ---
    //
    //     // search
    //     var aComponents = $("[data-mimoto-contains='" + sEntityType + "']");
    //
    //
    //     aComponents.each( function(index, $container)
    //     {
    //         // read
    //         var mls_component = classRoot._getComponentName($($container).attr("data-mimoto-component"));
    //         var mls_sortorder = $($container).attr("data-mimoto--sortorder"); // #todo
    //         var mls_wrapper = $($container).attr("data-mimoto-wrapper");
    //         var mls_contains = $($container).attr("data-mimoto-contains");
    //
    //         console.warn('mls_contains = ' + mls_contains);
    //
    //         if (mls_wrapper)
    //         {
    //             MimotoX.utils.loadWrapper($container, data.entityType, data.entityId, mls_wrapper, mls_component.name, mls_contains);
    //         }
    //         else
    //         {
    //             console.log('Requesting component ...', data.entityType, data.entityId);
    //
    //             if (mls_component.name)
    //             {
    //                 MimotoX.utils.loadComponent($container, data.entityType, data.entityId, mls_component.name, mls_contains);
    //             }
    //         }
    //     });
    //
    //
    //     // --- selection level ---
    //
    //
    //     // search
    //     var aComponents = $("[data-mimoto-selection='" + sEntityType + "']");
    //
    //     aComponents.each( function(index, $component)
    //     {
    //         // read
    //         var mls_component = classRoot._getComponentName($($component).attr("data-mimoto-component"));
    //         var mls_sortorder = $($component).attr("data-mimoto--sortorder"); // #todo
    //         var mls_wrapper = $($component).attr("data-mimoto-wrapper");
    //
    //         if (mls_wrapper)
    //         {
    //             MimotoX.utils.loadWrapper($component, idata.entityType, data.entityId, mls_wrapper, mls_component.name);
    //         }
    //         else
    //         {
    //             if (mls_component.name)
    //             {
    //                 MimotoX.utils.loadComponent($component, data.entityType, data.entityId, mls_component.name);
    //             }
    //
    //         }
    //     });
    //
    //
    //
    //     // --- data-mimoto-count (onCreate) ---
    //
    //
    //     // search
    //     var aComponents = $("[data-mimoto-count='" + sEntityType + "']");
    //
    //     aComponents.each( function(index, $component)
    //     {
    //
    //         var mls_config = $($component).attr("data-mimoto-config");
    //
    //         if (mls_config) { mls_config = $.parseJSON(mls_config); }
    //
    //
    //         // read
    //         var nCurrentCount = parseInt($($component).text());
    //
    //         // update
    //         nCurrentCount = nCurrentCount + 1;
    //
    //         // output
    //         $($component).text(nCurrentCount);
    //
    //
    //         if (mls_config.toggleClasses)
    //         {
    //             for (var sKey in mls_config.toggleClasses)
    //             {
    //                 if (sKey == 'onZero' && nCurrentCount == 0)
    //                 {
    //                     $($component).addClass(mls_config.toggleClasses[sKey]);
    //                 }
    //                 else
    //                 {
    //                     $($component).removeClass(mls_config.toggleClasses[sKey]);
    //                 }
    //             }
    //         }
    //
    //     });
    //
    //
    //     // // search
    //     // var aComponents = $("[data-mimoto-display-showonempty='" + mls_container + "']");
    //     //
    //     // aComponents.each( function(index, $component)
    //     // {
    //     //     $($component).css({"display": ""});
    //     // });
    //
    //     var sEntityIdentifier = data.entityType + '.' + data.entityId;
    //     module.exports.prototype._triggerJavascriptListeners(sEntityIdentifier, data.changes);
    // },
    //
    // onPageChange: function (data)
    // {
    //     //Maido.page.change(data.url) ;//, data.config); -> load in iframe
    // },
    //
    // onComponentLoad: function (data)
    // {
    //     // o.a. remote dashboard control -> target = panel id
    // },
    //
    // onPopupOpen: function (data)
    // {
    //     // o.a. remote messages
    //     //Maido.popup.open(data.url);
    //     // voorzien van URL voor inhoud
    //     // use delegate -> MimotoLivescreen.onPopup = delegate(data)
    //     // kan form bevatten
    //
    //     //call option, zoals popup, met URL van popup-view of form
    // },
    //
    //
    //
    //
    // // ----------------------------------------------------------------------------
    // // --- Private methods ---------------------------------------------------------
    // // ----------------------------------------------------------------------------
    //
    //
    // /**
    //  * Change altered values currently present on the DOM
    //  * @private
    //  */
    // _updateValues: function (sEntityIdentifier, changes)
    // {
    //
    //     // skip if no changes
    //     if (!changes) return;
    //
    //
    //     // search
    //     var aValues = $("[data-mimoto-value]");
    //
    //     aValues.each( function(nIndex, $component)
    //     {
    //         // read
    //         var mls_value = $($component).attr("data-mimoto-value");
    //
    //         // determine
    //         var nOriginPos = mls_value.indexOf('[');
    //         var bHasOrigin = (nOriginPos !== -1) ;
    //
    //         // verify
    //         if (bHasOrigin)
    //         {
    //             var mls_value_origin = mls_value.substr(nOriginPos + 1, mls_value.length - nOriginPos - 2);
    //             var mls_value = mls_value.substr(0, nOriginPos);
    //         }
    //
    //
    //         // parse modified values
    //         for (var i = 0; i < changes.length; i++)
    //         {
    //             // register
    //             var change = changes[i];
    //
    //             // collection
    //             if (change.changes) continue;
    //
    //
    //             if (!bHasOrigin)
    //             {
    //                 // === value ===
    //
    //                 // Case 1: "project.3.name"
    //                 // Action: change project.3.name
    //                 // ------
    //                 // 1. find "project.3.name"
    //                 // 2. change value
    //
    //                 if (mls_value === (sEntityIdentifier + '.' + change.propertyName))
    //                 {
    //                     // output
    //                     $($component).text(change.value);
    //                 }
    //             }
    //             else
    //             {
    //                 // === entity ===
    //
    //                 // Case 2: - "project.3.client.name[client.17.name]"
    //                 // Action: change client.17.name
    //                 // ------
    //                 // 1. find "client.17.name" of "[client.17.name]"
    //                 // 2. change value
    //
    //
    //                 if (mls_value_origin ===  (sEntityIdentifier + '.' + change.propertyName))
    //                 {
    //                     // output
    //                     $($component).text(change.value);
    //                 }
    //                 else
    //                 {
    //
    //                     // Case 3: "project.3.client.name[client.17.name]"
    //                     // Action: change client to 8
    //                     // ------
    //                     // 1. find "project.3.client.name"
    //                     // 2. change "[client.17.name]" into "[client.8.name]"
    //                     // 3. change value
    //
    //                     // Case 4: "project.3.agency.name[agency.name]" (no agency set)
    //                     // Action: set agency to 5
    //                     // ------
    //                     // 1. find "project.3.agency" ------> (ignor rest?)
    //                     // 2. change to: "project.3.agency.name[agency.5.name]"
    //                     // 3. change value
    //
    //                     if (mls_value ===  (sEntityIdentifier + '.' + change.propertyName))
    //                     {
    //                         // output
    //                         $($component).text(change.value);
    //
    //                         // compose new
    //                         var new_mls_value_origin = change.origin.entityType;
    //                         if (change.origin.entityId) new_mls_value_origin += '.' + change.origin.entityId;
    //                         new_mls_value_origin += '.' + change.origin.propertyName;
    //
    //                         // update dom
    //                         $($component).attr('data-mimoto-value', mls_value + '[' + new_mls_value_origin + ']');
    //                     }
    //                 }
    //             }
    //         }
    //     });
    //
    //
    //
    //     // parse modified values
    //     for (var i = 0; i < changes.length; i++)
    //     {
    //         // register
    //         var change = changes[i];
    //
    //         // validate
    //         if (change.type != 'value') continue;
    //
    //         if (!change.value)
    //         {
    //             // search
    //             var aComponents = $("[data-mimoto-display-hideonempty='" + sEntityIdentifier + '.' + change.propertyName + "']");
    //
    //             aComponents.each( function(index, $component)
    //             {
    //                 $($component).css("display", "none");
    //             });
    //
    //             // search
    //             var aComponents = $("[data-mimoto-display-showonempty='" + sEntityIdentifier + '.' + change.propertyName + "']");
    //
    //             aComponents.each( function(index, $component)
    //             {
    //                 $($component).css("display", "");
    //             });
    //         }
    //         else
    //         {
    //             // search
    //             var aComponents = $("[data-mimoto-display-hideonempty='" + sEntityIdentifier + '.' + change.propertyName + "']");
    //
    //             aComponents.each( function(index, $component)
    //             {
    //                 $($component).css("display", "");
    //             });
    //
    //             // search
    //             var aComponents = $("[data-mimoto-display-showonempty='" + sEntityIdentifier + '.' + change.propertyName + "']");
    //
    //             aComponents.each( function(index, $component)
    //             {
    //                 $($component).css("display", "none");
    //             });
    //         }
    //
    //
    //     }
    // },
    //
    // /**
    //  * Update entities
    //  * @param string sEntityIdentifier
    //  * @param aray changes
    //  * @private
    //  */
    // _updateEntities: function (sEntityType, nEntityId, aChanges)
    // {
    //     // register
    //     var classRoot = this;
    //
    //     // compose
    //     var sEntityIdentifier = sEntityType + '.' + nEntityId;
    //
    //
    //     // --- force reload components
    //
    //     var aComponents = $("[data-mimoto-id='" + sEntityIdentifier + "']");
    //     aComponents.each(function (nIndex, $component)
    //     {
    //         // read
    //         var mls_reloadOnChange = $($component).attr("data-mimoto-reloadonchange");
    //
    //
    //         if (mls_reloadOnChange == 'true')
    //         {
    //             var mls_component = classRoot._getComponentName($($component).attr("data-mimoto-component"));
    //             var mls_wrapper = $($component).attr("data-mimoto-wrapper");
    //
    //             if (mls_wrapper)
    //             {
    //                 MimotoX.utils.updateWrapper($component, sEntityType, nEntityId, mls_wrapper, mls_component.name);
    //             }
    //             else
    //             {
    //                 if (mls_component.name)
    //                 {
    //                     MimotoX.utils.updateComponent($component, sEntityType, nEntityId, mls_component.name);
    //                 }
    //             }
    //         }
    //     });
    //
    //
    //
    //     // --- apply entityProperty changes
    //
    //
    //     // parse modified values
    //     for (var i = 0; i < aChanges.length; i++)
    //     {
    //         // register
    //         var change = aChanges[i];
    //
    //         // validate
    //         if (change.type != 'entity') continue;
    //
    //
    //         /**
    //          * Reatime image swap feature
    //          */
    //         if (change.subtype && change.subtype == 'image')
    //         {
    //             // search
    //             var aImages = $("[data-mimoto-image='" + sEntityIdentifier + "." + change.propertyName + "']");
    //
    //             if (change.entity && change.entity.file)
    //             {
    //                 // compose
    //                 var sImageSrc = change.entity.file.path + change.entity.file.name;
    //
    //                 // parse
    //                 aImages.each(function (nIndex, $image)
    //                 {
    //                     // swap
    //                     $($image).attr('src', sImageSrc);
    //                 });
    //             }
    //         }
    //
    //
    //
    //         // collect
    //         var aContainers = $("[data-mimoto-entity='" + sEntityIdentifier + "." + change.propertyName + "']");
    //
    //         aContainers.each(function (nIndex, $container)
    //         {
    //             // read
    //             var mls_entity = $($container).attr("data-mimoto-entity");
    //             var mls_component = classRoot._getComponentName($($container).attr("data-mimoto-component"));
    //
    //             // register
    //             var item = change.entity;
    //
    //             if (!item || !item.connection.id)
    //             {
    //                 $($container).empty();
    //             }
    //             else
    //             {
    //                 // load
    //                 MimotoX.utils.loadEntity($container, item.connection.childEntityTypeName, item.connection.childId, mls_component.name);
    //             }
    //         });
    //     }
    //
    //     // parse modified values
    //     for (var i = 0; i < aChanges.length; i++)
    //     {
    //         // register
    //         var change = aChanges[i];
    //
    //         // validate
    //         if (change.type != 'entity') continue;
    //
    //
    //         if (!change.entity)
    //         {
    //             // search
    //             var aComponents = $("[data-mimoto-display-hideonempty='" + sEntityIdentifier + '.' + change.propertyName + "']");
    //
    //             aComponents.each( function(index, $component)
    //             {
    //                 $($component).css("display", "none");
    //             });
    //
    //             // search
    //             var aComponents = $("[data-mimoto-display-showonempty='" + sEntityIdentifier + '.' + change.propertyName + "']");
    //
    //             aComponents.each( function(index, $component)
    //             {
    //                 $($component).css("display", "");
    //             });
    //         }
    //         else
    //         {
    //             // search
    //             var aComponents = $("[data-mimoto-display-hideonempty='" + sEntityIdentifier + '.' + change.propertyName + "']");
    //
    //             aComponents.each( function(index, $component)
    //             {
    //                 $($component).css("display", "");
    //             });
    //
    //             // search
    //             var aComponents = $("[data-mimoto-display-showonempty='" + sEntityIdentifier + '.' + change.propertyName + "']");
    //
    //             aComponents.each( function(index, $component)
    //             {
    //                 $($component).css("display", "none");
    //             });
    //         }
    //
    //
    //     }
    // },
    //
    // /**
    //  * Update collections
    //  * @param string sEntityIdentifier
    //  * @param aray changes
    //  * @private
    //  */
    // _updateCollections: function (sEntityType, nEntityId, aChanges, aConnections)
    // {
    //     // register
    //     var classRoot = this;
    //
    //
    //     // compose
    //     var sEntityIdentifier = sEntityType + '.' + nEntityId;
    //
    //     // parse modified values
    //     for (var i = 0; i < aChanges.length; i++)
    //     {
    //         // register
    //         var change = aChanges[i];
    //
    //         // collection
    //         if (!change.collection) continue;
    //
    //         // collect
    //         var aContainers = $("[data-mimoto-contains='" + sEntityIdentifier + "." + change.propertyName + "']");
    //
    //
    //         aContainers.each(function(nIndex, $container)
    //         {
    //             // read
    //             var mls_contains = $($container).attr("data-mimoto-contains");
    //             var mls_component = classRoot._getComponentName($($container).attr("data-mimoto-component"));
    //             var mls_filter = $($container).attr("data-mimoto-filter");
    //
    //             if (mls_filter) { mls_filter = $.parseJSON(mls_filter); }
    //
    //
    //             // --- handle added items ---
    //
    //             if (change.collection.added) {
    //
    //                 for (var iAdded = 0; iAdded < change.collection.added.length; iAdded++) {
    //
    //                     // register
    //                     var item = change.collection.added[iAdded];
    //
    //                     var bFilterApproved = true;
    //                     if (mls_filter) {
    //                         for (var s in item.data) {
    //                             if (mls_filter[s] && item.data[s] != mls_filter[s]) {
    //                                 bFilterApproved = false;
    //                                 break;
    //                             }
    //                         }
    //                     }
    //
    //                     // 1. #todo check if the component is already there (and duplicate items are allowed OR connection-id's
    //
    //                     // load
    //                     if (bFilterApproved)
    //                     {
    //                         var mls_wrapper = $($container).attr("data-mimoto-wrapper");
    //
    //                         if (mls_wrapper)
    //                         {
    //                             MimotoX.utils.loadWrapper($container, item.connection.childEntityTypeName, item.connection.childId, mls_wrapper, mls_component.name, mls_contains);
    //                         }
    //                         else
    //                         {
    //                             if (mls_component !== undefined)
    //                             {
    //                                 MimotoX.utils.loadComponent($container, item.connection.childEntityTypeName, item.connection.childId, mls_component.name, mls_contains);
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //
    //             if (change.collection.removed)
    //             {
    //                 for (var iRemoved = 0; iRemoved < change.collection.removed.length; iRemoved++)
    //                 {
    //
    //                     // register
    //                     var item = change.collection.removed[iRemoved];
    //
    //                     // find
    //                     var $item = $("[data-mimoto-id='" + item.connection.childEntityTypeName + "." + item.connection.childId + "']", $container);
    //
    //                     // delete
    //                     $item.remove();
    //                 }
    //             }
    //
    //
    //
    //             // --- change list item order
    //
    //             if (change.collection && change.collection.connections)
    //             {
    //                 // init
    //                 var $previousItem = null;
    //
    //                 var nConnectionCount = change.collection.connections.length;
    //                 for (var nConnectionIndex = 0; nConnectionIndex < nConnectionCount; nConnectionIndex++)
    //                 {
    //                     // register
    //                     var connection = change.collection.connections[nConnectionIndex];
    //
    //                     // register
    //                     var $currentItem = $('[data-mimoto-connection="' + connection.id + '"]', $container);
    //                     $currentItem.attr('data-mimoto-sortindex', connection.sortindex);
    //
    //                     // verify
    //                     if (nConnectionIndex == 0)
    //                     {
    //                         // move
    //                         $($container).prepend($currentItem[0]);
    //                     }
    //                     else
    //                     {
    //                         // move
    //                         $($currentItem[0]).insertAfter($previousItem);
    //                     }
    //
    //                     // update
    //                     $previousItem = $currentItem[0]
    //                 }
    //             }
    //
    //         });
    //     }
    //
    //
    //     // --- Parse modified values ---
    //
    //
    //     // verify
    //     if (aConnections)
    //     {
    //         var nConnectionCount = aConnections.length;
    //         for (var nConnectionIndex = 0; nConnectionIndex < nConnectionCount; nConnectionIndex++)
    //         {
    //             // register
    //             var connection = aConnections[nConnectionIndex];
    //
    //             // search
    //             var aContainers = $("[data-mimoto-contains='" + connection.parentEntityType + "." + connection.parentId + "." + connection.parentPropertyName + "']");
    //
    //
    //             aContainers.each(function(nIndex, $container)
    //             {
    //                 // read
    //                 var mls_contains = $($container).attr("data-mimoto-contains");
    //                 var mls_component = classRoot._getComponentName($($container).attr("data-mimoto-component"));
    //                 var mls_filter = $($container).attr("data-mimoto-filter");
    //
    //
    //                 console.warn('mls_filter = ' + mls_filter);
    //
    //                 if (mls_filter)
    //                 {
    //                     mls_filter = $.parseJSON(mls_filter);
    //
    //                     var bFilterApproved = true;
    //                     if (mls_filter)
    //                     {
    //                         for (var s in mls_filter)
    //                         {
    //                             var bPropertyFound = false;
    //                             for (var j = 0; j < aChanges.length; j++)
    //                             {
    //                                 // register
    //                                 var property = aChanges[j];
    //
    //                                 if (property.propertyName === s)
    //                                 {
    //                                     bPropertyFound = true;
    //                                     break;
    //                                 }
    //                             }
    //
    //                             console.log('Property check: ', property.value, '!=', mls_filter[s]);
    //
    //                             if (bPropertyFound && property.value != mls_filter[s])
    //                             {
    //                                 bFilterApproved = false;
    //                                 break;
    //                             }
    //                         }
    //                     }
    //
    //                     // load
    //                     if (bFilterApproved)
    //                     {
    //                         console.log('bFilterApproved ...', $container, connection);
    //
    //                         // search
    //                         let $aSubitems = $("[data-mimoto-connection='" + connection.connectionId + "']", $container);
    //
    //                         // verify if item already exists
    //                         if ($aSubitems.length === 0)
    //                         {
    //                             var mls_wrapper = $($container).attr("data-mimoto-wrapper");
    //
    //                             if (mls_wrapper)
    //                             {
    //                                 MimotoX.utils.loadWrapperNEW($container, sEntityType, nEntityId, mls_wrapper, mls_component.name, null, connection.connectionId);
    //                             }
    //                             else {
    //                                 if (mls_component.name)
    //                                 {
    //                                     MimotoX.utils.loadComponentNEW($container, sEntityType, nEntityId, mls_component.name, null, connection.connectionId);
    //                                 }
    //                             }
    //                         }
    //                     }
    //                     else
    //                     {
    //                         // search
    //                         var aSubitems = $("[data-mimoto-id='" + sEntityIdentifier + "']", $container);
    //
    //                         aSubitems.each(function (nIndex, $component) {
    //
    //                             // 2. add connection id
    //                             // 3. check if connection id exists
    //
    //                             // delete
    //                             $component.remove();
    //                         });
    //                     }
    //                 }
    //
    //                 // change item based on component
    //                 if (mls_component.conditionals.length > 0)
    //                 {
    //                     // verify
    //                     var bShouldToggle = false;
    //                     var nConditionalCount = mls_component.conditionals.length;
    //                     for (var nConditionalIndex = 0; nConditionalIndex < nConditionalCount; nConditionalIndex++)
    //                     {
    //                         for (var nChangeIndex = 0; nChangeIndex < aChanges.length; nChangeIndex++) {
    //                             // register
    //                             var property = aChanges[nChangeIndex];
    //
    //                             if (property.propertyName == mls_component.conditionals[nConditionalIndex]) {
    //                                 bShouldToggle = true;
    //                                 break;
    //                             }
    //                         }
    //                     }
    //
    //                     if (bShouldToggle)
    //                     {
    //                         // search
    //                         var aSubitems = $("[data-mimoto-id='" + sEntityIdentifier + "']", $container);
    //
    //                         aSubitems.each(function (nIndex, $component)
    //                         {
    //                             // delete current
    //                             $component.remove();
    //
    //                             // reload with new template
    //                             //MimotoX.utils.loadComponent($container, sEntityType, nEntityId, mls_component.name);
    //
    //                             var mls_wrapper = $($container).attr("data-mimoto-wrapper");
    //
    //                             if (mls_wrapper)
    //                             {
    //                                 MimotoX.utils.loadWrapper($container, sEntityType, nEntityId, mls_wrapper, mls_component.name);
    //                             }
    //                             else
    //                             {
    //                                 if (mls_component.name)
    //                                 {
    //                                     MimotoX.utils.loadComponent($container, sEntityType, nEntityId, mls_component.name);
    //                                 }
    //                             }
    //                         });
    //                     }
    //                 }
    //
    //
    //             });
    //         }
    //     }
    //
    //
    //     // parse modified values
    //     for (var i = 0; i < aChanges.length; i++)
    //     {
    //         // register
    //         var change = aChanges[i];
    //
    //         // validate
    //         if (change.type != 'collection') continue;
    //
    //         if (change.collection.count == 0)
    //         {
    //             // search
    //             var aComponents = $("[data-mimoto-display-hideonempty='" + sEntityIdentifier + '.' + change.propertyName + "']");
    //
    //             aComponents.each( function(index, $component)
    //             {
    //                 $($component).css("display", "none");
    //             });
    //
    //             // search
    //             var aComponents = $("[data-mimoto-display-showonempty='" + sEntityIdentifier + '.' + change.propertyName + "']");
    //
    //             aComponents.each( function(index, $component)
    //             {
    //                 $($component).css("display", "");
    //             });
    //         }
    //         else
    //         {
    //             // search
    //             var aComponents = $("[data-mimoto-display-hideonempty='" + sEntityIdentifier + '.' + change.propertyName + "']");
    //
    //             aComponents.each( function(index, $component)
    //             {
    //                 $($component).css("display", "");
    //             });
    //
    //             // search
    //             var aComponents = $("[data-mimoto-display-showonempty='" + sEntityIdentifier + '.' + change.propertyName + "']");
    //
    //             aComponents.each( function(index, $component)
    //             {
    //                 $($component).css("display", "none");
    //             });
    //         }
    //
    //
    //     }
    // },
    //
    // /**
    //  * Update selections collections by moving or removing altered items
    //  * @param changes
    //  * @private
    //  */
    // _updateSelections: function (sEntityType, sEntityId, changes)
    // {
    //     // register
    //     var classRoot = this;
    //
    //
    //     // parse modified values
    //     for (var i = 0; i < changes.length; i++)
    //     {
    //         // register
    //         var change = changes[i];
    //
    //
    //         var aContainers = $("[data-mimoto-selection='" + sEntityType + "']");
    //
    //
    //         aContainers.each(function(nIndex, $container)
    //         {
    //             // read
    //             var mls_selection = $($container).attr("data-mimoto-selection");
    //             var mls_component = classRoot._getComponentName($($container).attr("data-mimoto-component"));
    //             var mls_filter = $($container).attr("data-mimoto-filter");
    //
    //             if (mls_filter) { mls_filter = $.parseJSON(mls_filter); }
    //
    //
    //             // 1. read data-mimoto-id's van items binnen component
    //
    //
    //             var aSubitems = $("[data-mimoto-id='" + sEntityType + '.' + sEntityId + "']", $container);
    //
    //
    //             aSubitems.each(function(nIndex, $subitem)
    //             {
    //                 var bFilterApproved = true;
    //                 if (mls_filter)
    //                 {
    //                     for (var s in mls_filter)
    //                     {
    //                         if (mls_filter[s] && change.value != mls_filter[s]) {
    //                             bFilterApproved = false;
    //                             break;
    //                         }
    //                     }
    //                 }
    //
    //                 // load
    //                 if (!bFilterApproved) { $subitem.remove(); }
    //
    //             });
    //
    //         });
    //     }
    // },
    //
    // /**
    //  * Update input fields
    //  * @private
    //  */
    // _updateInputFields: function (sEntityIdentifier, changes)
    // {
    //     // search
    //     var aValues = $("[data-mimoto-form-field-input]");
    //
    //     aValues.each( function(nIndex, $component)
    //     {
    //         // read
    //         var mls_form_field_input = $($component).attr("data-mimoto-form-field-input");
    //
    //         // determine
    //         var nOriginPos = mls_form_field_input.indexOf('[');
    //         var bHasOrigin = (nOriginPos !== -1) ;
    //
    //         // verify
    //         if (bHasOrigin)
    //         {
    //             var mls_value_origin = mls_form_field_input.substr(nOriginPos + 1, mls_form_field_input.length - nOriginPos - 2);
    //             var mls_form_field_input = mls_form_field_input.substr(0, nOriginPos);
    //         }
    //
    //
    //         // parse modified values
    //         for (var i = 0; i < changes.length; i++)
    //         {
    //             // register
    //             var change = changes[i];
    //
    //             // collection
    //             if (change.changes) continue;
    //
    //
    //             if (!bHasOrigin)
    //             {
    //                 if (mls_form_field_input === (sEntityIdentifier + '.' + change.propertyName))
    //                 {
    //                     Mimoto.form._setInputFieldValue($component, change.value);
    //                 }
    //             }
    //         }
    //     });
    // },
    //
    // _updateCounters: function (sEntityType, changes)
    // {
    //
    //     // search
    //     var aComponents = $("[data-mimoto-count='" + sEntityType + "']");
    //
    //     aComponents.each( function(index, $component)
    //     {
    //
    //         var mls_filter = $($component).attr("data-mimoto-filter");
    //
    //         if (mls_filter) { mls_filter = $.parseJSON(mls_filter); }
    //
    //
    //         // parse modified values
    //         for (var i = 0; i < changes.length; i++)
    //         {
    //             // register
    //             var change = changes[i];
    //
    //             var bFilterApproved = true;
    //             if (mls_filter)
    //             {
    //                 for (var s in mls_filter)
    //                 {
    //                     if (mls_filter[s] && change.value != mls_filter[s]) {
    //                         bFilterApproved = false;
    //                         break;
    //                     }
    //                 }
    //             }
    //
    //             // load
    //             if (!bFilterApproved)
    //             {
    //                 var mls_config = $($component).attr("data-mimoto-config");
    //
    //                 if (mls_config) { mls_config = $.parseJSON(mls_config); }
    //
    //
    //                 // read
    //                 var nCurrentCount = parseInt($($component).text());
    //
    //                 // update
    //                 nCurrentCount = Math.max(0, nCurrentCount - 1);
    //
    //                 // output
    //                 $($component).text(nCurrentCount);
    //
    //
    //                 if (mls_config.toggleClasses)
    //                 {
    //                     for (var sKey in mls_config.toggleClasses)
    //                     {
    //                         if (sKey == 'onZero' && nCurrentCount == 0)
    //                         {
    //                             $($component).addClass(mls_config.toggleClasses[sKey]);
    //                         }
    //                         else
    //                         {
    //                             $($component).removeClass(mls_config.toggleClasses[sKey]);
    //                         }
    //                     }
    //                 }
    //             }
    //
    //         }
    //
    //     });
    // },
    //
    // _triggerJavascriptListeners: function(sEntityIdentifier, aChanges)
    // {
    //     console.log('_triggerJavascriptListeners triggered ...');
    //
    //     // validate
    //     if (!this._aEventListeners || !aChanges) return;
    //
    //     // parse modified values
    //     var nChangeCount = aChanges.length;
    //     for (var nChangeIndex = 0; nChangeIndex < nChangeCount; nChangeIndex++)
    //     {
    //         // register
    //         var change = aChanges[nChangeIndex];
    //
    //         // find event listeners
    //         var nListenerCount = this._aEventListeners.length;
    //         for (var nListenerIndex = 0; nListenerIndex < nListenerCount; nListenerIndex++)
    //         {
    //             // register
    //             var listener = this._aEventListeners[nListenerIndex];
    //
    //             if (listener.sPropertySelector == sEntityIdentifier + '.' + change.propertyName)
    //             {
    //                 // execute
    //                 listener.fJavascriptDelegate.apply(listener.scope, change);
    //             }
    //         }
    //     }
    // },
    //
    // /**
    //  * Get component name and conditionals
    //  * Format of the value "subproject_phase" or "subproject_phase[phase]"
    //  * @param sValue
    //  * @private
    //  */
    // _getComponentName: function (sComponentInfo)
    // {
    //     // init
    //     var component = {};
    //
    //
    //     if (!sComponentInfo)
    //     {
    //         component.name = '';
    //         component.conditionals = [];
    //     }
    //     else
    //     {
    //         // search
    //         var nComponentNameConditionalsPos = sComponentInfo.indexOf('[');
    //
    //         if (nComponentNameConditionalsPos != -1)
    //         {
    //             // strip
    //             var sComponentConditionals = sComponentInfo.substring(nComponentNameConditionalsPos + 1, sComponentInfo.length - 1);
    //
    //             // store
    //             component.name = sComponentInfo.substr(0, nComponentNameConditionalsPos);
    //             component.conditionals = (sComponentConditionals) ? sComponentConditionals.split(',') : [];
    //         }
    //         else
    //         {
    //             // store
    //             component.name = sComponentInfo;
    //             component.conditionals = [];
    //         }
    //     }
    //
    //     // send
    //     return component;
    // },
    //
    // /**
    //  * Validate if data modifications already have been locally handled parsed
    //  * @param messageID
    //  * @returns boolean
    //  * @private
    //  */
    // _validateMessage: function (aParsedMessages, message, sChannel)
    // {
    //     // init
    //     var bHasBeenParsed = false;
    //
    //     // default
    //     if (!sChannel) sChannel = 'webevent';
    //
    //     if (!aParsedMessages[message.uid])
    //     {
    //         // register
    //         message.channel = sChannel;
    //
    //         // store
    //         aParsedMessages[message.uid] = message;
    //     }
    //     else
    //     {
    //         if (aParsedMessages[message.uid].channel != sChannel)
    //         {
    //             bHasBeenParsed = true;
    //         }
    //     }
    //
    //     // auto cleanup older messages
    //     var nAgeInSeconds = 5 * 60; // set to 5 minutes
    //     for (var sUID in aParsedMessages)
    //     {
    //         // register
    //         var parsedMessage = aParsedMessages[sUID];
    //
    //         // check and remove
    //         if (parseInt(message.timestamp) - parseInt(parsedMessage.timestamp) > nAgeInSeconds)
    //         {
    //             delete aParsedMessages[parsedMessage.uid];
    //         }
    //     }
    //
    //     // send
    //     return bHasBeenParsed;
    // }
    //
    
}
