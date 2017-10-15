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
/******/ 	__webpack_require__.h = "b8554b38045b30b34483";
/******/
/******/ 	// __webpack_chunkname__
/******/ 	__webpack_require__.cn = "js/publisher.js";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 457);
/******/ })
/************************************************************************/
/******/ ({

/***/ 457:
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * Mimoto.Publisher - Demo - How to build a publication platform
 *
 * @author Sebastian Kersten (@supertaboo)
 */



// Publisher demo classes

var Publisher = __webpack_require__(458);

/**
 * Auto run
 */
document.addEventListener('DOMContentLoaded', function () {
  // init
  window.Publisher = new Publisher();
}, false);

/***/ }),

/***/ 458:
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * Mimoto.Publisher - Demo - How to build a publication platform
 *
 * @author Sebastian Kersten (@supertaboo)
 */



// Mimoto classes

var Article = __webpack_require__(459);
var Editor = __webpack_require__(460);

var AlsoOnThisPage = __webpack_require__(461);
var IsTypingComment = __webpack_require__(462);

module.exports = function () {

    // start
    this.__construct();
};

module.exports.prototype = {

    // presence
    _alsoOnThisPage: null,
    _isTypingComment: null,

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
        this._alsoOnThisPage = new AlsoOnThisPage(channel);
    },

    isTypingComment: function isTypingComment(channel) {
        this._isTypingComment = new IsTypingComment(channel);
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

/***/ 459:
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

/***/ 460:
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

/***/ }),

/***/ 461:
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * Mimoto.Publisher - Demo "Also on this page"
 *
 * @author Sebastian Kersten (@supertaboo)
 */



module.exports = function (channel) {

    // start
    this.__construct(channel);
};

module.exports.prototype = {

    // communication
    _channel: null,
    _others: [],

    // dom
    _elOtherTemplate: null,
    _elOtherContainer: null,

    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function __construct(channel) {
        // store
        this._channel = channel;

        // register
        this._elOtherTemplate = channel.element.querySelector('[data-publisher-article-others-other-template]');
        this._elOtherContainer = channel.element.querySelector('[data-publisher-article-others-container]');

        //configure
        channel.onSelfConnected = this._onSelfConnected.bind(this);
        channel.onOtherConnected = this._onOtherConnected.bind(this);
        channel.onOtherIdentified = this._onOtherIdentified.bind(this);
        channel.onOtherDisconnected = this._onOtherDisconnected.bind(this);
    },

    // ----------------------------------------------------------------------------
    // --- Event listeners --------------------------------------------------------
    // ----------------------------------------------------------------------------


    _onSelfConnected: function _onSelfConnected(aOthers) {
        // 1. init
        this._initOthersAlreadyOnPage(aOthers);

        // 2. broadcast
        this._channel.identify({ firstName: Mimoto.user.firstName, lastName: Mimoto.user.lastName, avatar: Mimoto.user.avatar });
    },

    _onOtherConnected: function _onOtherConnected(clientId) {
        // add
        this._addOther(clientId);
    },

    _onOtherIdentified: function _onOtherIdentified(clientId) {
        this._showPublicInfo(clientId);
    },

    _onOtherDisconnected: function _onOtherDisconnected(clientId) {
        // 1. verify if user was known
        if (!this._others[clientId]) return;

        // 2. register
        var elOther = this._others[clientId].element;

        // 3. remove
        elOther.parentNode.removeChild(elOther);

        // 4. cleanup
        delete this._others[clientId];

        // 5. update
        this._toggleVisibility();
    },

    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    _initOthersAlreadyOnPage: function _initOthersAlreadyOnPage(aOthers) {
        // build
        var nOtherCount = aOthers.length;
        for (var nOtherIndex = 0; nOtherIndex < nOtherCount; nOtherIndex++) {
            // register
            var clientId = aOthers[nOtherIndex];

            // add
            this._addOther(clientId);

            // show public info
            this._showPublicInfo(clientId);
        }
    },

    _addOther: function _addOther(clientId) {
        // create
        var elOther = this._elOtherTemplate.cloneNode(true);

        // connect
        this._elOtherContainer.appendChild(elOther);

        // store
        this._others[clientId] = { element: elOther };

        // update
        this._toggleVisibility();
    },

    _showPublicInfo: function _showPublicInfo(clientId) {
        // verify if user was known
        if (!this._others[clientId]) return;

        // register
        var clientInfo = this._channel.getInfo(clientId);

        // validate
        if (!clientInfo) return;

        // register
        var elOther = this._others[clientId].element;
        var elAvatarInitials = elOther.querySelector('[data-publisher-article-others-other-initials]');

        // set data
        if (clientInfo.avatar) {
            elOther.setAttribute('style', 'background-image: url("' + clientInfo.avatar + '");');
            elAvatarInitials.innerText = '';
        } else {
            elAvatarInitials.innerText = clientInfo.firstName.substr(0, 1).toUpperCase() + clientInfo.lastName.substr(0, 1).toUpperCase();
        }
    },

    _toggleVisibility: function _toggleVisibility() {
        // find other
        var bHasItems = false;
        for (var clientId in this._others) {
            bHasItems = true;break;
        }

        // toggle
        this._channel.element.style.visibility = !bHasItems ? 'hidden' : 'visible';
    }

};

/***/ }),

/***/ 462:
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * Mimoto.Publisher - Demo "Is typing"
 *
 * @author Sebastian Kersten (@supertaboo)
 */



module.exports = function (channel) {

    // start
    this.__construct(channel);
};

module.exports.prototype = {

    // communication
    _channel: null,
    _aOthersCurrentlyTyping: [],

    // dom
    _elIsTypingMessage: null,

    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function __construct(channel) {
        // store
        this._channel = channel;

        // register
        this._elIsTypingMessage = document.querySelector('[data-publisher-conversation-istypingmessage]');

        //configure
        channel.onSelfConnected = this._onSelfConnected.bind(this);

        // configure
        channel.receive('isTyping', this._onOtherIsTyping.bind(this));

        //configure
        channel.element.addEventListener('input', this._onInput.bind(this));
    },

    // ----------------------------------------------------------------------------
    // --- Event listeners --------------------------------------------------------
    // ----------------------------------------------------------------------------


    _onSelfConnected: function _onSelfConnected() {
        // broadcast
        this._channel.identify({ firstName: Mimoto.user.firstName });
    },

    _onInput: function _onInput() {

        Mimoto.log('Is typing ... onInput ...');

        this._channel.send('isTyping');
    },

    _onOtherIsTyping: function _onOtherIsTyping(clientId, message) {

        // add to array if not in_array

        Mimoto.log('Is typing', this._channel.getInfo(clientId));

        // register
        this._aOthersCurrentlyTyping.push(data.firstName);

        // update
        //this._updateIsTypingMessage(channel.element);

    },

    _updateIsTypingMessage: function _updateIsTypingMessage(element) {
        // init
        var sMessage = '';

        // compose
        var nUserCount = this._aOthersCurrentlyTyping.length;
        for (var nUserIndex = 0; nUserIndex < nUserCount; nUserIndex++) {
            // build
            sMessage += this._aOthersCurrentlyTyping[nUserIndex];

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
    }

};

/***/ })

/******/ });
//# sourceMappingURL=publisher.js.map