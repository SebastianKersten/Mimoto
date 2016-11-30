//'use strict'; #note - do not uncomment

require('jquery-ui');

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

// init
Mimoto.CMS = new Mimoto.CMS();
Mimoto.page = new Mimoto.modules.Page();
Mimoto.popup = new Mimoto.modules.Popup();
Mimoto.form = new Mimoto.modules.Form();

document.addEventListener('DOMContentLoaded', function () {

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

    // Mimoto.Aimless.realtime.onCreated('_MimotoAimless__devtools__notification', function(sType, nId)
    // {
    //     console.log('Custom event listener ' + sType + ', ' + nId);
    // });

}, false);
