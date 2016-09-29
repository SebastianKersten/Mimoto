Maido = {};

Maido._aProjects = Array();


Maido.data = {};


Maido.data.newSubproject = function(nProjectID)
{
    Maido.popup.open('/project/' + nProjectID + '/subproject/new');   
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

//Maido.___projects.toggleFilter(); -> auto reload pagina

// reload after filter-set
