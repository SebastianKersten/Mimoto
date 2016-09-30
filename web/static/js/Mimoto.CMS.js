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
    Maido.popup.open("/mimoto.cms/entity/new");
}

Mimoto.CMS.entityCreate = function(data)
{
    $.ajax({
        type: 'POST',
        url: "/mimoto.cms/entity/create",
        data: data,
        dataType: 'json'
    }).done(function(data) {
        Maido.popup.close();
    });
}

Mimoto.CMS.entityEdit = function(nEntityId)
{
    Maido.popup.open("/mimoto.cms/entity/" + nEntityId + "/edit");
}

Mimoto.CMS.entityUpdate = function(nEntityId, data)
{
    $.ajax({
        type: 'POST',
        url: "/mimoto.cms/entity/" + nEntityId + "/update",
        data: data,
        dataType: 'json'
    }).done(function(data) {
        Maido.popup.close();
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
    Maido.popup.open("/mimoto.cms/entity/" + nEntityId + "/property/new");
}

Mimoto.CMS.entityPropertyCreate = function(nEntityId, data)
{
    $.ajax({
        type: 'POST',
        url: "/mimoto.cms/entity/" + nEntityId + "/property/create",
        data: data,
        dataType: 'json'
    }).done(function(data) {
        Maido.popup.close();
    });
}

Mimoto.CMS.entityPropertyEdit = function(nEntityPropertyId)
{
    Maido.popup.open("/mimoto.cms/entityproperty/" + nEntityPropertyId + "/edit");
    // TODO - route aanpassen
}



/**
 * Mimoto.CMS - Form handling
 *
 * @author Sebastian Kersten (@supertaboo)
 */


Mimoto.form = {};

Mimoto.form.openForm = function(sFormName, sAction, sMethod)
{
    // init
    if (!Mimoto.form._aForms) Mimoto.form._aForms = [];

    // setup
    var form = {
        'sName': sFormName,
        'sAction': sAction,
        'sMethod': sMethod,
        'aFields': []
    };

    // register
    Mimoto.form._aForms.push(form);

    console.log(Mimoto.form._aForms);
};

Mimoto.form.closeForm = function(sFormName)
{

    console.error('[mls_form_submit="' + sFormName + '"]');
    // search
    var aSubmitButtons = $('[mls_form_submit="' + sFormName + '"]');


    //console.log(aSubmitButtons);

    //console.log(aSubmitButtons.length);


    // activate
    aSubmitButtons.each(function(nIndex, $component) {

        // read
        var currentForm = Mimoto.form._aForms[Mimoto.form._aForms.length - 1]; // #todo - validate if no form set

        // register
        currentForm.aSubmitButtons.push($component);

        // setup
        $($component).click(function() { Mimoto.form.submit(sFormName); alert('Submit was connected!'); } );
    });
}

Mimoto.form.submit = function(sFormName)
{
    alert('Submit for "' + sFormName + '" was clicked!');
}

Mimoto.form.registerInputField = function(sInputFieldId, validation) // #todo - settings
{
    // setup
    var field = {
        'sName': sInputFieldId,
        'sType': 'input', // #todo - const
        'settings': validation
    };


    // read
    var currentForm = Mimoto.form._aForms[Mimoto.form._aForms.length - 1]; // #todo - validate if no form set

    currentForm.aFields.push(field);


    console.log(Mimoto.form._aForms);


    var scope = {};
    scope.validation = validation;
    scope.sInputFieldId = sInputFieldId;

    if (typeof validation == "undefined") return;

    $('#form_data_' + sInputFieldId).on('input', function(e)
    {
        // init
        var bValidated = true;
        var sErrorMessage = '';


        var value = $(this).val();


        if (validation.regex)
        {
            var regex = new RegExp(validation.regex, 'g');

            if (!regex.test(value))
            {
                var bValidated = false;
                sErrorMessage += 'Value formatted incorrectly. Allowed format is: ' + validation.regex + '. ';
            }
        }

        if (validation.maxchars)
        {
            if (value.length > validation.maxchars)
            {
                var bValidated = false;
                sErrorMessage += 'Too many characters (' + value.length + ' of ' + validation.maxchars + ')';
            }
        }

        if (!bValidated)
        {
            $('#form_errormessage_' + scope.sInputFieldId).addClass('error');
            $('#form_data_' + scope.sInputFieldId).addClass('error');
            $('#form_errormessage_' + scope.sInputFieldId).text(sErrorMessage);
            console.warn(sErrorMessage);
        }
        else
        {
            $('#form_errormessage_' + scope.sInputFieldId).removeClass('error');
            $('#form_data_' + scope.sInputFieldId).removeClass('error');
            $('#form_errormessage_' + scope.sInputFieldId).text('');
            console.log('Input = ok!');
        }
    });
};