Maido = {};

Maido.addProject = function()
{
    Maido.popup.open('/project/new');   
}

Maido.saveProject = function(sName, sDescription, nClientID, nAgencyID, nProjectManagerID)
{
    // show loader
    
    var data = {
        name: sName,
        description: sDescription,
        client_id: nClientID,
        agency_id: nAgencyID,
        projectmanager_id: nProjectManagerID
    };
    
    $.ajax({
        type: 'POST',
        url: "/project/save",
        data: data,
        dataType: 'json',
        success: function (data) {
            document.getElementById('popup_content').innerHTML = data.name;
            window.open('/', '_self');//location.reload();
        },
    });  
}


Maido.settings = {};

Maido.settings.newProjectManager = function()
{
    Maido.popup.open('/settings/projectmanager/new');  
}

Maido.settings.changeProjectManager = function(nID)
{
    Maido.popup.open('/settings/projectmanager/change');  
}

Maido.settings.saveProjectManager = function(sName)
{
    
    var data = {
        name: sName
    };
    
    $.ajax({
        type: 'POST',
        url: "/settings/projectmanager/save",
        data: data,
        dataType: 'json',
        success: function (data) {
            document.getElementById('popup_content').innerHTML = data.name;
            location.reload();
        }
    });    
}

Maido.settings.newClient = function()
{
    Maido.popup.open('/settings/client/new');  
}

Maido.settings.saveClient = function(sName)
{
    
    var data = {
        name: sName
    };
    
    $.ajax({
        type: 'POST',
        url: "/settings/client/save",
        data: data,
        dataType: 'json',
        success: function (data) {
            document.getElementById('popup_content').innerHTML = data.name;
            location.reload();
        },
    });    
}


Maido.settings.newAgency = function()
{
    Maido.popup.open('/settings/agency/new');  
}

Maido.settings.saveAgency = function(sName)
{
    
    var data = {
        name: sName
    };
    
    $.ajax({
        type: 'POST',
        url: "/settings/agency/save",
        data: data,
        dataType: 'json',
        success: function (data) {
            document.getElementById('popup_content').innerHTML = data.name;
            location.reload();
        }
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
    r.onreadystatechange = function () {
      if (r.readyState != 4 || r.status != 200) return;

      popup_content.innerHTML = r.responseText;
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
