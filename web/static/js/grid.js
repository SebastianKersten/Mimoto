function setupSortable()
{
    var sortableCategoriesEl = document.querySelector('.js-sortable-container-categories');
    var sortableItemsEl = document.querySelector('.js-sortable-container-items');

    var sortableCategories = Mimoto.modules.Sortable.create(sortableCategoriesEl, {
        draggable: '.js-sortable-item',
        group: {
            name: 'categories',
            pull: 'clone',
            put: false,
            revertClone: true
        },

        onEnd: function (evt) {
            var replaceItem = sortableItemsEl.querySelectorAll('.js-sortable-item')[evt.newIndex + 1];

            // evt.oldIndex;  // element's old index within parent
            // console.log(evt);
            // console.log(evt.to, sortableItemsEl);

            if(evt.to == sortableItemsEl) {
                console.log('on grid');
            }

            // if(evt.related.classList.contains('js-sortable-item')) {
            //     // evt.related.style.left = '-100%';
            //     // console.log('ja)
            //     evt.related.style.backgroundColor = 'orange';
            // }

            replaceItem.style.display = 'none';
        },
    });

    var sortableItems = Mimoto.modules.Sortable.create(sortableItemsEl, {
        draggable: '.js-sortable-item',
        group: {
            name: 'items',
            pull: false,
            put: ['categories']
        },

        // onEnd: function (evt) {
        //     // evt.oldIndex;  // element's old index within parent
        //     console.log(evt.newIndex);  // element's new index within parent
        // },
    });

    // console.log(sortable);
}