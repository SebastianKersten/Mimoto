//'use strict'; #note SK - do not uncomment

require('jquery-ui');

var HeaderView = require('./views/Header');
var ButtonUtils = require('./utils/Button');

if (typeof Mimoto == "undefined") Mimoto = {};
if (typeof Mimoto.CMS == "undefined") Mimoto.CMS = {};
if (typeof Mimoto.modules == "undefined") Mimoto.modules = {};

//Mimoto = require('./mimoto.cms/Mimoto');

Mimoto.CMS = require('./mimoto.cms/Mimoto.CMS');
Mimoto.modules.Tabmenu = require('./mimoto.cms/modules/Tabmenu');
Mimoto.modules.Popup = require('./mimoto.cms/modules/Popup');
Mimoto.modules.Page = require('./mimoto.cms/modules/Page');
Mimoto.modules.Form = require('./mimoto.cms/modules/Form');

// init
Mimoto.CMS = new Mimoto.CMS();
Mimoto.page = new Mimoto.modules.Page();
Mimoto.popup = new Mimoto.modules.Popup();
Mimoto.form = new Mimoto.modules.Form();


document.addEventListener('DOMContentLoaded', function () {

    // register
    var navigation = document.querySelector('.js-navigation');
    var header = document.querySelector('.js-header');
    
    // init
    if (navigation && header) { new HeaderView(header); }
    
    
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
