function setupSortable()
{
    var sortableCategoriesEl = document.querySelector('.js-sortable-container-categories');
    var sortableItemsEl = document.querySelector('.js-sortable-container-items');

    var sortableCategories = Mimoto.modules.Sortable.create(sortableCategoriesEl, {
        draggable: '.js-sortable-item',
        handle: '.js-sortable-item-handle',
        group: {
            name: 'group',
            pull: 'clone',
            put: false,
            revertClone: true
        },

        onEnd: function (evt) {
            var replaceItem = sortableItemsEl.querySelectorAll('.js-sortable-item')[evt.newIndex + 1];
            // evt.oldIndex;  // element's old index within parent
            // console.log(evt.newIndex);  // element's new index within parent
            // console.log(evt);
            replaceItem.style.display = 'none';
        },
    });

    var sortableItems = Mimoto.modules.Sortable.create(sortableItemsEl, {
        draggable: '.js-sortable-item',
        handle: '.js-sortable-item-handle',
        group: {
            name: 'group',
            pull: false,
            put: true
        },

        // onEnd: function (evt) {
        //     // evt.oldIndex;  // element's old index within parent
        //     console.log(evt.newIndex);  // element's new index within parent
        // },
    });

    // console.log(sortable);
}
