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
/******/ 	__webpack_require__.h = "700dd67bf685d27456ac";
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

    // feature: is typing
    _aUsersInCommentField: [],
    _elIsTypingMessage: null,
    _isTypingChannel: null,
    _alsoOnThisPageChannel: null,
    _aClientsOnThisPage: [],

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


    alsoOnThisPage: function alsoOnThisPage(channel) {
        // register
        this._alsoOnThisPageChannel = channel;

        //channel.onOtherJoined = function(client) {
        channel.onConnected = function () {

            // broadcast
            channel.send('join', { firstName: Mimoto.user.firstName, lastName: Mimoto.user.lastName, avatar: Mimoto.user.avatar });
        }.bind(this);

        // //channel.onOtherJoined = function(client) {
        // channel.onOtherConnected = function(clientId) {
        //
        //     this._aClientsOnThisPage[clientId] = {
        //         isNew: true
        //     }
        //
        // }.bind(this);

        //channel.onOtherLeft = function(client) {
        channel.onOtherDisconnected = function (clientId) {
            // validate
            if (!this._aClientsOnThisPage[clientId]) return;

            // toggle
            this._aClientsOnThisPage[clientId].isToBeRemoved = true;

            // update
            this._updateAlsoOnThisPage(clientId);

            // cleanup
            delete this._aClientsOnThisPage[clientId];

            // toggle visibility
            this._toggleAlsoOnThisPageVisibility();
        }.bind(this);

        channel.receive('join', function (data, clientId) {
            this._aClientsOnThisPage[clientId] = {
                isNew: true,
                firstName: data.firstName,
                lastName: data.lastName,
                avatar: data.avatar
            };

            this._updateAlsoOnThisPage(clientId);

            // toggle visibility
            this._toggleAlsoOnThisPageVisibility();
        }.bind(this));
    },

    _updateAlsoOnThisPage: function _updateAlsoOnThisPage(userId) {

        for (var clientId in this._aClientsOnThisPage) {
            // register
            var client = this._aClientsOnThisPage[clientId];

            if (client.isNew) {
                // reset
                delete client.isNew;

                // init
                client.element = this._alsoOnThisPageChannel.element.querySelector('[data-publisher-article-others-other-template]').cloneNode();

                // add
                this._alsoOnThisPageChannel.element.querySelector('[data-publisher-article-others-container]').appendChild(client.element);

                // register
                var elAvatarInitials = this._alsoOnThisPageChannel.element.querySelector('[data-publisher-article-others-other-initials]');

                // set data
                if (client.avatar) client.element.setAttribute('style', 'background-image:url(' + client.avatar + ');');

                elAvatarInitials.innerText = client.firstName.substr(0, 1).toUpperCase() + client.lastName.substr(0, 1).toUpperCase();

                console.log('isNew!');
            }

            if (client.isToBeRemoved) {
                // reset
                delete client.isToBeRemoved;

                console.log('isToBeRemoved!');

                client.element.parentNode.removeChild(client.element);
            }
        }
    },

    _toggleAlsoOnThisPageVisibility: function _toggleAlsoOnThisPageVisibility() {

        var bHasItems = false;
        for (var sKey in this._aClientsOnThisPage) {
            bHasItems = true;break;
        }

        Mimoto.warn('!this._aClientsOnThisPage', !this._aClientsOnThisPage, bHasItems);

        // toggle visibility
        if (!bHasItems) {
            this._alsoOnThisPageChannel.element.classList.add('Mimoto_CoreCSS_hidden');
        } else {
            this._alsoOnThisPageChannel.element.classList.remove('Mimoto_CoreCSS_hidden');
        }
    },

    // -----------


    isTypingComment: function isTypingComment(channel) {
        // register
        this._isTypingChannel = channel;

        // find and register
        this._elIsTypingMessage = document.querySelector('[data-publisher-conversation-istypingmessage]');

        // initial setup
        this._updateIsTypingMessage(channel.element);

        channel.element.addEventListener('focus', function () {

            // broadcast
            channel.send('startsTyping', { firstName: Mimoto.user.firstName });
        });

        channel.element.addEventListener('blur', function () {

            // broadcast
            channel.send('stopsTyping', { firstName: Mimoto.user.firstName });
        });

        channel.receive('startsTyping', function (data) {
            // register
            this._aUsersInCommentField.push(data.firstName);

            // update
            this._updateIsTypingMessage(channel.element);
        }.bind(this));

        channel.receive('stopsTyping', function (data) {
            // cleanup - #todo needs public id or id provided by realtime.js
            var nUserCount = this._aUsersInCommentField.length;
            for (var nUserIndex = 0; nUserIndex < nUserCount; nUserIndex++) {
                // verify
                if (this._aUsersInCommentField[nUserIndex] === data.firstName) {
                    // remove
                    this._aUsersInCommentField.splice(nUserIndex, 1);
                    break;
                }
            }

            // update
            this._updateIsTypingMessage(channel.element);
        }.bind(this));
    },

    _updateIsTypingMessage: function _updateIsTypingMessage(element) {
        // init
        var sMessage = '';

        // compose
        var nUserCount = this._aUsersInCommentField.length;
        for (var nUserIndex = 0; nUserIndex < nUserCount; nUserIndex++) {
            // build
            sMessage += this._aUsersInCommentField[nUserIndex];

            // connect
            if (nUserIndex < nUserCount - 1) {
                sMessage += nUserCount === 2 || nUserIndex === nUserCount - 2 ? ' and ' : ', ';
            }
        }

        // update interface
        if (nUserCount === 0) {
            // cleanup
            this._elIsTypingMessage.innerHTML = '&nbsp;';
        } else {
            this._elIsTypingMessage.innerText = sMessage + ' ' + (nUserCount === 1 ? 'is' : 'are') + ' typing ..';
        }
    },

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