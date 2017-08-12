/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
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
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "web/static/js/";
/******/
/******/ 	// __webpack_hash__
/******/ 	__webpack_require__.h = "04038deff55a9a8b18d5";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ({

/***/ 0:
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(115);


/***/ },

/***/ 115:
/***/ function(module, exports, __webpack_require__) {

	/**
	 * Mimoto.Publisher - Demo - How to build a publication platform
	 *
	 * @author Sebastian Kersten (@supertaboo)
	 */
	
	
	'use strict';
	
	
	// Publisher demo classes
	let Publisher = __webpack_require__(116);
	
	
	/**
	 * Auto run
	 */
	document.addEventListener('DOMContentLoaded', function ()
	{
	    // init
	    window.Publisher = new Publisher();
	
	}, false);


/***/ },

/***/ 116:
/***/ function(module, exports, __webpack_require__) {

	/**
	 * Mimoto.Publisher - Demo - How to build a publication platform
	 *
	 * @author Sebastian Kersten (@supertaboo)
	 */
	
	
	'use strict';
	
	
	// Mimoto classes
	let Article = __webpack_require__(117);
	let Editor = __webpack_require__(118);
	
	
	module.exports = function() {
	
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
	    __construct: function()
	    {
	        // connect
	        this._setupArticle();
	    },
	
	
	
	    // ----------------------------------------------------------------------------
	    // --- Private methods --------------------------------------------------------
	    // ----------------------------------------------------------------------------
	
	
	    /**
	     * Setup article
	     * @private
	     */
	    _setupArticle: function()
	    {
	        // init
	        const ARTICLE_SELECTOR = 'data-js-article';
	
	        // search
	        let articleElement = document.querySelector('[' + ARTICLE_SELECTOR + ']');
	
	        // verify
	        if (!articleElement) return;
	
	
	        console.log('Setting up article and editor ...');
	
	
	        // read
	        let nArticleId = articleElement.getAttribute(ARTICLE_SELECTOR);
	
	        // create
	        this.article = new Article(nArticleId);
	        this.editor = new Editor(nArticleId);
	    }
	
	};


/***/ },

/***/ 117:
/***/ function(module, exports) {

	/**
	 * Mimoto.Publisher - Demo - How to build a publication platform
	 *
	 * @author Sebastian Kersten (@supertaboo)
	 */
	
	
	'use strict';
	
	
	module.exports = function(nArticleId)
	{
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
	    __construct: function(nArticleId)
	    {
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
	    addComment: function()
	    {
	        // register
	        let commentForm = document.getElementById('commentForm');
	
	        // call
	        MimotoX.utils.callAPI({
	            type: 'post',
	            url: "/publisher/article/" + this._nArticleId + "/comment/add",
	            data: {message: commentForm.value},
	            dataType: 'json',
	            success: function(resultData, resultStatus, resultSomething) {
	                commentForm.value = '';
	                window.scrollTo(0,document.body.scrollHeight);
	            }
	        });
	    },
	
	    /**
	     * Report a comment
	     * @param nCommentId
	     */
	    reportComment: function(nCommentId)
	    {
	        // call
	        MimotoX.utils.callAPI({
	            type: 'post',
	            url: "/publisher/comment/" + nCommentId + "/remove",
	            data: {message: commentForm.value},
	            dataType: 'json',
	            success: function(resultData, resultStatus, resultSomething) {
	                console.log('Comment reported');
	            }
	        });
	    },
	
	    /**
	     * Highlight comment
	     * @param nCommentId
	     */
	    highlightComment: function(nCommentId)
	    {
	        // call
	        MimotoX.utils.callAPI({
	            type: 'post',
	            url: "/publisher/comment/" + nCommentId + "/highlight",
	            data: null,
	            dataType: 'json',
	            success: function(resultData, resultStatus, resultSomething) {
	                console.log('Comment highlighted');
	            }
	        });
	    },
	
	    /**
	     * Unhighlight comment
	     * @param nCommentId
	     */
	    unhighlightComment: function(nCommentId)
	    {
	        // call
	        MimotoX.utils.callAPI({
	            type: 'post',
	            url: "/publisher/comment/" + nCommentId + "/unhighlight",
	            data: null,
	            dataType: 'json',
	            success: function(resultData, resultStatus, resultSomething) {
	                console.log('Comment unhighlighted');
	            }
	        });
	    }
	
	};


/***/ },

/***/ 118:
/***/ function(module, exports) {

	/**
	 * Mimoto.Publisher - Demo - How to build a publication platform
	 *
	 * @author Sebastian Kersten (@supertaboo)
	 */
	
	
	'use strict';
	
	
	
	module.exports = function() {
	
	
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
	    __construct: function()
	    {
	
	    },
	
	
	
	    // ----------------------------------------------------------------------------
	    // --- Public methods ---------------------------------------------------------
	    // ----------------------------------------------------------------------------
	
	
	    onInfocardAdd: function(NodeConfig)
	    {
	        console.log('Hi! from custom publisher onAdd function');
	
	        // 1. check if id is set
	        // 2. call popup, or
	        // 3. create comment
	
	        //let my_blot = Parchment.find(NodeConfig.node);
	
	
	        //let popup = MimotoX.popup('/Mimoto.Aimless/form/infocard');
	    },
	
	    onInfocardEdit: function(NodeConfig)
	    {
	        console.log('Hi! from custom publisher onEdit function');
	
	        // 1. check if id is set
	        // 2. call popup, or
	        // 3. create comment
	
	        let popup = MimotoX.popup('/Mimoto.Aimless/form/infocard');
	
	        // 4. delete formatting options (als mogelijke feedback van popup)
	        // 5. onInit (wanneer het op de dom geplaatst worden vanuit een saved state
	    }
	
	};


/***/ }

/******/ });
//# sourceMappingURL=publisher.js.map