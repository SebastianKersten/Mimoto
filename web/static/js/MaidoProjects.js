Maido = {};

Maido._aProjects = Array();


Maido.data = {};

Maido.data.newEntity = function(sEntityType)
{
    Maido.popup.open('/' + sEntityType + '/new');
}

Maido.data.newSubproject = function(nProjectID)
{
    Maido.popup.open('/project/' + nProjectID + '/subproject/new');   
}

Maido.data.changeEntity = function(sEntityType, nId)
{
    Maido.popup.open('/' + sEntityType + '/change/' + nId);
}

Maido.data.saveEntity = function(sEntityType, data)
{
    $.ajax({
        type: 'POST',
        url: "/" + sEntityType + "/save",
        data: data,
        dataType: 'json',
        success: function(data) {
            Maido.popup.close();
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


Maido.page = {};

Maido.page.change = function(sURL)
{
   window.location.href = sURL;
}




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
    r.send();
    //r.send("banana=yellow");
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
