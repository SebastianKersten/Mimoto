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

    EH.init({
        "errorElement": "p",
        "errorElementClasses": ["MimotoCMS_forms_FormComponent-element-error"],
        "iconSelectorClass": "js-error-icon",
        "validatedClass": "MimotoCMS_forms_FormComponent--is-validated",
        "validatedIcon": "#ico-checkmark",
        "validatedIconClass": "MimotoCMS_forms_FormComponent-title-icon--checkmark",
        "errorParentClass": "js-error-parent",
        "errorClass": "MimotoCMS_forms_FormComponent--has-error",
        "errorIcon": "#ico-warning",
        "errorIconClass": "MimotoCMS_forms_FormComponent-title-icon--warning"
    });

    if (navigation && header) { new HeaderView(header); }

    for (var i = 0; i < forms.length; i++) {
        new FormView(forms[i]);
    }

    // Mimoto.Aimless.realtime.onCreated('_MimotoAimless__devtools__notification', function(sType, nId)
    // {
    //     console.log('Custom event listener ' + sType + ', ' + nId);
    // });

}, false);
