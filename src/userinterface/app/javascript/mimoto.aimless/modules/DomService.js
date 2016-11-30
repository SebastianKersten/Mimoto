/**
 * Mimoto.CMS - Form handling
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


module.exports = function() {

    // start
    this.__construct();
};

module.exports.prototype = {



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function()
    {
        
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Handle data CHANGED
     */
    onDataChanged: function(data)
    {
        console.log('Aimless - data.changed');
        console.log(data);
        
        
        // compose
        var sEntityIdentifier = data.entityType + '.' + data.entityId;
        
        // update
        module.exports.prototype._updateValues(sEntityIdentifier, data.changes);
        module.exports.prototype._updateEntities(data.entityType, data.entityId, data.changes);
        module.exports.prototype._updateCollections(data.entityType, data.entityId, data.changes, data.connections);
        module.exports.prototype._updateSelections(data.entityType, data.entityId, data.changes);
        module.exports.prototype._updateInputFields(data.changes);
        module.exports.prototype._updateCounters(data.entityType, data.changes);
    },
    
    /**
     * Handle data CREATED
     */
    onDataCreated: function(data)
    {
        // setup
        var mls_container = data.entityType;
    
        // register
        var classRoot = module.exports.prototype;
    
        console.log('Aimless - data.created');
        console.log(data);
        
        
        
        //console.clear();
    
        
    
    
        // --- component level ---
    
        // search
        var aComponents = $("[mls_contains='" + mls_container + "']");
    
        aComponents.each( function(index, $component)
        {
            // read
            var mls_component = classRoot._getComponentName($($component).attr("mls_component"));
            var mls_sortorder = $($component).attr("mls_sortorder"); // #todo
        
            // verify
            if (mls_component !== undefined)
            {
                $.ajax({
                    type: 'GET',
                    url: '/Mimoto.Aimless/data/' + data.entityType + '/' + data.entityId + '/' + mls_component.name,
                    data: null,
                    dataType: 'html',
                    success: function (data) {
                        $($component).append(data);
                    }
                });
            }
        
        });
    
    
        // section level
        // search
        var aComponents = $("[mls_selection='" + mls_container + "']");
    
        aComponents.each( function(index, $component)
        {
            // read
            var mls_component = classRoot._getComponentName($($component).attr("mls_component"));
            var mls_sortorder = $($component).attr("mls_sortorder"); // #todo
        
            // verify
            if (mls_component.name !== undefined)
            {
                $.ajax({
                    type: 'GET',
                    url: '/Mimoto.Aimless/data/' + data.entityType + '/' + data.entityId + '/' + mls_component.name,
                    data: null,
                    dataType: 'html',
                    success: function (data) {
                        $($component).append(data);
                    }
                });
            }
        
        });
    
    
    
        // --- mls_count (onCreate) ---
    
    
        // search
        var aComponents = $("[mls_count='" + mls_container + "']");
    
        aComponents.each( function(index, $component)
        {
        
            var mls_config = $($component).attr("mls_config");
        
            if (mls_config) { mls_config = $.parseJSON(mls_config); }
        
        
            // read
            var nCurrentCount = parseInt($($component).text());
        
            // update
            nCurrentCount = nCurrentCount + 1;
        
            // output
            $($component).text(nCurrentCount);
        
        
            if (mls_config.toggleClasses)
            {
                for (var sKey in mls_config.toggleClasses)
                {
                    if (sKey == 'onZero' && nCurrentCount == 0)
                    {
                        $($component).addClass(mls_config.toggleClasses[sKey]);
                    }
                    else
                    {
                        $($component).removeClass(mls_config.toggleClasses[sKey]);
                    }
                }
            }
        
        });
        
    },
    
    onPageChange: function (data)
    {
        //Maido.page.change(data.url) ;//, data.config); -> load in iframe
    },
    
    onComponentLoad: function (data)
    {
        // o.a. remote dashboard control -> target = panel id
    },
    
    onPopupOpen: function (data)
    {
        // o.a. remote messages
        //Maido.popup.open(data.url);
        // voorzien van URL voor inhoud
        // use delegate -> MimotoLivescreen.onPopup = delegate(data)
        // kan form bevatten
    
        //call option, zoals popup, met URL van popup-view of form
    },
    
    
    
    
    // ----------------------------------------------------------------------------
    // --- Private methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Change altered values currently present on the DOM
     * @private
     */
    _updateValues: function (sEntityIdentifier, changes)
    {
    
        // skip if no changes
        if (!changes) return;
        
        
        // search
        var aValues = $("[mls_value]");
    
        aValues.each( function(nIndex, $component)
        {
            // read
            var mls_value = $($component).attr("mls_value");
        
            // determine
            var nOriginPos = mls_value.indexOf('[');
            var bHasOrigin = (nOriginPos !== -1) ;
        
            // verify
            if (bHasOrigin)
            {
                var mls_value_origin = mls_value.substr(nOriginPos + 1, mls_value.length - nOriginPos - 2);
                var mls_value = mls_value.substr(0, nOriginPos);
            }
        
        
            // parse modified values
            for (var i = 0; i < changes.length; i++)
            {
                // register
                var change = changes[i];
            
                // collection
                if (change.changes) continue;
            
            
                if (!bHasOrigin)
                {
                    // === value ===
                
                    // Case 1: "project.3.name"
                    // Action: change project.3.name
                    // ------
                    // 1. find "project.3.name"
                    // 2. change value
                
                    if (mls_value === (sEntityIdentifier + '.' + change.propertyName))
                    {
                        // output
                        $($component).text(change.value);
                    }
                }
                else
                {
                    // === entity ===
                
                    // Case 2: - "project.3.client.name[client.17.name]"
                    // Action: change client.17.name
                    // ------
                    // 1. find "client.17.name" of "[client.17.name]"
                    // 2. change value
                
                
                    if (mls_value_origin ===  (sEntityIdentifier + '.' + change.propertyName))
                    {
                        // output
                        $($component).text(change.value);
                    }
                    else
                    {
                    
                        // Case 3: "project.3.client.name[client.17.name]"
                        // Action: change client to 8
                        // ------
                        // 1. find "project.3.client.name"
                        // 2. change "[client.17.name]" into "[client.8.name]"
                        // 3. change value
                    
                        // Case 4: "project.3.agency.name[agency.name]" (no agency set)
                        // Action: set agency to 5
                        // ------
                        // 1. find "project.3.agency" ------> (ignor rest?)
                        // 2. change to: "project.3.agency.name[agency.5.name]"
                        // 3. change value
                    
                        if (mls_value ===  (sEntityIdentifier + '.' + change.propertyName))
                        {
                            // output
                            $($component).text(change.value);
                        
                            // compose new
                            var new_mls_value_origin = change.origin.entityType;
                            if (change.origin.entityId) new_mls_value_origin += '.' + change.origin.entityId;
                            new_mls_value_origin += '.' + change.origin.propertyName;
                        
                            // update dom
                            $($component).attr('mls_value', mls_value + '[' + new_mls_value_origin + ']');
                        }
                    }
                }
            }
        });
    },
    
    /**
     * Update entities
     * @param string sEntityIdentifier
     * @param aray changes
     * @private
     */
    _updateEntities: function (sEntityType, nEntityId, aChanges)
    {
        // register
        var classRoot = this;
        
        
        // compose
        var sEntityIdentifier = sEntityType + '.' + nEntityId;
    
        // parse modified values
        for (var i = 0; i < aChanges.length; i++)
        {
            // register
            var change = aChanges[i];
            
            
            if (change.type != 'entity') continue;
            
            
            // collect
            var aContainers = $("[data-aimless-entity='" + sEntityIdentifier + "." + change.propertyName + "']");
            
            aContainers.each(function (nIndex, $container)
            {
                // read
                var mls_entity = $($container).attr("data-aimless-entity");
                var mls_component = classRoot._getComponentName($($container).attr("mls_component"));
                
                // register
                var item = change.entity;
                
                if (!item || !item.connection.id)
                {
                    $($container).empty();
                }
                else
                {
                    // load
                    Mimoto.Aimless.utils.loadEntity($container, item.connection.childEntityTypeName, item.connection.childId, mls_component.name);
                }
            });
        }
    },
    
    /**
     * Update collections
     * @param string sEntityIdentifier
     * @param aray changes
     * @private
     */
    _updateCollections: function (sEntityType, nEntityId, aChanges, aConnections)
    {
        //console.warn(aChanges);
        //console.warn(aConnections);
    
        // register
        var classRoot = this;
        
        
        // compose
        var sEntityIdentifier = sEntityType + '.' + nEntityId;
        
        // parse modified values
        for (var i = 0; i < aChanges.length; i++)
        {
            // register
            var change = aChanges[i];
            
            // collection
            if (!change.collection) continue;
            
            // collect
            var aContainers = $("[mls_contains='" + sEntityIdentifier + "." + change.propertyName + "']");
        
        
            aContainers.each(function(nIndex, $container)
            {
                // read
                var mls_contains = $($container).attr("mls_contains");
                var mls_component = classRoot._getComponentName($($container).attr("mls_component"));
                var mls_filter = $($container).attr("mls_filter");
                
                
                if (mls_filter) { mls_filter = $.parseJSON(mls_filter); }
            
            
                // --- handle added items ---
            
                if (change.collection.added) {
                
                    for (var iAdded = 0; iAdded < change.collection.added.length; iAdded++) {
                    
                        // register
                        var item = change.collection.added[iAdded];
                    
                        var bFilterApproved = true;
                        if (mls_filter) {
                            for (var s in item.data) {
                                if (mls_filter[s] && item.data[s] != mls_filter[s]) {
                                    bFilterApproved = false;
                                    break;
                                }
                            }
                        }
                        
                        // 1. #todo check if the component is already there (and duplicate items are allowed OR connection-id's
                    
                        // load
                        if (bFilterApproved)
                        {
                            Mimoto.Aimless.utils.loadComponent($container, item.connection.childEntityTypeName, item.connection.childId, mls_component.name);
                        }
                    }
                }
            
                if (change.collection.removed)
                {
                    for (var iRemoved = 0; iRemoved < change.collection.removed.length; iRemoved++)
                    {
                    
                        // register
                        var item = change.collection.removed[iRemoved];
                    
                        // find
                        var $item = $("[mls_id='" + item.connection.childEntityTypeName + "." + item.connection.childId + "']", $container);
                    
                        // delete
                        $item.remove();
                    }
                }
            
            });
        }
    
    
        // --- Parse modified values ---
        
        
        // verify
        if (aConnections)
        {
            var nConnectionCount = aConnections.length;
            for (var nConnectionIndex = 0; nConnectionIndex < nConnectionCount; nConnectionIndex++)
            {
                // register
                var connection = aConnections[nConnectionIndex];

                // search
                var aContainers = $("[mls_contains='" + connection.parentEntityType + "." + connection.parentId + "." + connection.parentPropertyName + "']");
                
                
                aContainers.each(function(nIndex, $container)
                {
                    // read
                    var mls_contains = $($container).attr("mls_contains");
                    var mls_component = classRoot._getComponentName($($container).attr("mls_component"));
                    var mls_filter = $($container).attr("mls_filter");
                    
                    
                    
                    if (mls_filter)
                    {
                        mls_filter = $.parseJSON(mls_filter);
                        
                        var bFilterApproved = true;
                        if (mls_filter) {
                            for (var s in mls_filter) {
                                var bPropertyFound = false;
                                for (var j = 0; j < aChanges.length; j++) {
                                    // register
                                    var property = aChanges[j];
                
                                    if (property.propertyName == s) {
                                        bPropertyFound = true;
                                        break;
                                    }
                                }
            
                                if (!(bPropertyFound && property.value == mls_filter[s])) {
                                    bFilterApproved = false;
                                    break;
                                }
                            }
                        }
    
                        // load
                        if (bFilterApproved)
                        {
                            Mimoto.Aimless.utils.loadComponent($container, sEntityType, nEntityId, mls_component.name);
                        }
                        else {
                            // search
                            var aSubitems = $("[mls_id='" + sEntityIdentifier + "']", $container);
        
                            aSubitems.each(function (nIndex, $component) {
            
                                // 2. add connection id
                                // 3. check if connection id exists
            
                                // delete
                                $component.remove();
                            });
                        }
                    }
                    
                    // change item based on component
                    if (mls_component.conditionals.length > 0)
                    {
                        // verify
                        var bShouldToggle = false;
                        var nConditionalCount = mls_component.conditionals.length;
                        for (var nConditionalIndex = 0; nConditionalIndex < nConditionalCount; nConditionalIndex++)
                        {
                            for (var nChangeIndex = 0; nChangeIndex < aChanges.length; nChangeIndex++) {
                                // register
                                var property = aChanges[nChangeIndex];
        
                                if (property.propertyName == mls_component.conditionals[nConditionalIndex]) {
                                    bShouldToggle = true;
                                    break;
                                }
                            }
                        }
                        
                        if (bShouldToggle)
                        {
                            // search
                            var aSubitems = $("[mls_id='" + sEntityIdentifier + "']", $container);
    
                            aSubitems.each(function (nIndex, $component)
                            {
                                // delete current
                                $component.remove();
                                
                                // reload with new template
                                Mimoto.Aimless.utils.loadComponent($container, sEntityType, nEntityId, mls_component.name);
                            });
                        }
                    }
                    
                    
                });
            }
        }
    },
    
    /**
     * Update selections collections by moving or removing altered items
     * @param changes
     * @private
     */
    _updateSelections: function (sEntityType, sEntityId, changes)
    {
        // register
        var classRoot = this;
        
        
        // parse modified values
        for (var i = 0; i < changes.length; i++)
        {
            // register
            var change = changes[i];
        
        
            var aContainers = $("[mls_selection='" + sEntityType + "']");
        
        
            aContainers.each(function(nIndex, $container)
            {
                // read
                var mls_selection = $($container).attr("mls_selection");
                var mls_component = classRoot._getComponentName($($container).attr("mls_component"));
                var mls_filter = $($container).attr("mls_filter");
            
                if (mls_filter) { mls_filter = $.parseJSON(mls_filter); }
            
            
                // 1. read mls_id's van items binnen component
            
            
                var aSubitems = $("[mls_id='" + sEntityType + '.' + sEntityId + "']", $container);
            
            
                aSubitems.each(function(nIndex, $subitem)
                {
                    var bFilterApproved = true;
                    if (mls_filter)
                    {
                        for (var s in mls_filter)
                        {
                            if (mls_filter[s] && change.value != mls_filter[s]) {
                                bFilterApproved = false;
                                break;
                            }
                        }
                    }
                
                    // load
                    if (!bFilterApproved) { $subitem.remove(); }
                
                });
            
            });
        }
    },
    
    /**
     * Update input fields
     * @private
     */
    _updateInputFields: function (changes)
    {
        // search
        var aValues = $("[mls_form_field_input]");
        
        aValues.each( function(nIndex, $component)
        {
            // read
            var mls_form_field_input = $($component).attr("mls_form_field_input");
        
            // determine
            var nOriginPos = mls_form_field_input.indexOf('[');
            var bHasOrigin = (nOriginPos !== -1) ;
        
            // verify
            if (bHasOrigin)
            {
                var mls_value_origin = mls_form_field_input.substr(nOriginPos + 1, mls_form_field_input.length - nOriginPos - 2);
                var mls_form_field_input = mls_form_field_input.substr(0, nOriginPos);
            }
        
        
            // parse modified values
            for (var i = 0; i < changes.length; i++)
            {
                // register
                var change = changes[i];
            
                // collection
                if (change.changes) continue;
            
            
                if (!bHasOrigin)
                {
                    if (mls_form_field_input === (sEntityIdentifier + '.' + change.propertyName))
                    {
                        Mimoto.form._setInputFieldValue($component, change.value);
                    }
                }
            }
        });
    },
    
    _updateCounters: function (sEntityType, changes)
    {
    
        // search
        var aComponents = $("[mls_count='" + sEntityType + "']");
    
        aComponents.each( function(index, $component)
        {
        
            var mls_filter = $($component).attr("mls_filter");
        
            if (mls_filter) { mls_filter = $.parseJSON(mls_filter); }
        
        
            // parse modified values
            for (var i = 0; i < changes.length; i++)
            {
                // register
                var change = changes[i];
            
                var bFilterApproved = true;
                if (mls_filter)
                {
                    for (var s in mls_filter)
                    {
                        if (mls_filter[s] && change.value != mls_filter[s]) {
                            bFilterApproved = false;
                            break;
                        }
                    }
                }
            
                // load
                if (!bFilterApproved)
                {
                    var mls_config = $($component).attr("mls_config");
                
                    if (mls_config) { mls_config = $.parseJSON(mls_config); }
                
                
                    // read
                    var nCurrentCount = parseInt($($component).text());
                
                    // update
                    nCurrentCount = Math.max(0, nCurrentCount - 1);
                
                    // output
                    $($component).text(nCurrentCount);
                
                
                    if (mls_config.toggleClasses)
                    {
                        for (var sKey in mls_config.toggleClasses)
                        {
                            if (sKey == 'onZero' && nCurrentCount == 0)
                            {
                                $($component).addClass(mls_config.toggleClasses[sKey]);
                            }
                            else
                            {
                                $($component).removeClass(mls_config.toggleClasses[sKey]);
                            }
                        }
                    }
                }
            
            }
        
        });
    },
    
    /**
     * Get component name and conditionals
     * Format of the value "subproject_phase" or "subproject_phase[phase]"
     * @param sValue
     * @private
     */
    _getComponentName: function (sComponentInfo)
    {
        // init
        var component = {};
    
        // search
        var nComponentNameConditionalsPos = sComponentInfo.indexOf('[');
    
        if (nComponentNameConditionalsPos != -1)
        {
            // strip
            var sComponentConditionals = sComponentInfo.substring(nComponentNameConditionalsPos + 1, sComponentInfo.length - 1);
            
            // store
            component.name = sComponentInfo.substr(0, nComponentNameConditionalsPos);
            component.conditionals = (sComponentConditionals) ? sComponentConditionals.split(',') : [];
        }
        else
        {
            // store
            component.name = sComponentInfo;
            component.conditionals = [];
        }
    
        // send
        return component;
    }
    
}
