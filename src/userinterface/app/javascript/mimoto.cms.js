'use strict';

var HeaderView = require('./views/Header');
var FormView = require('./views/form-components/Form');




if (typeof Mimoto == "undefined") Mimoto = {};
if (typeof Mimoto.CMS == "undefined") Mimoto.CMS = {};
if (typeof Mimoto.modules == "undefined") Mimoto.modules = {};

//Mimoto = require('./mimoto.cms/Mimoto');

Mimoto.CMS = require('./mimoto.cms/Mimoto.CMS');
Mimoto.modules.Tabmenu = require('./mimoto.cms/modules/Tabmenu');
Mimoto.modules.Popup = require('./mimoto.cms/modules/Popup');
Mimoto.modules.Page = require('./mimoto.cms/modules/Page');
Mimoto.modules.Form = require('./mimoto.cms/modules/Form');


document.addEventListener('DOMContentLoaded', function () {

    // init
    Mimoto.CMS = new Mimoto.CMS();
    Mimoto.page = new Mimoto.modules.Page();
    Mimoto.popup = new Mimoto.modules.Popup();
    Mimoto.form = new Mimoto.modules.Form();



    var navigation = document.querySelector('.js-navigation');
    var header = document.querySelector('.js-header');
    var forms = document.querySelectorAll('.js-form');

    if (navigation && header) { new HeaderView(header); }

    for (var i = 0; i < forms.length; i++) {
        new FormView(forms[i]);
    }

    EH.init({
        "element": "p",
        "classes": ["form-component-element-error"],
        "errorClass": "form-component--has-error",
        "validatedClass": "form-component--is-validated",
        "iconSelectorClass": "js-error-icon",
        "iconErrorClass": "form-component-title-icon--warning",
        "iconValidatedClass": "form-component-title-icon--checkmark"
    });

    Conditioner.init();

}, false);





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
    var popup = Mimoto.popup.open("/mimoto.cms/entity/new");

    //popup.on('success') = popup.close();
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

Mimoto.CMS.entityView = function(nEntityId)
{
    window.open('/mimoto.cms/entity/' + nEntityId + '/view', '_self');
}

Mimoto.CMS.entityEdit = function(nEntityId)
{
    Mimoto.popup.open('/mimoto.cms/entity/' + nEntityId + '/edit');
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
