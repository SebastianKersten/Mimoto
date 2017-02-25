/**
 * Mimoto.CMS
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';

module.exports = function()
{
    // start
    this.__construct();
};

module.exports.prototype = {


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function ()
    {

    },


    // ----------------------------------------------------------------------------
    // --- Public methods - entity ------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Create new entity
     */
    entityNew: function()
    {
        var popup = Mimoto.popup.open("/mimoto.cms/entity/new");

        //popup.on('success') = popup.close();
    },

    // entityCreate: function(data)
    // {
    //     $.ajax({
    //         type: 'POST',
    //         url: "/mimoto.cms/entity/create",
    //         data: data,
    //         dataType: 'json'
    //     }).done(function(data) {
    //         Mimoto.popup.close();
    //     });
    // },

    entityView: function(nEntityId)
    {
        window.open('/mimoto.cms/entity/' + nEntityId + '/view', '_self');
    },

    entityEdit: function(nEntityId)
    {
        Mimoto.popup.open('/mimoto.cms/entity/' + nEntityId + '/edit');
    },

    entityUpdate: function(nEntityId, data)
    {
        $.ajax({
            type: 'POST',
            url: "/mimoto.cms/entity/" + nEntityId + "/update",
            data: data,
            dataType: 'json'
        }).done(function(data) {
            Mimoto.popup.close();
        });
    },

    entityDelete: function(nEntityId, sEntityName)
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
    },

    entityPropertyNew: function(nEntityId)
    {
        Mimoto.popup.open("/mimoto.cms/entity/" + nEntityId + "/property/new");
    },

    entityPropertyCreate: function(nEntityId, data)
    {
        $.ajax({
            type: 'POST',
            url: "/mimoto.cms/entity/" + nEntityId + "/property/create",
            data: data,
            dataType: 'json'
        }).done(function(data) {
            Mimoto.popup.close();
        });
    },

    entityPropertyEdit: function(nEntityPropertyId)
    {
        Mimoto.popup.open("/mimoto.cms/entityproperty/" + nEntityPropertyId + "/edit");
    },
    
    entityPropertyDelete:  function(nEntityPropertyId)
    {
        // 11. send data
        Mimoto.Aimless.utils.callAPI({
            type: 'get',
            url: "/mimoto.cms/entityproperty/" + nEntityPropertyId + "/delete",
            success: function(resultData, resultStatus, resultSomething) {
                console.log(resultData);
            }
        });
    },
    
    
    entityPropertySettingEdit: function(nEntityPropertySettingId)
    {
        Mimoto.popup.open('/mimoto.cms/entitypropertysetting/' + nEntityPropertySettingId + '/edit');
    },



    notificationClose: function(sEntityType, nNotificationId)
    {
        // 8. find field
        var aNotifications = $("[data-aimless-id='" + sEntityType + '.' + nNotificationId + "']");

        // 9. collect value
        aNotifications.each( function(index, $component) {
            // init
            $($component).remove();
        });

        // 11. send data
        Mimoto.Aimless.utils.callAPI({
            type: 'GET',
            url: '/mimoto.cms/notifications/' + nNotificationId + '/close',
            data: null,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething)
            {
                console.log(resultData);
                console.log(resultStatus);
                console.log(resultSomething);
            }
        });
    },
    
    
    /**
     * Create new component
     */
    entityComponentNew: function(nEntityId)
    {
        var popup = Mimoto.popup.open("/mimoto.cms/entity/" + nEntityId + "/component/new");
        
        //popup.on('success') = popup.close();
    },
    
    componentEdit: function(nComponentId)
    {
        Mimoto.popup.open('/mimoto.cms/component/' + nComponentId + '/edit');
    },
    
    componentDelete: function(nComponentId)
    {
        Mimoto.Aimless.utils.callAPI({
            type: 'get',
            url: "/mimoto.cms/component/" + nComponentId + "/delete",
            success: function(resultData, resultStatus, resultSomething) {
                console.log(resultData);
            }
        });
    },
    
    
    /**
     * Selections
     */
    selectionNew: function()
    {
        var popup = Mimoto.popup.open("/mimoto.cms/selection/new");
    },
    
    selectionView: function(nSelectionId)
    {
        window.open('/mimoto.cms/selection/' + nSelectionId + '/view', '_self');
    },
    
    selectionEdit: function(nSelectionId)
    {
        Mimoto.popup.open('/mimoto.cms/selection/' + nSelectionId + '/edit');
    },
    
    selectionDelete: function(nSelectionId)
    {
        Mimoto.Aimless.utils.callAPI({
            type: 'get',
            url: '/mimoto.cms/selection/' + nSelectionId + '/delete',
            success: function(resultData, resultStatus, resultSomething) {
                console.log(resultData);
            }
        });
    },
    
    selectionRuleNew: function(nSelectionId)
    {
        var popup = Mimoto.popup.open('/mimoto.cms/selection/' + nSelectionId + '/rule/new');
    },
    
    selectionRuleEdit: function(nSelectionRuleId)
    {
        var popup = Mimoto.popup.open('/mimoto.cms/selectionrule/' + nSelectionRuleId + '/edit');
    },
    
    selectionRuleDelete: function(nSelectionRuleId)
    {
        Mimoto.Aimless.utils.callAPI({
            type: 'get',
            url: '/mimoto.cms/selectionrule/' + nSelectionRuleId + '/delete',
            success: function(resultData, resultStatus, resultSomething) {
                console.log(resultData);
            }
        });
    },
    
    
    /**
     * Content sections
     */
    contentSectionNew: function()
    {
        var popup = Mimoto.popup.open("/mimoto.cms/contentsection/new");
    },
    
    contentSectionView: function(nContentSectionId)
    {
        window.open('/mimoto.cms/contentsection/' + nContentSectionId + '/view', '_self');
    },
    
    contentSectionEdit: function(nContentSectionId)
    {
        Mimoto.popup.open('/mimoto.cms/contentsection/' + nContentSectionId + '/edit');
    },
    contentSectionDelete: function(nContentSectionId)
    {
        Mimoto.Aimless.utils.callAPI({
            type: 'get',
            url: '/mimoto.cms/contentsection/' + nContentSectionId + '/delete',
            success: function(resultData, resultStatus, resultSomething) {
                console.log(resultData);
            }
        });
    },
    
    
    /**
     * Content sections
     */
    contentNew: function(nContentId)
    {
        window.open('/mimoto.cms/content/' + nContentId + '/new', '_self');
    },
    
    contentEdit: function(nContentId, sContentTypeName, nContentItemId)
    {
        window.open('/mimoto.cms/content/' + nContentId + '/' + sContentTypeName + '/' + nContentItemId +'/edit', '_self');
    },
    
    
    
    /**
     * Create new form
     */
    entityFormNew: function(nEntityId)
    {
        var popup = Mimoto.popup.open("/mimoto.cms/entity/" + nEntityId + "/form/new");
        
        //popup.on('success') = popup.close();
    },
    
    formView: function(nFormId)
    {
        window.open('/mimoto.cms/form/' + nFormId + '/view', '_self');
    },
    
    formEdit: function(nFormId)
    {
        Mimoto.popup.open('/mimoto.cms/form/' + nFormId + '/edit');
    },
    
    formDelete: function(nFormId)
    {
        $.ajax({
            type: 'get',
            url: "/mimoto.cms/form/" + nFormId + "/delete",
            success: function(resultData, resultStatus, resultSomething) {
                console.log(resultData);
            }
        });
    },
    
    formFieldNew_TypeSelector: function(nFormId)
    {
        Mimoto.popup.open('/mimoto.cms/form/' + nFormId + '/field/new');
    },
    
    formFieldNew_FieldForm: function(nFormId, nFormFieldTypeId)
    {
        console.log('formFieldNew_FieldForm: nFormId=' + nFormId + ', nFormFieldTypeId=' + nFormFieldTypeId);
        
        Mimoto.popup.replace('/mimoto.cms/form/' + nFormId + '/field/new/' + nFormFieldTypeId);
    },
    
    formFieldEdit: function(nFormFieldTypeId, nFormFieldId)
    {
        window.open('/mimoto.cms/formfield/' + nFormFieldTypeId + '/' + nFormFieldId + '/edit', '_self');
    },
    
    formFieldDelete:  function(nFormFieldTypeId, nFormFieldId)
    {
        $.ajax({
            type: 'get',
            url: "/mimoto.cms/formfield/" + nFormFieldTypeId + '/' + nFormFieldId + '/delete',
            success: function(resultData, resultStatus, resultSomething) {
                console.log(resultData);
            }
        });
    },
    
    formFieldAddItemToList: function(sURL)
    {
        Mimoto.popup.open(sURL);
    },
    
    formFieldOptionEdit: function(nOptionID)
    {
        console.log('formFieldOptionEdit: ' + nOptionID);
        alert('formFieldOptionEdit: ' + nOptionID);
        
        //Mimoto.popup.replace('/mimoto.cms/form/' + nFormId + '/field/new/' + nFormFieldTypeId);
    },
    
    formFieldOptionDelete: function(nOptionId)
    {
        $.ajax({
            type: 'get',
            url: "/mimoto.cms/formfielditem/" + nOptionId + '/delete',
            success: function(resultData, resultStatus, resultSomething) {
                console.log(resultData);
            }
        });
    }
    
}
