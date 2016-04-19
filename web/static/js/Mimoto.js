/**
 * Mimoto.CMS - Form handling
 * 
 * @author Sebastian Kersten (@supertaboo)
 */


// init
if (typeof Mimoto == "undefined") Mimoto = {};

Mimoto.form = {};

Mimoto.form.registerInputField = function(sInputFieldId, validation)
{
    
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
}