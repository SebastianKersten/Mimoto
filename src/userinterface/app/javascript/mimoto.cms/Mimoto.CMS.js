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
        Mimoto.Aimless.utils.callAPI({
            type: 'POST',
            url: "/mimoto.cms/entity/" + nEntityId + "/update",
            data: data,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething) {
                Mimoto.popup.close();
            }
        });
    },

    entityDelete: function(nEntityId, sEntityName)
    {
        var response = confirm("Are you sure you want to delete the entity '" + sEntityName + "'?\n\nALL DATA WILL BE LOST!!\n\n(Really! I'm not kidding!)");
        if (response == true) {
    
            Mimoto.Aimless.utils.callAPI({
                type: 'GET',
                url: "/mimoto.cms/entity/" + nEntityId + "/delete",
                //data: data,
                dataType: 'json',
                success: function(resultData, resultStatus, resultSomething) {
                    window.open('/mimoto.cms/entities', '_self');
                }
            });
        }
    },

    entityPropertyNew: function(nEntityId)
    {
        Mimoto.popup.open("/mimoto.cms/entity/" + nEntityId + "/property/new");
    },

    entityPropertyCreate: function(nEntityId, data)
    {
        Mimoto.Aimless.utils.callAPI({
            type: 'POST',
            url: "/mimoto.cms/entity/" + nEntityId + "/property/create",
            data: data,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething) {
                Mimoto.popup.close();
            }
        });
    },

    entityPropertyEdit: function(nEntityPropertyId)
    {
        Mimoto.popup.open("/mimoto.cms/entityproperty/" + nEntityPropertyId + "/edit");
    },
    
    entityPropertyDelete:  function(nEntityPropertyId, sEntityPropertyName)
    {
        var response = confirm("Are you sure you want to delete the property '" + sEntityPropertyName + "'?\n\nALL DATA FROM THAT PROPERTY WILL BE LOST!!\n\n(like, forever ..)");
        if (response == true) {
            // 11. send data
            Mimoto.Aimless.utils.callAPI({
                type: 'get',
                url: "/mimoto.cms/entityproperty/" + nEntityPropertyId + "/delete",
                success: function (resultData, resultStatus, resultSomething) {
                    console.log(resultData);
                }
            });
        }
    },
    
    
    entityPropertySettingEdit: function(nEntityPropertySettingId)
    {
        Mimoto.popup.open('/mimoto.cms/entitypropertysetting/' + nEntityPropertySettingId + '/edit');
    },



    notificationClose: function(sEntityType, nNotificationId)
    {
        // 1. remove 8 and 9 (will be handled by the api call response)
        
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
    
    componentView: function(nComponentId)
    {
        window.open('/mimoto.cms/component/' + nComponentId + '/view', '_self');
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
            data: null,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething) {
                console.log(resultData);
            }
        });
    },
    
    
    componentConditionalNew: function(nComponentId)
    {
        var popup = Mimoto.popup.open('/mimoto.cms/component/' + nComponentId + '/conditional/new');
    },
    
    componentConditionalEdit: function(nComponentConditionalId)
    {
        var popup = Mimoto.popup.open('/mimoto.cms/componentconditional/' + nComponentConditionalId + '/edit');
    },
    
    componentConditionalDelete: function(nComponentConditionalId)
    {
        Mimoto.Aimless.utils.callAPI({
            type: 'get',
            url: '/mimoto.cms/componentconditional/' + nComponentConditionalId + '/delete',
            data: null,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething) {
                console.log(resultData);
            }
        });
    },
    
    
    
    
    //
    //
    // /**
    //  * Create new component
    //  */
    // eNew: function(nEntityId)
    // {
    //     var popup = Mimoto.popup.open("/mimoto.cms/entity/" + nEntityId + "/component/new");
    //
    //     // Mimoto.Aimless/data/
    //
    //
    //     popup() / page()
    // },
    //
    //
    
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
            data: null,
            dataType: 'json',
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
            data: null,
            dataType: 'json',
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
    contentSectionDelete: function(nContentSectionId, sContentSectionName)
    {
        var response = confirm("Are you sure you want to delete the content section called '" + sContentSectionName + "'?\n\nALL RELATED DATA WILL BE LOST!!\n\n(Don't say I didn't warn you!)");
        if (response == true) {
            Mimoto.Aimless.utils.callAPI({
                type: 'get',
                url: '/mimoto.cms/contentsection/' + nContentSectionId + '/delete',
                data: null,
                dataType: 'json',
                success: function (resultData, resultStatus, resultSomething) {
                    console.log(resultData);
                }
            });
        }
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
    
    contentDelete: function(nContentId, sContentTypeName, nContentItemId)
    {
        Mimoto.Aimless.utils.callAPI({
            type: 'get',
            url: '/mimoto.cms/content/' + nContentId + '/' + sContentTypeName + '/' + nContentItemId +'/delete',
            data: null,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething) {
                console.log(resultData);
            }
        });
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
        Mimoto.Aimless.utils.callAPI({
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
        Mimoto.Aimless.utils.callAPI({
            type: 'get',
            url: "/mimoto.cms/formfield/" + nFormFieldTypeId + '/' + nFormFieldId + '/delete',
            data: null,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething) {
                console.log(resultData);
            }
        });
    },
    
    formFieldListItemAdd: function(sInputFieldType, sInputFieldId, sPropertySelector)
    {
        // 1. build
        var sURL = '/mimoto.cms/formfield/' + sInputFieldType + '/' + sInputFieldId + '/add/' + sPropertySelector;
        
        console.log(sURL);
        
        var popup = Mimoto.popup.open(sURL);
        
        // 1. return root of the popup (or root object)
        // 2. connect content of the popup (onload) to the popup object
        // 3. dispatchSuccess
        // 4. handle success
        // 5. do not autoconnect
        // 6. add new value to list
        
        popup.success = function()
        {
            
        }
    },
    
    formFieldListItemEdit: function(sInputFieldType, sInputFieldId, sPropertySelector, sInstanceType, sInstanceId)
    {
        // reload
        window.open("/mimoto.cms/formfield/" + sInputFieldType + "/" + sInputFieldId + "/edit/" + sPropertySelector + '/' + sInstanceType + '/' + sInstanceId, '_self');
    },
    
    
    formFieldListItemDelete: function(sInputFieldType, sInputFieldId, sPropertySelector, sInstanceType, sInstanceId)
    {
        // 1. sInputFieldType
        // 2. sInputFieldId
        
        
        Mimoto.Aimless.utils.callAPI({
            type: 'get',
            url: '/mimoto.cms/formfield/' + sInputFieldType + '/' + sInputFieldId +  '/remove/' + sPropertySelector + '/' + sInstanceType + '/' + sInstanceId,
            data: null,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething) {
                console.log(resultData);
            }
        });
    }
    
}
