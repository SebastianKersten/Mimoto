/**
 * Mimoto Livescreen
 * 
 * @author Sebastian Kersten
 */

MimotoLivescreen = {};


// #todo - scrollpos correctie!


//components,        
//subcomponents
//values / fields

MimotoLivescreen.connect = function()
{
    
    // Enable pusher logging - don't include this in production
    Pusher.log = function(message) {
        if (window.console && window.console.log) { window.console.log(message); }
    };

    var pusher = new Pusher('55152f70c4cec27de21d', {
        cluster: 'eu',
        encrypted: true
    });


    var channel = pusher.subscribe('livescreen');

    channel.bind('data.update', function(data) // update, create, remove (, read?)
    {
        // compose
        var sEntityIdentifier = data.entityType + '.' + data.entityId;
        
        
        // --- value level ---
        
        for (var sField in data.values)
        {
            // compose
            var sFieldIdentifier = sEntityIdentifier + '.' + sField;

            // change
            $("[mls_value='" + sFieldIdentifier + "']").text(data.values[sField]);
        }
        
        
        
        // --- component level ---
        
        // search
        var aComponents = $("[mls_id='" + sEntityIdentifier + "']");
        
        aComponents.each( function(index, $component)
        {
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
                    url: '/livescreen/' + data.entityType + '/' + data.entityId + '/' + mls_template,
                    data: null,
                    dataType: 'html',
                    success: function (data) {
                        $($component).replaceWith(data);
                    }
                });
                
                // return;
            }
            
        });
    });
    
    
    channel.bind('data.create', function(data)
    {
        // setup
        var mls_container = data.entityType;
        

        // --- component level ---

        // search
        var aComponents = $("[mls_container='" + mls_container + "']");
        
        aComponents.each( function(index, $component)
        {
            // read
            var mls_childtemplate = $($component).attr("mls_childtemplate");
            var mls_sortorder = $($component).attr("mls_sortorder"); // #todo

            // verify
            if (mls_childtemplate !== undefined)
            {
                $.ajax({
                    type: 'GET',
                    url: '/livescreen/' + data.entityType + '/' + data.entityId + '/' + mls_childtemplate,
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

}

MimotoLivescreen.updateComponent = function(ajax, dom)
{
    
}

MimotoLivescreen.connect();

