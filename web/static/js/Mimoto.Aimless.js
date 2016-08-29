/**
 * Aimless - Mimoto's LiveScreen protocol
 * 
 * @author Sebastian Kersten (@supertaboo)
 */

if (typeof Mimoto == "undefined") Mimoto = {};
Mimoto.Aimless = {};


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

    var pusher = new Pusher('55152f70c4cec27de21d', {
        cluster: 'eu',
        encrypted: true
    });


    var channel = pusher.subscribe('Aimless');

    channel.bind('data.changed', function(data) // update, create, remove (, read?)
    {
        // compose
        var sEntityIdentifier = data.entityType + '.' + data.entityId;
        
        
        // --- value level ---
        
        
        console.clear();
        
        
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
                var mls_template = $($component).attr("mls_template");
                var mls_filter = $($component).attr("mls_filter");
                
                if (mls_filter) { mls_filter = $.parseJSON(mls_filter); }

                console.log('mls_filer = ' + mls_filter);

                if (change)
                {

                }

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

                        if (bFilterApproved)
                        {

                            console.warn(item);

                            $.ajax({
                                type: 'GET',
                                url: '/Mimoto.Aimless/' + item.connection.childEntityTypeName + '/' + item.connection.childId + '/' + mls_template,
                                data: null,
                                dataType: 'html',
                                success: function (data) {
                                    $($component).append(data);
                                }
                            });
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
                        $item = $("[mls_id='" + item.connection.childEntityTypeName + "." + item.connection.childId + "']", $component);

                        // delete
                        $item.remove();
                    }
                }


            });
        }
        
        
        // --- component level ---
        
        // search
        var aComponents = $("[mls_id='" + sEntityIdentifier + "']");
        // get all elements with //$('[mls_id]') en check op sEntityIdentifier
        
        aComponents.each( function(index, $component)
        {
            
            // read
            //var mls_config = $($component).attr("mls_id");
            
            // init
            var config = [];
            
            // read
            var mls_config = $($component).attr("mls_config");
            var mls_template = $($component).attr("mls_template");
            
            // verify
            if (mls_config !== undefined)
            {
                var aConfigParams = mls_config.split(';')
                
                for (var i = 0; i < aConfigParams.length; i++)
                {
                    
                    // register
                    var configParam = aConfigParams[i];
                    var aConfigParamElements = configParam.split(':')
                    
                    // register
                    config[aConfigParamElements[0].trim().toLowerCase()] = aConfigParamElements[1].trim().toLowerCase();
                }
            }
            
            // reload component
            if (config['onupdate'] == 'reload') // mls_config="onUpdate:reload"
            {
                $.ajax({
                    type: 'GET',
                    url: '/Mimoto.LiveScreen/' + data.entityType + '/' + data.entityId + '/' + mls_template,
                    data: null,
                    dataType: 'html',
                    success: function (data) {
                        $($component).replaceWith(data);
                    }
                });
                
                // return;
            }
            
        });
        
        
        
        
        // --- container level ---

        
        //console.log('Console.update - filtered');
        
        // 1. mls_contains="project.3.subprojects" wordt niet meegestuurd bij wie het object hoort
        // 2. partOf
        // 3. zoek naar connectietabellen
        
        
        
        // setup
//        var mls_container = data.entityType;
//        
//        
//        // search
//        var aComponents = $("[mls_contains='" + mls_container + "']");
//        
//        aComponents.each( function(index, $component)
//        {
//            
//            console.log('In mls_contains for updating information');
//            
//            // read
//            var mls_contains = $($component).attr("mls_contains");
//            
//            console.log(mls_contains);
//            
//            var mls_filter = $($component).attr("mls_filter");
//            var mls_template = $($component).attr("mls_template");
//            //var mls_sortorder = $($component).attr("mls_sortorder"); // #todo
//
//            // verify
//            if (mls_template !== undefined)
//            {
//                $.ajax({
//                    type: 'GET',
//                    url: '/Mimoto.Aimless/' + data.entityType + '/' + data.entityId + '/' + mls_template,
//                    data: null,
//                    dataType: 'html',
//                    success: function (data) {
//                        $($component).append(data);
//                    }
//                });
//            }
//
//        });
        
    });
    
    
    channel.bind('data.create', function(data)
    {
        // setup
        var mls_container = data.entityType;
        
        
        console.clear();
        
        console.log('Aimless - data.create');
        console.log(data);
        

        // --- component level ---

        // search
        var aComponents = $("[mls_contains='" + mls_container + "']");
        
        aComponents.each( function(index, $component)
        {
            // read
            var mls_template = $($component).attr("mls_template");
            var mls_sortorder = $($component).attr("mls_sortorder"); // #todo

            // verify
            if (mls_template !== undefined)
            {
                $.ajax({
                    type: 'GET',
                    url: '/Mimoto.Aimless/' + data.entityType + '/' + data.entityId + '/' + mls_template,
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
            var mls_template = $($component).attr("mls_template");
            var mls_sortorder = $($component).attr("mls_sortorder"); // #todo

            // verify
            if (mls_template !== undefined)
            {
                $.ajax({
                    type: 'GET',
                    url: '/Mimoto.Aimless/' + data.entityType + '/' + data.entityId + '/' + mls_template,
                    data: null,
                    dataType: 'html',
                    success: function (data) {
                        $($component).append(data);
                    }
                });
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

}

Mimoto.Aimless.updateComponent = function(ajax, dom)
{
    
}

Mimoto.Aimless.connect();

