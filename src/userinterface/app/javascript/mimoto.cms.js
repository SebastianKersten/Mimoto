//'use strict'; #note SK - do not uncomment

require('jquery-ui');

var HeaderView = require('./views/Header');
var ButtonUtils = require('./utils/Button');
var Sortable = require('sortablejs'); // https://github.com/RubaXa/Sortable

if (typeof Mimoto === "undefined") Mimoto = {};
if (typeof Mimoto.CMS === "undefined") Mimoto.CMS = {};
if (typeof Mimoto.modules === "undefined") Mimoto.modules = {};

//Mimoto = require('./mimoto.cms/Mimoto');

Mimoto.CMS = require('./mimoto.cms/Mimoto.CMS');
Mimoto.modules.Tabmenu = require('./mimoto.cms/modules/Tabmenu');
Mimoto.modules.Popup = require('./mimoto.cms/modules/Popup');
Mimoto.modules.Page = require('./mimoto.cms/modules/Page');
Mimoto.modules.Form = require('./mimoto.cms/modules/Form');
Mimoto.modules.Quill = require('quill');
Mimoto.modules.QuillDelta = require('quill-delta');

// init
Mimoto.CMS = new Mimoto.CMS();
Mimoto.page = new Mimoto.modules.Page();
Mimoto.popup = new Mimoto.modules.Popup();
Mimoto.form = new Mimoto.modules.Form();

// Parchment Embed
const Embed = Mimoto.modules.Quill.import('blots/embed');

// Create Mimoto Infocard to Quill
class MimotoInfocard extends Embed {
  static create(value) {
    var node = super.create(value);
    node.innerText = value;
    return node;
  }
  optimize(){}
}
MimotoInfocard.blotName = 'mimoto-infocard'; //now you can use .ql-hr classname in your toolbar
MimotoInfocard.className = 'mimoto-infocard';
MimotoInfocard.tagName = 'span';

// Register mimoto infocard
Mimoto.modules.Quill.register({
  'formats/mimoto-infocard': MimotoInfocard
});

document.addEventListener('DOMContentLoaded', function () {

    // register
    var navigation = document.querySelector('.js-navigation');
    var header = document.querySelector('.js-header');
    
    // init
    if (navigation && header) { new HeaderView(header); }
    
    
    // setup sortable lists
    
    // find
    var aListElements = document.querySelectorAll('.js-list');
    
    
    var nListCount = aListElements.length;
    for (var nListIndex = 0; nListIndex < nListCount; nListIndex++)
    {
        // register
        var listItem = aListElements[nListIndex];
        
        // read
        var bIsSortable = listItem.classList.contains('js-list-sortable');
    
        // verify
        if (bIsSortable)
        {
            var sortable = new Sortable(listItem, {
                group: 'list_' + nListIndex,
                handle: '.MimotoCMS_ListItemModule-handle',
                dragClass: 'MimotoCMS_ListItemModule--drag',
                ghostClass: 'MimotoCMS_ListItemModule--ghost',
                // store: {
                //     /**
                //      * Get the order of elements. Called once during initialization.
                //      * @param   {Sortable}  sortable
                //      * @returns {Array}
                //      */
                //     get: function (sortable) {
                //         var order = localStorage.getItem(sortable.options.group.name);
                //         return order ? order.split('|') : [];
                //     },
                //
                //     /**
                //      * Save the order of elements. Called onEnd (when the item is dropped).
                //      * @param {Sortable}  sortable
                //      */
                //     set: function (sortable) {
                //         var order = sortable.toArray();
                //         localStorage.setItem(sortable.options.group.name, order.join('|'));
                //     }
                // },
                onEnd: function (e)
                {
                    // adjust
                    Mimoto.form._changeOrder(e.from, e.item, e.oldIndex, e.newIndex)
                }
            });
        }
    }
    
    
    
    
    //var loadingButton = document.querySelector('.js-loading-example');
    //var successButton = document.querySelector('.js-success-example');
    //
    //setTimeout(function () {
    //
    //    ButtonUtils.addLoadingState(loadingButton);
    //
    //}.bind(this), 1000);
    //
    //setTimeout(function () {
    //
    //    ButtonUtils.removeLoadingState(loadingButton);
    //
    //}.bind(this), 3000);
    //
    //setTimeout(function () {
    //
    //    ButtonUtils.addSuccessState(successButton);
    //
    //}.bind(this), 1000);
    //
    //setTimeout(function () {
    //
    //    ButtonUtils.removeSuccessState(successButton);
    //
    //}.bind(this), 3000);
    

}, false);
