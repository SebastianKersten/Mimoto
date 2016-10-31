/**
 * Aimless - Mimoto's LiveScreen protocol
 * 
 * @author Sebastian Kersten (@supertaboo)
 */

if (typeof Mimoto == "undefined") Mimoto = {};
Mimoto.Aimless = {};
Mimoto.Aimless.realtime = {}
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


/**
 * Mimoto.CMS - Form handling
 *
 * @author Sebastian Kersten (@supertaboo)
 */


Mimoto.form = {};

Mimoto.form.openForm = function(sFormName, sAction, sMethod, bRealtimeCollaborationMode)
{
    // init
    if (!Mimoto.form._aForms) Mimoto.form._aForms = [];

    // store
    Mimoto.form._sCurrentOpenForm = sFormName;

    // setup
    var form = {
        'sName': sFormName,
        'sAction': sAction,
        'sMethod': sMethod,
        'aFields': [],
        'bRealtimeCollaborationMode': bRealtimeCollaborationMode
    };

    // register
    Mimoto.form._aForms[sFormName] = form;
};

Mimoto.form.closeForm = function(sFormName)
{

    console.error('[mls_form_submit="' + sFormName + '"]');

    // search
    var aSubmitButtons = $('[mls_form_submit="' + sFormName + '"]');

    // activate
    aSubmitButtons.each(function(nIndex, $component) {

        // read
        var currentForm = Mimoto.form._aForms[Mimoto.form._sCurrentOpenForm]; // #todo - validate if no form set

        // prepare
        if (!currentForm.aSubmitButtons) currentForm.aSubmitButtons = [];

        // register
        currentForm.aSubmitButtons.push($component);

        // setup
        $($component).click(function() { Mimoto.form.submit(sFormName); /*alert('Submit was auto connected!');*/ } );
    });


    Mimoto.Aimless.privateChannel = Mimoto.Aimless.pusher.subscribe('private-' + 'AimlessForm_' + sFormName);

    Mimoto.Aimless.privateChannel.bind('client-Aimless:formfield_update_' + sFormName, function(data)
    {

        var $input = $("input[mls_form_field_input='" + data.fieldId + "']");


        // 1. check if supports realtime
        // 2. get this text
        // 3. get diff patch


        console.log(Mimoto.Aimless.pusher);

        var currentValue = $($input).val();
        var patches = Mimoto.Aimless.realtime.dmp.patch_fromText(data.diff);

        //var ms_start = (new Date).getTime();
        var results = Mimoto.Aimless.realtime.dmp.patch_apply(patches, currentValue);
        //var ms_end = (new Date).getTime();


        Mimoto.Aimless.realtime.broadcastedValues[data.fieldId].value = results[0];
        $($input).val(results[0]);
    });
}

Mimoto.form.submit = function(sFormName)
{
    // 1. validate
    if (!Mimoto.form._aForms) return;

    // 2. set default is no specific form requested
    if (!sFormName) { for (var s in Mimoto.form._aForms) { sFormName = s; break; } }

    // 3. validate
    if (!Mimoto.form._aForms[sFormName]) return;

    // 4. register
    var form = Mimoto.form._aForms[sFormName];
    var aFields = form.aFields;
    var nFieldCount = aFields.length;

    // 5. locate form in dom
    var $form = $('form[name="' + sFormName + '"]');

    // 6. read public key
    var sPublicKey = '';
    var aPublicKeys = $("input[name='Mimoto.PublicKey']", $form);
    aPublicKeys.each( function(index, $component) { sPublicKey = $($component).val(); });

    // 7. collect data
    var aValues = {};
    for (var i = 0; i < nFieldCount; i++)
    {
        // register
        var field = aFields[i];

        // 8. find field
        var aComponents = $("[mls_form_field_input='" + field.sName + "']", $form);

        // 9. collect value
        aComponents.each( function(index, $component)
        {
            // init
            var value = Mimoto.form.getValueFromInputField($component);

            // store
            if (value !== null) aValues[field.sName] = value;
        });
    }

    // 10. collect data
    var requestData = { publicKey: sPublicKey, values: aValues };



    console.log('Sending ' + form.sAction + ' ' + form.sMethod);
    console.log(aValues);
    console.error(requestData);
    console.log('------');


    // 11. send data
    $.ajax({
        type: form.sMethod,
        url: form.sAction,
        data: JSON.stringify(requestData),
        dataType: 'json',
        success: function(resultData, resultStatus, resultSomething)
        {
            console.log(resultData);
            console.log(resultStatus);
            console.log(resultSomething);

            if (resultData.newEntities)
            {

                for (var sEntityType in resultData.newEntities)
                {
                    var newEntity = resultData.newEntities[sEntityType];

                    // 1. locate form in dom
                    var $form = $('form[name="' + resultData.formName + '"]');


                    // update dom
                    var aFields = $('[mls_form_field^="' + newEntity.selector + '"]', $form);
                    aFields.each( function(index, $component)
                    {
                        var mls_form_field = $($component).attr("mls_form_field");
                        mls_form_field = newEntity.id + mls_form_field.substr(newEntity.selector.length);
                        $($component).attr("mls_form_field", mls_form_field);
                    });

                    // update dom
                    var aFields = $('[mls_form_field_input^="' + newEntity.selector + '"][name^="' + newEntity.selector + '"]', $form);
                    aFields.each( function(index, $component)
                    {
                        var sOld_mls_form_field_input = $($component).attr("mls_form_field_input");
                        var sNew_mls_form_field_input = newEntity.id + sOld_mls_form_field_input.substr(newEntity.selector.length);
                        $($component).attr("mls_form_field_input", sNew_mls_form_field_input);

                        Mimoto.form.alterRegisteredFieldId(resultData.formName, sOld_mls_form_field_input, sNew_mls_form_field_input);

                        var name = $($component).attr("name");
                        name = newEntity.id + name.substr(newEntity.selector.length);
                        $($component).attr("name", name);
                    });

                    // update dom
                    var aFields = $('[mls_form_field_error^="' + newEntity.selector + '"]', $form);
                    aFields.each( function(index, $component)
                    {
                        var mls_form_field_error = $($component).attr("mls_form_field_error");
                        mls_form_field_error = newEntity.id + mls_form_field_error.substr(newEntity.selector.length);
                        $($component).attr("mls_form_field_error", mls_form_field_error);
                    });
                }
            }

            if (resultData.newPublicKey)
            {
                // 6. read public key
                var sPublicKey = '';
                var aPublicKeys = $("input[name='Mimoto.PublicKey']", $form);
                aPublicKeys.each( function(index, $component)
                {
                    sPublicKey = $($component).val(resultData.newPublicKey);
                });
            }

            // 1. #todo get input field value in method
            // 2. collaborationMode

        }
    });


}

Mimoto.form.getValueFromInputField = function($component)
{
    // init
    var value = null;

    // validate
    if ($($component).is("input"))
    {
        switch($($component).attr('type'))
        {
            case 'radio':

                if ($($component).prop("checked") === true) {
                    value = $($component).val();
                }
                break;

            default:

                value = $($component).val();
        }
    };

    if ($($component).is("select"))
    {
        value = $($component).val();
    }

    // send
    return value;
}

Mimoto.form.setInputFieldValue = function($component, value)
{
    if ($($component).is("input"))
    {
        switch($($component).attr('type'))
        {
            case 'radio':

                // output
                $($component).each( function(nIndex, $component)
                {
                    $($component).prop('checked', $($component).val() == change.value);
                });
                break;

            default:

                // output
                $($component).val(change.value);
        }
    };
}

Mimoto.form.registerInputField = function(sInputFieldId, validation) // #todo - settings
{
    // read
    var currentForm = Mimoto.form._aForms[Mimoto.form._sCurrentOpenForm]; // #todo - validate if no form set

    // setup
    var field = {
        'sFormId': currentForm,
        'sName': sInputFieldId,
        'sType': 'input', // #todo - const
        'settings': validation,
        $input: $("input[mls_form_field_input='" + sInputFieldId + "']")
    };

    // store
    currentForm.aFields.push(field);

    // store
    Mimoto.Aimless.realtime.broadcastedValues[sInputFieldId] = {
        sFormName: currentForm.sFormName,
        value: $(field.$input).val()
    };

    // connect
    Mimoto.form.connectInputField(field);
};

Mimoto.form.unregisterInputField = function(sInputFieldId)
{

}

Mimoto.form.alterRegisteredFieldId = function(sFormName, sOldInputFieldId, sNewInputFieldId)
{
    var form = Mimoto.form._aForms[sFormName];

    var nFieldCount = form.aFields.length;
    for (var i = 0; i < nFieldCount; i++)
    {
        // register
        var field = form.aFields[i];

        if (field.sName == sOldInputFieldId)
        {
            field.$input.off('input');

            field.sName = sNewInputFieldId;
            field.$input = $("input[mls_form_field_input='" + sNewInputFieldId + "']");

            // store
            Mimoto.Aimless.realtime.broadcastedValues[sNewInputFieldId] = Mimoto.Aimless.realtime.broadcastedValues[sOldInputFieldId];
            delete Mimoto.Aimless.realtime.broadcastedValues[sOldInputFieldId];

            Mimoto.form.connectInputField(field);
        }
    }
}

Mimoto.form.connectInputField = function(field)
{
    field.$input.on('input', function(e)
    {
        var sFormName = field.sFormId;
        var value = $(this).val();

        Mimoto.Aimless.realtime.registerChange(sFormName, field.sName, value);

        // #todo change reference to sInputFieldId / addEventListener / removeEventListener


    });
}








Mimoto.CMS.notificationClose = function(sEntityType, nNotificationId)
{
    // 8. find field
    var aNotifications = $("[mls_id='" + sEntityType + '.' + nNotificationId + "']");

    // 9. collect value
    aNotifications.each( function(index, $component) {
        // init
        $($component).remove();
    });

    // 11. send data
    $.ajax({
        type: 'GET',
        url: '/mimoto.cms/notifications/' + nNotificationId + '/close',
        data: null,
        dataType: 'json',
        success: function(resultData, resultStatus, resultSomething)
        {
            console.log(resultData);
            console.log(resultStatus);
            console.log(resultSomething);
        }
    });
}






Mimoto.page = {};

Mimoto.page.change = function(sURL)
{
    window.location.href = sURL;
}




Mimoto.popup = {}

Mimoto.popup.open = function(sURL)
{
    // register
    var layer_overlay = document.getElementById('layer_overlay');
    var layer_popup = document.getElementById('layer_popup');
    var popup_content = document.getElementById('popup_content');

    // show
    layer_overlay.classList.remove('hidden');
    layer_popup.classList.remove('hidden');

    $.ajax({
        url: sURL,
        dataType: 'html',
        success: function(data, textStatus, jqXHR) {

            //jQuery(selecteur).html(jqXHR.responseText);
            var response = jQuery(jqXHR.responseText);
            //var responseScript = response.filter("script");
            //jQuery.each(responseScript, function(idx, val) { eval(val.text); } );

            //popup_content.innerHTML = reponse;
            $('#popup_content').html(data);

            /*// focus primary input
             var primaryInput = document.getElementById('form_field_name');
             if (primaryInput)
             {
             primaryInput.focus();
             var val = primaryInput.value;
             primaryInput.value = '';
             primaryInput.value = val;
             }*/
        }
    });
}

Mimoto.popup.close = function()
{
    // register
    var layer_overlay = document.getElementById('layer_overlay');
    var layer_popup = document.getElementById('layer_popup');
    var popup_content = document.getElementById('popup_content');

    // cleanup
    popup_content.innerHTML = '';

    // hide
    layer_overlay.classList.add('hidden');
    layer_popup.classList.add('hidden');
}
