/**
 * Mimoto.CMS
 * 
 * @author Sebastian Kersten (@supertaboo)
 */


// init
if (typeof Mimoto == "undefined") Mimoto = {};
if (typeof Mimoto.CMS == "undefined") Mimoto.CMS = {};

Mimoto.CMS.entityNew = function()
{
    Mimoto.popup.open("/mimoto.cms/entity/new");
}

Mimoto.CMS.entityCreate = function(data)
{
    $.ajax({
        type: 'POST',
        url: "/mimoto.cms/entity/create",
        data: data,
        dataType: 'json'
    }).done(function(data) {
        Mimoto.popup.close();
    });
}

Mimoto.CMS.entityEdit = function(nEntityId)
{
    console.log('Start editing ...');

    Mimoto.popup.open("/mimoto.cms/entity/" + nEntityId + "/edit");
}

Mimoto.CMS.entityUpdate = function(nEntityId, data)
{
    $.ajax({
        type: 'POST',
        url: "/mimoto.cms/entity/" + nEntityId + "/update",
        data: data,
        dataType: 'json'
    }).done(function(data) {
        Mimoto.popup.close();
    });
}

Mimoto.CMS.entityDelete = function(nEntityId, sEntityName)
{
    var response = confirm("Are you sure you want to delete the entity '" + sEntityName + "'?\n\nALL DATA WILL BE LOST!!\n\n(Really! I'm not kidding!)");
    if (response == true) {
        $.ajax({
            type: 'GET',
            url: "/mimoto.cms/entity/" + nEntityId + "/delete",
            //data: data,
            dataType: 'json'
        }).done(function(data) {
            window.open('/mimoto.cms/entities', '_self');
        });
    }
}



Mimoto.CMS.entityPropertyNew = function(nEntityId)
{
    Mimoto.popup.open("/mimoto.cms/entity/" + nEntityId + "/property/new");
}

Mimoto.CMS.entityPropertyCreate = function(nEntityId, data)
{
    $.ajax({
        type: 'POST',
        url: "/mimoto.cms/entity/" + nEntityId + "/property/create",
        data: data,
        dataType: 'json'
    }).done(function(data) {
        Mimoto.popup.close();
    });
}

Mimoto.CMS.entityPropertyEdit = function(nEntityPropertyId)
{
    Mimoto.popup.open("/mimoto.cms/entityproperty/" + nEntityPropertyId + "/edit");
}
