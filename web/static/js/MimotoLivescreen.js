/**
 * Mimoto Livescreen
 * 
 * @author Sebastian Kersten
 */

MimotoLivescreen = {};



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

    channel.bind('updateData', function(data) // update, create, remove (, read?)
    {
        
        
        
        //data.type = 'mls';
        
        
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
        
        aComponents.each( function( index, $component)
        {
            // init
            var config = [];
            
            // read
            var mls_config = $($component).attr("mls_config" );
            var mls_template = $($component).attr("mls_template" );
            
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

            
            if (config['onupdate'] == 'reload') // mls_config="onUpdate:reload"
            {
                
                $.ajax({
                    type: 'GET',
                    url: '/livescreen/' + data.entityType + '/' + data.entityId + '/' + mls_template,
                    data: null,
                    dataType: 'html',
                    success: function (data) {
                        $($component).replaceWith(data);
                        // find id with correct template
                    }
                });
                
                // return;
            }
            
            
        });
        
        
        
        
        
        
        
        
        //var config = aComponents.attr('lsconfig');
            
        //console.log(config);
            
        
//        for (var i = 0; i < aComponents.length; i++)   
//        {
//            $component = aComponents;
//        
//            //aComponents.each(function(nIndex, $component) {
//            
//            console.log($component);
//            console.log('nIndex = ' + nIndex + "\n");
//            
//            // get config
//            var config = $component.attr('lsconfig');
//            
//            console.log(config);
//        }
        
        
        // lsid="client.2"
        // lstpl="ClientListItem"
        // lsvalue="";
        // lsconfig=""
    });
    
    channel.bind('showPopup', function(data)
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


//Maido.livescreen.create = function(ajax, dom)
//{
//    $.ajax({
//        type: ajax.type,
//        url: ajax.url,
//        data: ajax.data,
//        dataType: ajax.dataType,
//        success: function (data) {
//            $(dom.containerId).append(data);
//        }
//    });
//}
//


//case 'clients': // #todo - general channel, niet per Model
//            
//            var channel = pusher.subscribe('clients');
//            
//            channel.bind('client.created', function(data) {
//                if (data.type == 'livescreen') { Maido.livescreen.create(data.ajax, data.dom); }
//            });
//            
//            channel.bind('client.updated', function(data) {
//                if (data.type == 'livescreen') { Maido.livescreen.update(data.ajax, data.dom); }
//            });
//            
//            break;

