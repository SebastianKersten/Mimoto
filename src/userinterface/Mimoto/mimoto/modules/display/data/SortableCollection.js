/**
 * Mimoto - Data manipulation - SortableCollection
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// RubaXa classes
let Sortable = require('sortablejs');


module.exports = function(directive)
{
    // start
    this.__construct(directive);
};

module.exports.prototype = {

    // utils
    _sortable: null,


    __construct: function(directive)
    {
        // setup
        this._sortable = new Sortable(directive.element, {
            group: directive.id,
            handle: '.MimotoCMS_CoreCSS_draghandle',
            dragClass: 'MimotoCMS_forms_input_ListItem--drag',
            ghostClass: 'MimotoCMS_forms_input_ListItem--ghost',
            onEnd: function (e)
            {
                Mimoto.log('Dragging stopped');
                // adjust
                this._changeOrder(e.from, e.item, e.oldIndex, e.newIndex)

            }.bind(this)
        });
    },


    _changeOrder: function(htmlParentElement, htmlChildElement, nOldIndex, nNewIndex)
    {
        // register
        let sPropertySelector = htmlParentElement.getAttribute('data-mimoto-collection');
        let nConnectionId = htmlChildElement.getAttribute('data-mimoto-connection');
        let nCurrentSortindex = htmlChildElement.getAttribute('data-mimoto-sortindex');

        // validate
        if (!sPropertySelector || !nConnectionId || !nCurrentSortindex) return;

        // store
        Mimoto.utils.callAPI({
            type: 'get',
            url: '/mimoto.cms/form/list/sort/' + sPropertySelector + '/' + nConnectionId + '/' + nOldIndex + '/' + nNewIndex,
            success: function(resultData, resultStatus, resultSomething)
            {
                //console.log('Mimoto ===> I received a response from the FormController::updateSortindex!');
            }
        });
    }

}
