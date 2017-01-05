'use strict';

var Sortable = require('sortablejs'); // https://github.com/RubaXa/Sortable

module.exports = function (element) {

    this.el = element;
    this.init();

};

module.exports.prototype = {

    init: function () {

        console.log('Init List');

        this.setVariables();

        if (this.isSortable) {
            this.initSortable();
        }

    },

    setVariables: function () {

        this.isSortable = this.el.classList.contains('js-list-sortable');

    },

    initSortable: function () {

        this.sortable = new Sortable(this.el, {
            group: "list", // @sebastian dit moet worden veranderd in een unieke waarde, kan jij vast wel meegeven vanuit Aimless
            handle: '.MimotoCMS_forms_input_ListItem-handle',
            dragClass: 'MimotoCMS_forms_input_ListItem--drag',
            ghostClass: 'MimotoCMS_forms_input_ListItem--ghost',
            store: {
                /**
                 * Get the order of elements. Called once during initialization.
                 * @param   {Sortable}  sortable
                 * @returns {Array}
                 */
                get: function (sortable) {
                    var order = localStorage.getItem(sortable.options.group.name);
                    return order ? order.split('|') : [];
                },

                /**
                 * Save the order of elements. Called onEnd (when the item is dropped).
                 * @param {Sortable}  sortable
                 */
                set: function (sortable) {
                    var order = sortable.toArray();
                    localStorage.setItem(sortable.options.group.name, order.join('|'));
                }
            },
            onEnd: function (e) {
                console.log(e); // @sebastian in dit event zit alles wat je nodig hebt
            }
        });

    }

};
