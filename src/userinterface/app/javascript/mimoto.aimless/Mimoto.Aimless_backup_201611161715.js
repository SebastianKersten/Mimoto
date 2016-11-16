/**
 * Aimless - Mimoto's LiveScreen protocol
 * 
 * @author Sebastian Kersten (@supertaboo)
 */

if (typeof Mimoto == "undefined") Mimoto = {};
Mimoto.Aimless = {};
Mimoto.Aimless.realtime = {};
if (typeof Mimoto.CMS == "undefined") Mimoto.CMS = {};

// #todo - scrollpos correctie!


//components,        
//subcomponents
//values / fields

Mimoto.Aimless.connect = function()
{
    
    // Enable pusher logging - don't include this in production
    Pusher.log = function(message) {
        if (window.console && window.console.log) { window.console.log(message); }
    };

    Mimoto.Aimless.pusher = new Pusher('55152f70c4cec27de21d', {
        cluster: 'eu',
        encrypted: true,
        authEndpoint: '/Mimoto.Aimless/realtime/collaboration'
    });


    var channel = Mimoto.Aimless.pusher.subscribe('Aimless');

    channel.bind('data.changed', function(data) // update, create, remove (, read?)
    {
        // compose
        var sEntityIdentifier = data.entityType + '.' + data.entityId;
        
        
        // --- value level ---
        
        
        //console.clear();
        
        
        console.log('Aimless - data.changed');
        console.log(data);



        
        // check
        if (data.changes)
        {
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
                for (var i = 0; i < data.changes.length; i++)
                {
                    // register
                    var change = data.changes[i];
                    
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
        }
        
        
        // parse modified values
        for (var i = 0; i < data.changes.length; i++)
        {
            // register
            var change = data.changes[i];

            // collection
            if (!change.collection) continue;



            var aContainers = $("[mls_contains='" + sEntityIdentifier + "." + change.propertyName + "']");


            aContainers.each(function(nIndex, $component)
            {
                // read
                var mls_contains = $($component).attr("mls_contains");
                var mls_component = $($component).attr("mls_component");
                var mls_filter = $($component).attr("mls_filter");
                
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
                        if (bFilterApproved) Mimoto.Aimless.utils.loadComponent($component, item.connection.childEntityTypeName, item.connection.childId, mls_component);
                    }
                }

                if (change.collection.removed)
                {
                    for (var iRemoved = 0; iRemoved < change.collection.removed.length; iRemoved++)
                    {

                        // register
                        var item = change.collection.removed[iRemoved];

                        // find
                        $item = $("[mls_id='" + item.connection.childEntityTypeName + "." + item.connection.childId + "']", $component);

                        // delete
                        $item.remove();
                    }
                }


            });
        }




        /**
         * Remove any items within a selection that aren't supposed to be shown anymore
         */

        // parse modified values
        for (var i = 0; i < data.changes.length; i++)
        {
            // register
            var change = data.changes[i];


            var aContainers = $("[mls_selection='" + data.entityType + "']");


            aContainers.each(function(nIndex, $container)
            {
                // read
                var mls_selection = $($container).attr("mls_selection");
                var mls_component = $($container).attr("mls_component");
                var mls_filter = $($container).attr("mls_filter");

                if (mls_filter) { mls_filter = $.parseJSON(mls_filter); }


                // 1. read mls_id's van items binnen component


                var aSubitems = $("[mls_id='" + data.entityType + '.' + data.entityId + "']", $container);


                aSubitems.each(function(nIndex, $subitem)
                {
                    var bFilterApproved = true;
                    if (mls_filter)
                    {
                        for (s in mls_filter)
                        {
                            if (mls_filter[s] && change.value != mls_filter[s]) {
                                bFilterApproved = false;
                                break;
                            }
                        }
                    }

                    // load
                    if (!bFilterApproved) { console.log('Remove item!'); $subitem.remove(); }

                });

            });
        }



        // input fields

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
            for (var i = 0; i < data.changes.length; i++)
            {
                // register
                var change = data.changes[i];

                // collection
                if (change.changes) continue;


                if (!bHasOrigin)
                {
                    if (mls_form_field_input === (sEntityIdentifier + '.' + change.propertyName))
                    {
                        Mimoto.form.setInputFieldValue($component, value);
                    }
                }
            }
        });


        // --- mls_count (onUpdate)---


        // search
        var aComponents = $("[mls_count='" + data.entityType + "']");

        aComponents.each( function(index, $component)
        {

            var mls_filter = $($component).attr("mls_filter");

            if (mls_filter) { mls_filter = $.parseJSON(mls_filter); }


            // parse modified values
            for (var i = 0; i < data.changes.length; i++)
            {
                // register
                var change = data.changes[i];

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
    });

    
    channel.bind('data.create', function(data)
    {
        // setup
        var mls_container = data.entityType;
        
        
        //console.clear();
        
        console.log('Aimless - data.create');
        console.log(data);
        

        // --- component level ---

        // search
        var aComponents = $("[mls_contains='" + mls_container + "']");
        
        aComponents.each( function(index, $component)
        {
            // read
            var mls_component = $($component).attr("mls_component");
            var mls_sortorder = $($component).attr("mls_sortorder"); // #todo

            // verify
            if (mls_component !== undefined)
            {
                $.ajax({
                    type: 'GET',
                    url: '/Mimoto.Aimless/data/' + data.entityType + '/' + data.entityId + '/' + mls_component,
                    data: null,
                    dataType: 'html',
                    success: function (data) {
                        $($component).append(data);
                    }
                });
            }

        });


        // seection level
        // search
        var aComponents = $("[mls_selection='" + mls_container + "']");

        aComponents.each( function(index, $component)
        {
            // read
            var mls_component = $($component).attr("mls_component");
            var mls_sortorder = $($component).attr("mls_sortorder"); // #todo

            // verify
            if (mls_component !== undefined)
            {
                $.ajax({
                    type: 'GET',
                    url: '/Mimoto.Aimless/data/' + data.entityType + '/' + data.entityId + '/' + mls_component,
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
    });
    
    
    
    channel.bind('popup.open', function(data)
    {
        
        Maido.popup.open(data.url);
        // voorzien van URL voor inhoud
        // use delegate -> MimotoLivescreen.onPopup = delegate(data)
        // kan form bevatten
        
        //call option, zoals popup, met URL van popup-view of form
    });
    
    channel.bind('page.change', function(data)
    {
        Maido.page.change(data.url) ;//, data.config); -> load in iframe
    });
    
    channel.bind('component.load', function(data)
    {
        // o.a. remote dashboard control
    });



    Mimoto.Aimless.realtime.broadcastedValues = [];
    Mimoto.Aimless.realtime.changes = [];
    Mimoto.Aimless.realtime.registerChange = function(sFormName, sInputFieldId, value)
    {
        if (!Mimoto.Aimless.realtime.changes[sInputFieldId])
        {
            Mimoto.Aimless.realtime.changes[sInputFieldId] = {
                sFormName: sFormName,
                newValue: value
            }
        }
        else
        {
            Mimoto.Aimless.realtime.changes[sInputFieldId].newValue = value;
        }
    }



    Mimoto.Aimless.realtime.dmp = new diff_match_patch();


    setInterval(function()
    {
        for (var sInputFieldId in Mimoto.Aimless.realtime.changes)
        {
            var field = Mimoto.Aimless.realtime.changes[sInputFieldId];


            // #todo - presence - lastvalue of field store in user object


            // calculate new value
            var originalText = Mimoto.Aimless.realtime.broadcastedValues[sInputFieldId].value;
            var modifiedText = Mimoto.Aimless.realtime.changes[sInputFieldId].newValue;

            //var ms_start = (new Date).getTime();
            var diff = Mimoto.Aimless.realtime.dmp.diff_main(originalText, modifiedText, true);
            //var ms_end = (new Date).getTime();

            if (diff.length > 2) {
                Mimoto.Aimless.realtime.dmp.diff_cleanupSemantic(diff);
            }

            var patch_list = Mimoto.Aimless.realtime.dmp.patch_make(originalText, modifiedText, diff);
            patch_text = Mimoto.Aimless.realtime.dmp.patch_toText(patch_list);


            // setup
            var data = {
                fieldId: sInputFieldId,
                //value: modifiedText,
                diff: patch_text
            };

            // broadcast update
            Mimoto.Aimless.privateChannel.trigger('client-Aimless:formfield_update_' + field.sFormName, data);

            // store
            Mimoto.Aimless.realtime.broadcastedValues[sInputFieldId].value = field.newValue;
            delete Mimoto.Aimless.realtime.changes[sInputFieldId];

        }

    }, 100); // send every 100 milliseconds if position has changed


}


Mimoto.Aimless.utils = {};
Mimoto.Aimless.utils.loadComponent = function($component, sEntityTypeName, nId, sTemplate) {
    $.ajax({
        type: 'GET',
        url: '/Mimoto.Aimless/data/' + sEntityTypeName + '/' + nId + '/' + sTemplate,
        data: null,
        dataType: 'html',
        success: function (data) {
            $($component).append(data);
        }
    });
};



Mimoto.Aimless.updateComponent = function(ajax, dom)
{
    
};

Mimoto.Aimless.connect();

