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
        var popup = MimotoX.popup("/mimoto.cms/entity/new");

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
    //         MimotoX.closePopup();
    //     });
    // },

    entityView: function(nEntityId)
    {
        window.open('/mimoto.cms/entity/' + nEntityId + '/view', '_self');
    },

    entityEdit: function(nEntityId)
    {
        MimotoX.popup('/mimoto.cms/entity/' + nEntityId + '/edit');
    },

    entityUpdate: function(nEntityId, data)
    {
        MimotoX.utils.callAPI({
            type: 'POST',
            url: "/mimoto.cms/entity/" + nEntityId + "/update",
            data: data,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething) {
                MimotoX.closePopup();
            }
        });
    },

    entityDelete: function(nEntityId, sEntityName)
    {
        var response = confirm("Are you sure you want to delete the entity '" + sEntityName + "'?\n\nALL DATA WILL BE LOST!!\n\n(Really! I'm not kidding!)");
        if (response == true) {
    
            MimotoX.utils.callAPI({
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
        MimotoX.popup("/mimoto.cms/entity/" + nEntityId + "/property/new");
    },

    entityPropertyCreate: function(nEntityId, data)
    {
        MimotoX.utils.callAPI({
            type: 'POST',
            url: "/mimoto.cms/entity/" + nEntityId + "/property/create",
            data: data,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething) {
                MimotoX.closePopup();
            }
        });
    },

    entityPropertyEdit: function(nEntityPropertyId)
    {
        MimotoX.popup("/mimoto.cms/entityproperty/" + nEntityPropertyId + "/edit");
    },
    
    entityPropertyDelete:  function(nEntityPropertyId, sEntityPropertyName)
    {
        var response = confirm("Are you sure you want to delete the property '" + sEntityPropertyName + "'?\n\nALL DATA FROM THAT PROPERTY WILL BE LOST!!\n\n(like, forever ..)");
        if (response == true) {
            // 11. send data
            MimotoX.utils.callAPI({
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
        MimotoX.popup('/mimoto.cms/entitypropertysetting/' + nEntityPropertySettingId + '/edit');
    },


    instanceDelete:  function(sEntityType, nId)
    {
        var response = confirm("Are you sure you want to delete the instance '" + sEntityType + "." + nId + "'?");
        if (response == true) {
            // 11. send data
            MimotoX.utils.callAPI({
                type: 'get',
                url: "/mimoto.cms/instance/" + sEntityType + "/" + nId + "/delete",
                success: function (resultData, resultStatus, resultSomething) {
                    console.log(resultData);
                }
            });
        }
    },

    instanceDeleteAll:  function(sEntityType)
    {
        var response = confirm("Are you sure you want to delete ALL instances of type '" + sEntityType + "'?");
        if (response == true) {
            // 11. send data
            MimotoX.utils.callAPI({
                type: 'get',
                url: "/mimoto.cms/instance/" + sEntityType + "/all/delete",
                success: function (resultData, resultStatus, resultSomething) {
                    console.log(resultData);
                }
            });
        }
    },


    notificationClose: function(sEntityType, nNotificationId)
    {
        // 1. remove 8 and 9 (will be handled by the api call response)
        
        // 8. find field
        var aNotifications = $("[data-mimoto-id='" + sEntityType + '.' + nNotificationId + "']");

        // 9. collect value
        aNotifications.each( function(index, $component) {
            // init
            //$($component).remove();
        });

        // 11. send data
        MimotoX.utils.callAPI({
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

    notificationsCloseAll: function()
    {
        // 11. send data
        MimotoX.utils.callAPI({
            type: 'GET',
            url: '/mimoto.cms/notifications/closeall',
            data: null,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething)
            {
            }
        });
    },
    
    
    /**
     * Create new component and connect to entity
     */
    entityComponentNew: function(nEntityId)
    {
        var popup = MimotoX.popup("/mimoto.cms/entity/" + nEntityId + "/component/new");
        
        //popup.on('success') = popup.close();
    },

    
    
    /**
     * Selections
     */
    selectionNew: function()
    {
        var popup = MimotoX.popup("/mimoto.cms/selection/new");
    },
    
    selectionView: function(nSelectionId)
    {
        window.open('/mimoto.cms/selection/' + nSelectionId + '/view', '_self');
    },
    
    selectionEdit: function(nSelectionId)
    {
        MimotoX.popup('/mimoto.cms/selection/' + nSelectionId + '/edit');
    },
    
    selectionDelete: function(nSelectionId)
    {
        MimotoX.utils.callAPI({
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
        var popup = MimotoX.popup('/mimoto.cms/selection/' + nSelectionId + '/rule/new');
    },
    
    selectionRuleEdit: function(nSelectionRuleId)
    {
        var popup = MimotoX.popup('/mimoto.cms/selectionrule/' + nSelectionRuleId + '/edit');
    },
    
    selectionRuleDelete: function(nSelectionRuleId)
    {
        MimotoX.utils.callAPI({
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
     * Formatting options
     */
    formattingOptionNew: function()
    {
        var popup = MimotoX.popup("/mimoto.cms/configuration/formattingOption/new");
    },

    formattingOptionView: function(nItemId)
    {
        window.open('/mimoto.cms/configuration/formattingOption/' + nItemId + '/view', '_self');
    },

    formattingOptionEdit: function(nItemId)
    {
        MimotoX.popup('/mimoto.cms/configuration/formattingOption/' + nItemId + '/edit');
    },

    formattingOptionDelete: function(nItemId, sFormattingOptionName)
    {
        var response = confirm("Are you sure you want to delete the formatting option '" + sFormattingOptionName + "'?\n\nALL DATA FROM THAT PROPERTY WILL BE LOST!!\n\n(like, forever ..)");
        if (response == true)
        {
            MimotoX.utils.callAPI({
                type: 'get',
                url: '/mimoto.cms/configuration/formattingOption/' + nItemId + '/delete',
                data: null,
                dataType: 'json',
                success: function (resultData, resultStatus, resultSomething) {
                    console.log(resultData);
                }
            });
        }
    },

    formattingOptionAttributeNew: function(nItemId)
    {
        var popup = MimotoX.popup('/mimoto.cms/formattingOption/' + nItemId + '/formattingOptionAttribute/new');
    },

    formattingOptionAttributeEdit: function(nItemId)
    {
        var popup = MimotoX.popup('/mimoto.cms/formattingOptionAttribute/' + nItemId + '/edit');
    },

    formattingOptionAttributeDelete: function(nItemId, sFormattingOptionName)
    {
        var response = confirm("Are you sure you want to delete the formatting option '" + sFormattingOptionName + "'?\n\nALL DATA FROM THAT PROPERTY WILL BE LOST!!\n\n(like, forever ..)");
        if (response == true)
        {
            MimotoX.utils.callAPI({
                type: 'get',
                url: '/mimoto.cms/formattingOptionAttribute/' + nItemId + '/delete',
                data: null,
                dataType: 'json',
                success: function (resultData, resultStatus, resultSomething) {
                    console.log(resultData);
                }
            });
        }
    },


    /**
     * User roles
     */
    userRoleNew: function()
    {
        var popup = MimotoX.popup("/mimoto.cms/configuration/userRole/new");
    },

    userRoleView: function(nItemId)
    {
        window.open('/mimoto.cms/configuration/userRole/' + nItemId + '/view', '_self');
    },

    userRoleEdit: function(nItemId)
    {
        MimotoX.popup('/mimoto.cms/configuration/userRole/' + nItemId + '/edit');
    },

    userRoleDelete: function(nItemId, sUserRoleName)
    {
        var response = confirm("Are you sure you want to delete the user role '" + sUserRoleName + "'?\n\nALL DATA FROM THAT PROPERTY WILL BE LOST!!\n\n(like, forever ..)");
        if (response == true)
        {
            MimotoX.utils.callAPI({
                type: 'get',
                url: '/mimoto.cms/configuration/userRole/' + nItemId + '/delete',
                data: null,
                dataType: 'json',
                success: function (resultData, resultStatus, resultSomething) {
                    console.log(resultData);
                }
            });
        }
    },



    /**
     * Pages
     */
    entityXNew: function(sEntityTypeName)
    {
        var popup = MimotoX.popup('/mimoto.cms/entityX/' + sEntityTypeName + '/new');
    },

    entityXView: function(sEntityTypeName, nItemId, sFolder)
    {
        sFolder = (sFolder) ? sFolder + '/' : '';

        window.open('/mimoto.cms/' + sFolder + 'entityX/' + sEntityTypeName + '/' + nItemId + '/view', '_self');
    },

    entityXEdit: function(sEntityTypeName, nItemId)
    {
        MimotoX.popup('/mimoto.cms/entityX/' + sEntityTypeName + '/' + nItemId + '/edit');
    },

    entityXDelete: function(sEntityTypeName, nItemId, sItemName)
    {
        var response = confirm("Are you sure you want to delete the " + sEntityTypeName + " '" + sItemName + "'?\n\nALL DATA FROM THAT PROPERTY WILL BE LOST!!\n\n(like, forever ..)");
        if (response == true)
        {
            MimotoX.utils.callAPI({
                type: 'get',
                url: '/mimoto.cms/entityX/' + sEntityTypeName + '/' + nItemId + '/delete',
                data: null,
                dataType: 'json',
                success: function (resultData, resultStatus, resultSomething) {
                    console.log(resultData);
                }
            });
        }
    },


    /**
     * Pages - TEMP
     */
    pageNew: function()
    {
        var popup = MimotoX.popup("/mimoto.cms/page/new");
    },

    pageView: function(nItemId)
    {
        window.open('/mimoto.cms/page/' + nItemId + '/view', '_self');
    },

    pageEdit: function(nItemId)
    {
        MimotoX.popup('/mimoto.cms/page/' + nItemId + '/edit');
    },

    pageDelete: function(nItemId, sPageName)
    {
        var response = confirm("Are you sure you want to delete the page '" + sPageName + "'?\n\nALL DATA FROM THAT PROPERTY WILL BE LOST!!\n\n(like, forever ..)");
        if (response == true)
        {
            MimotoX.utils.callAPI({
                type: 'get',
                url: '/mimoto.cms/page/' + nItemId + '/delete',
                data: null,
                dataType: 'json',
                success: function (resultData, resultStatus, resultSomething) {
                    console.log(resultData);
                }
            });
        }
    },



    /**
     * Users
     */
    userNew: function()
    {
        var popup = MimotoX.popup("/mimoto.cms/user/new");
    },

    userView: function(nUserId)
    {
        window.open('/mimoto.cms/user/' + nUserId + '/view', '_self');
    },

    userEdit: function(nUserId)
    {
        MimotoX.popup('/mimoto.cms/user/' + nUserId + '/edit');
    },

    userDelete: function(nUserId)
    {
        MimotoX.utils.callAPI({
            type: 'get',
            url: '/mimoto.cms/user/' + nUserId + '/delete',
            data: null,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething) {
                console.log(resultData);
            }
        });
    },

    
    /**
     * Layouts
     */
    layoutNew: function()
    {
        var popup = MimotoX.popup("/mimoto.cms/layout/new");
    },
    
    layoutView: function(nLayoutId)
    {
        window.open('/mimoto.cms/layout/' + nLayoutId + '/view', '_self');
    },
    
    layoutEdit: function(nLayoutId)
    {
        MimotoX.popup('/mimoto.cms/layout/' + nLayoutId + '/edit');
    },
    
    layoutDelete: function(nLayoutId)
    {
        MimotoX.utils.callAPI({
            type: 'get',
            url: '/mimoto.cms/layout/' + nLayoutId + '/delete',
            data: null,
            dataType: 'json',
            success: function(resultData, resultStatus, resultSomething) {
                console.log(resultData);
            }
        });
    },
    
    layoutContainerNew: function(nLayoutId)
    {
        var popup = MimotoX.popup('/mimoto.cms/layout/' + nLayoutId + '/layoutcontainer/new');
    },
    
    layoutContainerEdit: function(nLayoutContainerId)
    {
        var popup = MimotoX.popup('/mimoto.cms/layoutcontainer/' + nLayoutContainerId + '/edit');
    },
    
    layoutContainerDelete: function(nLayoutContainerId)
    {
        MimotoX.utils.callAPI({
            type: 'get',
            url: '/mimoto.cms/layoutcontainer/' + nLayoutContainerId + '/delete',
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
        var popup = MimotoX.popup("/mimoto.cms/contentsection/new");
    },
    
    contentSectionView: function(nContentSectionId)
    {
        window.open('/mimoto.cms/contentsection/' + nContentSectionId + '/view', '_self');
    },
    
    contentSectionEdit: function(nContentSectionId)
    {
        MimotoX.popup('/mimoto.cms/contentsection/' + nContentSectionId + '/edit');
    },
    contentSectionDelete: function(nContentSectionId, sContentSectionName)
    {
        var response = confirm("Are you sure you want to delete the content section called '" + sContentSectionName + "'?\n\nALL RELATED DATA WILL BE LOST!!\n\n(Don't say I didn't warn you!)");
        if (response == true) {
            MimotoX.utils.callAPI({
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
        //Mimoto.page.open('/mimoto.cms/content/' + nContentId + '/new');
        window.open('/mimoto.cms/content/' + nContentId + '/new', '_self');
    },
    
    contentEdit: function(nContentId, sContentTypeName, nContentItemId)
    {
        //Mimoto.page.open('/mimoto.cms/content/' + nContentId + '/' + sContentTypeName + '/' + nContentItemId +'/edit');
        window.open('/mimoto.cms/content/' + nContentId + '/' + sContentTypeName + '/' + nContentItemId +'/edit', '_self');
    },
    
    contentDelete: function(nContentId, sContentTypeName, nContentItemId)
    {
        var response = confirm("Are you sure you want to delete this item?");
        if (response == true) {
            MimotoX.utils.callAPI({
                type: 'get',
                url: '/mimoto.cms/content/' + nContentId + '/' + sContentTypeName + '/' + nContentItemId + '/delete',
                data: null,
                dataType: 'json',
                success: function (resultData, resultStatus, resultSomething) {
                    console.log(resultData);
                }
            });
        }
    },
    
    
    
    /**
     * Create new form
     */
    entityFormNew: function(nEntityId)
    {
        var popup = MimotoX.popup("/mimoto.cms/entity/" + nEntityId + "/form/new");
        
        //popup.on('success') = popup.close();
    },
    
    entityFormAutogenerate: function(nEntityId)
    {
        MimotoX.utils.callAPI({
            type: 'get',
            url: "/mimoto.cms/entity/" + nEntityId + "/form/autogenerate",
            success: function(resultData, resultStatus, resultSomething) {
                console.log(resultData);
            }
        });
    },
    
    formView: function(nFormId)
    {
        window.open('/mimoto.cms/form/' + nFormId + '/view', '_self');
    },
    
    formEdit: function(nFormId)
    {
        MimotoX.popup('/mimoto.cms/form/' + nFormId + '/edit');
    },
    
    formDelete: function(nFormId)
    {
        MimotoX.utils.callAPI({
            type: 'get',
            url: "/mimoto.cms/form/" + nFormId + "/delete",
            success: function(resultData, resultStatus, resultSomething) {
                console.log(resultData);
            }
        });
    },
    
    formFieldNew_TypeSelector: function(nFormId)
    {
        MimotoX.popup('/mimoto.cms/form/' + nFormId + '/field/new');
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
        MimotoX.utils.callAPI({
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
        
        var popup = MimotoX.popup(sURL);
        
        // 1. return root of the popup (or root object)
        // 2. connect content of the popup (onload) to the popup object
        // 3. dispatchSuccess
        // 4. handle success
        // 5. do not autoconnect
        // 6. add new value to list
        
        // popup.success = function()
        // {
        //
        // }
    },
    
    formFieldListItemEdit: function(nConnectionId, sInstanceType, sInstanceId)
    {
        // search
        var listInfo = this.findListByListItem(nConnectionId, sInstanceType, sInstanceId);
        
        // execute
        window.open("/mimoto.cms/formfield/" + listInfo.sInputFieldType + "/" + listInfo.sInputFieldId + "/edit/" + listInfo.sPropertySelector + '/' + sInstanceType + '/' + sInstanceId, '_self');
    },
    
    
    formFieldListItemDelete: function(nConnectionId, sInstanceType, sInstanceId)
    {
        // search
        var listInfo = this.findListByListItem(nConnectionId, sInstanceType, sInstanceId);
        
        // execute
        var response = confirm("Are you sure you want to delete this item?");
        if (response == true) {
            MimotoX.utils.callAPI({
                type: 'get',
                url: '/mimoto.cms/formfield/' + listInfo.sInputFieldType + '/' + listInfo.sInputFieldId + '/remove/' + listInfo.sPropertySelector + '/' + sInstanceType + '/' + sInstanceId,
                data: null,
                dataType: 'json',
                success: function (resultData, resultStatus, resultSomething) {
                    console.log(resultData);
                }
            });
        }
    },
    
    findListByListItem: function(nConnectionId, sInstanceType, sInstanceId)
    {
        // init
        var listInfo = [];
        
        // search
        var $listItem = $('[data-mimoto-id="' + sInstanceType + '.' + sInstanceId + '"][data-mimoto-connection="' + nConnectionId + '"]');
        
        
        // validate
        if (!$listItem) { console.log('ListItem not found'); return; }
    
    
        // search
        var $parent = $($listItem).parent();
    
        // register
        var sInputFieldSelector = $($parent).attr('data-mimoto-list-id');
        
        // split
        var aInputFieldSelectorElements = sInputFieldSelector.split('.');
        
        // compose
        listInfo.sInputFieldType = aInputFieldSelectorElements[0];
        listInfo.sInputFieldId = aInputFieldSelectorElements[1];
        listInfo.sPropertySelector = sInputFieldSelector;
        
        // send
        return listInfo;
    }
    
}
