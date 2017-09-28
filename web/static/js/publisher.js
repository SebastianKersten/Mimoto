/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// __webpack_hash__
/******/ 	__webpack_require__.h = "064f16bd33f4cea329b9";
/******/
/******/ 	// __webpack_chunkname__
/******/ 	__webpack_require__.cn = "js/publisher.js";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 456);
/******/ })
/************************************************************************/
/******/ ({

/***/ 456:
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * Mimoto.Publisher - Demo - How to build a publication platform
 *
 * @author Sebastian Kersten (@supertaboo)
 */



// Publisher demo classes

var Publisher = __webpack_require__(457);

/**
 * Auto run
 */
document.addEventListener('DOMContentLoaded', function () {
  // init
  window.Publisher = new Publisher();
}, false);

/***/ }),

/***/ 457:
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * Mimoto.Publisher - Demo - How to build a publication platform
 *
 * @author Sebastian Kersten (@supertaboo)
 */



// Mimoto classes

var Article = __webpack_require__(458);
var Editor = __webpack_require__(459);

module.exports = function () {

    // start
    this.__construct();
};

module.exports.prototype = {

    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------


    article: null,
    editor: null,

    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function __construct() {
        // connect
        this._setupArticle();
    },

    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------

    //
    // isTyping: function(channel)
    // {
    //     channel.element.addEventListener('focus', function() {
    //
    //        channel.send({
    //            action: 'isTyping',
    //            user_firstName: Mimoto.user.firstName
    //        })
    //     });
    //
    //     channel.receive( function(data){
    //         if (data.action == 'isTyping')
    //         {
    //             elIsTyping.innerText = data.user_firstName + ' is typing'
    //         }
    //
    //     })
    // },


    /**
     * Setup article
     * @private
     */
    _setupArticle: function _setupArticle() {
        // init
        var ARTICLE_SELECTOR = 'data-js-article';

        // search
        var articleElement = document.querySelector('[' + ARTICLE_SELECTOR + ']');

        // verify
        if (!articleElement) return;

        console.log('Setting up article and editor ...');

        // read
        var nArticleId = articleElement.getAttribute(ARTICLE_SELECTOR);

        // create
        this.article = new Article(nArticleId);
        this.editor = new Editor(nArticleId);
    }

};

/***/ }),

/***/ 458:
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * Mimoto.Publisher - Demo - How to build a publication platform
 *
 * @author Sebastian Kersten (@supertaboo)
 */



module.exports = function (nArticleId) {
    // start
    this.__construct(nArticleId);
};

module.exports.prototype = {

    _nArticleId: null,

    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function __construct(nArticleId) {
        // register
        this._nArticleId = nArticleId;
    },

    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Add a comment to the article
     * @param nArticleId
     */
    addComment: function addComment() {
        // register
        var commentForm = document.getElementById('commentForm');

        // call
        Mimoto.utils.callAPI({
            type: 'post',
            url: "/publisher/article/" + this._nArticleId + "/comment/add",
            data: { message: commentForm.value },
            dataType: 'json',
            success: function success(resultData, resultStatus, resultSomething) {
                commentForm.value = '';
                window.scrollTo(0, document.body.scrollHeight);
            }
        });
    },

    /**
     * Report a comment
     * @param nCommentId
     */
    reportComment: function reportComment(nCommentId) {
        // call
        Mimoto.utils.callAPI({
            type: 'post',
            url: "/publisher/comment/" + nCommentId + "/remove",
            data: { message: commentForm.value },
            dataType: 'json',
            success: function success(resultData, resultStatus, resultSomething) {
                console.log('Comment reported');
            }
        });
    },

    /**
     * Highlight comment
     * @param nCommentId
     */
    highlightComment: function highlightComment(nCommentId) {
        // call
        Mimoto.utils.callAPI({
            type: 'post',
            url: "/publisher/comment/" + nCommentId + "/highlight",
            data: null,
            dataType: 'json',
            success: function success(resultData, resultStatus, resultSomething) {
                console.log('Comment highlighted');
            }
        });
    },

    /**
     * Unhighlight comment
     * @param nCommentId
     */
    unhighlightComment: function unhighlightComment(nCommentId) {
        // call
        Mimoto.utils.callAPI({
            type: 'post',
            url: "/publisher/comment/" + nCommentId + "/unhighlight",
            data: null,
            dataType: 'json',
            success: function success(resultData, resultStatus, resultSomething) {
                console.log('Comment unhighlighted');
            }
        });
    }

};

/***/ }),

/***/ 459:
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * Mimoto.Publisher - Demo - How to build a publication platform
 *
 * @author Sebastian Kersten (@supertaboo)
 */



module.exports = function () {

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
    __construct: function __construct() {},

    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    onInfocardAdd: function onInfocardAdd(NodeConfig) {
        console.log('Hi! from custom publisher onAdd function');

        // 1. check if id is set
        // 2. call popup, or
        // 3. create comment

        //let my_blot = Parchment.find(NodeConfig.node);


        //let popup = Mimoto.popup('/Mimoto.Aimless/form/infocard');
    },

    onInfocardEdit: function onInfocardEdit(NodeConfig) {
        console.log('Hi! from custom publisher onEdit function');

        // 1. check if id is set
        // 2. call popup, or
        // 3. create comment

        var popup = Mimoto.popup('/Mimoto.Aimless/form/infocard');

        // 4. delete formatting options (als mogelijke feedback van popup)
        // 5. onInit (wanneer het op de dom geplaatst worden vanuit een saved state
    }

};

/***/ })

/******/ });
//# sourceMappingURL=publisher.js.map