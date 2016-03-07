Maido = {};

Maido._aProjects = Array();


Maido.newProject = function()
{
    Maido.popup.open('/project/new');   
}

Maido.changeProject = function(nID)
{   
    Maido.popup.open('/project/change/' + nID);
}

Maido.saveProject = function(data)
{
    // show loader
    $.ajax({
        type: 'POST',
        url: "/project/save",
        data: data,
        dataType: 'json',
        success: function (data) {
            document.getElementById('popup_content').innerHTML = data.name;
            Maido.popup.close();
            window.open('/', '_self');
        }
    });
}


Maido.toggleProjectState = function(nID)
{
    
    // register
    var project_details = document.getElementById('project_details_' + nID);
    
    
    if (Maido._aProjects[nID] === true)
    {    
        // show
        project_details.classList.remove('show');
    
        // update
        Maido._aProjects[nID] = false;
    }
    else
    {
        // show
        project_details.classList.add('show');
    
        // update
        Maido._aProjects[nID] = true;
    }
    
    
}

Maido.newSubproject = function(nProjectID)
{
    Maido.popup.open('/project/' + nProjectID + '/subproject/new');   
}

Maido.changeSubproject = function(nSubprojectId)
{   
    Maido.popup.open('/subproject/change/' + nSubprojectId);
}

Maido.saveSubproject = function(data)
{
    // show loader
    $.ajax({
        type: 'POST',
        url: "/subproject/save",
        data: data,
        dataType: 'json',
        success: function (data) {
            Maido.popup.close();
        }
    });
}



Maido.settings = {};

Maido.settings.newProjectManager = function()
{
    Maido.popup.open('/settings/projectmanager/new');  
}

Maido.settings.changeProjectManager = function(nID)
{
    Maido.popup.open('/settings/projectmanager/change/' + nID);  
}

Maido.settings.saveProjectManager = function(data)
{
    $.ajax({
        type: 'POST',
        url: "/settings/projectmanager/save",
        data: data,
        dataType: 'json',
        success: function (data) {
            Maido.popup.close();
        }
    });    
}

Maido.settings.newClient = function()
{
    Maido.popup.open('/settings/client/new');  
}

Maido.settings.changeClient = function(nID)
{
    Maido.popup.open('/settings/client/change/' + nID);  
}

Maido.settings.saveClient = function(data)
{    
    $.ajax({
        type: 'POST',
        url: "/settings/client/save",
        data: data,
        dataType: 'json',
        success: function (data) {
            Maido.popup.close();
        }
    });    
}


Maido.settings.newAgency = function()
{
    Maido.popup.open('/settings/agency/new');  
}

Maido.settings.changeAgency = function(nID)
{
    Maido.popup.open('/settings/agency/change/' + nID);  
}

Maido.settings.saveAgency = function(data)
{
    $.ajax({
        type: 'POST',
        url: "/settings/agency/save",
        data: data,
        dataType: 'json',
        success: function (data) {
            Maido.popup.close();
        }
    });    
}


Maido.settings.newSubprojectState = function()
{
    Maido.popup.open('/settings/subprojectstate/new');  
}

Maido.settings.changeSubprojectState = function(nID)
{
    Maido.popup.open('/settings/subprojectstate/change/' + nID);  
}

Maido.settings.saveSubprojectState = function(data)
{    
    $.ajax({
        type: 'POST',
        url: "/settings/subprojectstate/save",
        data: data,
        dataType: 'json',
        success: function (data) {
            document.getElementById('popup_content').innerHTML = data.name;
            location.reload();
        },
    });    
}




//Maido.addProject();



Maido.popup = {}

Maido.popup.open = function(sURL)
{
    // register
    var layer_overlay = document.getElementById('layer_overlay');
    var layer_popup = document.getElementById('layer_popup');
    var popup_content = document.getElementById('popup_content');
    
    // show
    layer_overlay.classList.remove('hidden');
    layer_popup.classList.remove('hidden');
    
    // load
    var r = new XMLHttpRequest();
    r.open("GET", sURL, true);
    r.onreadystatechange = function ()
    {
        if (r.readyState != 4 || r.status != 200) return;
        
        popup_content.innerHTML = r.responseText;
        
        // focus primary input
        var primaryInput = document.getElementById('form_field_name');
        if (primaryInput)
        {
            primaryInput.focus();
            var val = primaryInput.value;
            primaryInput.value = '';
            primaryInput.value = val;
        }
    };
    r.send("banana=yellow");
}

Maido.popup.close = function()
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




Maido.projects = {};

//Maido.projects.toggleFilter(); -> auto reload pagina

// reload after filter-set











// Notifications

Maido.notifications = {};
        
Maido.notifications.connectPage = function(sPage)
{
    
    // Enable pusher logging - don't include this in production
    Pusher.log = function(message) {
        if (window.console && window.console.log) { window.console.log(message); }
    };

    var pusher = new Pusher('55152f70c4cec27de21d', {
        cluster: 'eu',
        encrypted: true
    });
    
    
    switch(sPage)
    {
        case 'clients': // #todo - general channel, niet per Model
            
            var channel = pusher.subscribe('clients');
            
            channel.bind('client.created', function(data) {
                if (data.type == 'livescreen') { Maido.livescreen.create(data.ajax, data.dom); }
            });
            
            channel.bind('client.updated', function(data) {
                if (data.type == 'livescreen') { Maido.livescreen.update(data.ajax, data.dom); }
            });
            
            break;
            
        case 'agencies':
            
            var channel = pusher.subscribe('agencies');
            
            channel.bind('agency.created', function(data) {
                if (data.type == 'livescreen') { Maido.livescreen.create(data.ajax, data.dom); }
            });
            
            channel.bind('agency.updated', function(data) {
                if (data.type == 'livescreen') { Maido.livescreen.update(data.ajax, data.dom); }
            });
            
            break;
            
        case 'projectmanagers':
            
            var channel = pusher.subscribe('projectmanagers');
            
            channel.bind('projectmanager.created', function(data) {
                if (data.type == 'livescreen') { Maido.livescreen.create(data.ajax, data.dom); }
            });
            
            channel.bind('projectmanager.updated', function(data) {
                if (data.type == 'livescreen') { Maido.livescreen.update(data.ajax, data.dom); }
            });
            
            break;
            
        case 'subprojectstates':
            
            var channel = pusher.subscribe('subprojectstates');
            
            channel.bind('subprojectstate.created', function(data) {
                if (data.type == 'livescreen') { Maido.livescreen.create(data.ajax, data.dom); }
            });
            
            channel.bind('subprojectstate.updated', function(data) {
                if (data.type == 'livescreen') { Maido.livescreen.update(data.ajax, data.dom); }
            });
            
            break;
    }
}


Maido.livescreen = {};

Maido.livescreen.connect = function()
{

}


Maido.livescreen.create = function(ajax, dom)
{
    $.ajax({
        type: ajax.type,
        url: ajax.url,
        data: ajax.data,
        dataType: ajax.dataType,
        success: function (data) {
            $(dom.containerId).append(data);
        }
    });
}

Maido.livescreen.update = function(ajax, dom)
{
    $.ajax({
        type: ajax.type,
        url: ajax.url,
        data: ajax.data,
        dataType: ajax.dataType,
        success: function (data) {
            $(dom.objectId).replaceWith(data);
        }
    });
}