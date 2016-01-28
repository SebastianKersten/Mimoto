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
            window.open('/', '_self');//location.reload();
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
            document.getElementById('popup_content').innerHTML = data.name;
            location.reload();
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
            document.getElementById('popup_content').innerHTML = data.name;
            location.reload();
        },
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
