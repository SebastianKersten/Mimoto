'use strict';

var Observer = require('./utils/Observer');
var mergeObjects = require('./utils/mergeObjects');

exports.init = function (options) {
	// console.log('exports.init: ', options);

	if (options) {
		this.setOptions(options);
	}

	return _moduleLoader.parse(window.document);

};

exports.setOptions = function (options) {

	// console.log('setOptins', options);

	// @ifdef DEV
	if (!options) {
		throw new Error('Conditioner.setOptions(options): "options" is a required parameter.');
	}
	// @endif
	var config;
	var path;
	var mod;
	var alias;
	var enabled;

	// update options
	var _options = mergeObjects(_options, options);

	// fix paths if not ending with slash
	for (path in _options.paths) {

		/* istanbul ignore next */
		if (!_options.paths.hasOwnProperty(path)) {
			continue;
		}

		// add slash if path does not end on slash already
		_options.paths[path] += _options.paths[path].slice(-1) !== '/' ? '/' : '';
	}

	// loop over modules
	for (path in _options.modules) {

		/* istanbul ignore next */
		if (!_options.modules.hasOwnProperty(path)) {
			continue;
		}

		// get module reference
		mod = _options.modules[path];

		// get alias
		alias = typeof mod === 'string' ? mod : mod.alias;

		// get config
		config = typeof mod === 'string' ? null : mod.options || {};

		// get result of requirements
		enabled = typeof mod === 'string' ? null : mod.enabled;

		// register this module
		ModuleRegistry.registerModule(path, config, alias, enabled);

	}

};

var // conditioner options object
	_options = {
		'paths': {
			'monitors': './monitors/'
		},
		'attr': {
			'options': 'data-options',
			'module': 'data-module',
			'conditions': 'data-conditions',
			'priority': 'data-priority',
			'initialized': 'data-initialized',
			'processed': 'data-processed',
			'loading': 'data-loading'
		},
		'modules': {}
	};


/**
 * @exports ModuleLoader
 * @class
 * @constructor
 */
var ModuleLoader = function ModuleLoader() {

	// array of all parsed nodes
	this._nodes = [];

};

var _jsonRegExp = new RegExp('^\\[\\s*{', 'gm');

ModuleLoader.prototype = {

	/**
	 * Loads all modules within the supplied dom tree
	 * @param {Document|Element} context - Context to find modules in
	 * @return {Array} - Array of found Nodes
	 */
	parse: function (context) {

		// @ifdef DEV
		if (!context) {
			throw new Error('ModuleLoader.loadModules(context): "context" is a required parameter.');
		}
		// @endif
		// register vars and get elements
		var elements = context.querySelectorAll('[data-module]');
		var l = elements.length;
		var i = 0;
		var nodes = [];
		var node;
		var element;

		// if no elements do nothing
		if (!elements) {
			return [];
		}

		// process elements
		for (; i < l; i++) {

			// set element reference
			element = elements[i];

			// test if already processed
			if (NodeController.hasProcessed(element)) {
				continue;
			}

			// create new node
			nodes.push(new NodeController(element, element.getAttribute(_options.attr.priority)));
		}

		// sort nodes by priority:
		// higher numbers go first,
		// then 0 (a.k.a. no priority assigned),
		// then negative numbers
		// note: it's actually the other way around but that's because of the reversed while loop coming next
		nodes.sort(function (a, b) {
			return a.getPriority() - b.getPriority();
		});

		// initialize modules depending on assigned priority (in reverse, but priority is reversed as well so all is okay)
		i = nodes.length;
		while (--i >= 0) {
			node = nodes[i];
			node.load.call(node, this._getModuleControllersByElement(node.getElement()));
		}

		// merge new nodes with currently active nodes list
		this._nodes = this._nodes.concat(nodes);

		// returns nodes so it is possible to later unload nodes manually if necessary
		return nodes;
	},

	/**
	 * Setup the given element with the passed module controller(s)
	 * [
	 *     {
		 *         path: 'path/to/module',
		 *         conditions: 'config',
		 *         options: {
		 *             foo: 'bar'
		 *         }
		 *     }
	 * ]
	 * @param {Element} element - Element to bind the controllers to
	 * @param {Array|Object} controllers - ModuleController configurations
	 * @return {NodeController|null} - The newly created node or null if something went wrong
	 */
	load: function (element, controllers) {

		// @ifdef DEV
		if (!controllers) {
			throw new Error('ModuleLoader.load(element,controllers): "controllers" is a required parameter.');
		}
		// @endif
		// if controllers is object put in array
		controllers = controllers.length ? controllers : [controllers];

		// vars
		var i = 0;
		var l = controllers.length;
		var moduleControllers = [];
		var controller;
		var node;

		// create node
		node = new NodeController(element);

		// create controllers
		for (; i < l; i++) {
			controller = controllers[i];
			moduleControllers.push(
				this._getModuleController(controller.path, element, controller.options, controller.conditions));
		}

		// create initialize
		node.load(moduleControllers);

		// remember so can later be retrieved through getNode methodes
		this._nodes.push(node);

		// return the loaded Node
		return node;
	},


	/**
	 * Destroy the passed node reference
	 * @param {Array} nodes
	 * @return {Boolean}
	 * @public
	 */
	destroy: function (nodes) {

		var i = nodes.length;
		var destroyed = 0;
		var hit;

		while (i--) {

			hit = this._nodes.indexOf(nodes[i]);
			if (hit === -1) {
				continue;
			}

			this._nodes.splice(hit, 1);
			nodes[i].destroy();
			destroyed++;

		}

		return nodes.length === destroyed;
	},

	/**
	 * Parses module controller configuration on element and returns array of module controllers
	 * @param {Element} element
	 * @returns {Array}
	 * @private
	 */
	_getModuleControllersByElement: function (element) {

		var config = element.getAttribute(_options.attr.module) || '';

		// test if first character is a '[', if so multiple modules have been defined
		// double comparison is faster than triple in this case
		if (config.charCodeAt(0) == 91) {

			var controllers = [];
			var i = 0;
			var l;
			var specs;
			var spec;

			// add multiple module adapters
			try {
				specs = JSON.parse(config);
			}
			catch (e) {
				// @ifdef DEV
				throw new Error('ModuleLoader.load(context): "data-module" attribute contains a malformed JSON string.');
				// @endif
			}

			// no specification found or specification parsing failed
			if (!specs) {
				return [];
			}

			// setup vars
			l = specs.length;

			// test if is json format
			if (_jsonRegExp.test(config)) {
				for (; i < l; i++) {
					spec = specs[i];

					if (!ModuleRegistry.isModuleEnabled(spec.path)) {
						continue;
					}

					controllers[i] = this._getModuleController(
						spec.path, element, spec.options, spec.conditions);
				}
				return controllers;
			}

			// expect array format
			for (; i < l; i++) {
				spec = specs[i];

				if (!ModuleRegistry.isModuleEnabled(typeof spec == 'string' ? spec : spec[0])) {
					continue;
				}

				if (typeof spec == 'string') {
					controllers[i] = this._getModuleController(spec, element);
				}
				else {
					controllers[i] = this._getModuleController(
						spec[0], element, typeof spec[1] == 'string' ? spec[2] : spec[1], typeof spec[1] == 'string' ? spec[1] : spec[2]);
				}
			}
			return controllers;

		}

		// no support, no module
		if (!ModuleRegistry.isModuleEnabled(config)) {
			return null;
		}

		// support, so let's get the module controller
		return [this._getModuleController(
			config, element, element.getAttribute(_options.attr.options), element.getAttribute(_options.attr.conditions))];
	},

	/**
	 * Module Controller factory method, creates different ModuleControllers based on params
	 * @param path - path of module
	 * @param element - element to attach module to
	 * @param options - options for module
	 * @param conditions - conditions required for module to be loaded
	 * @returns {ModuleController}
	 * @private
	 */
	_getModuleController: function (path, element, options, conditions) {
		return new ModuleController(
			path, element, options, conditions );
	}
};


var NodeController = (function () {

	var _filterIsActiveModule = function (item) {
		return item.isModuleActive();
	};
	var _filterIsAvailableModule = function (item) {
		return item.isModuleAvailable();
	};
	var _mapModuleToPath = function (item) {
		return item.getModulePath();
	};

	/***
	 * For each element found having a `data-module` attribute an object of type NodeController is made. The node object can then be queried for the [ModuleControllers](#modulecontroller) it contains.
	 *
	 * @exports NodeController
	 * @class
	 * @constructor
	 * @param {Object} element
	 * @param {Number} priority
	 */
	var exports = function NodeController(element, priority) {

		// @ifdef DEV
		if (!element) {
			throw new Error('NodeController(element): "element" is a required parameter.');
		}
		// @endif
		// set element reference
		this._element = element;

		// has been processed
		this._element.setAttribute(_options.attr.processed, 'true');

		// set priority
		this._priority = !priority ? 0 : parseInt(priority, 10);

		// contains references to all module controllers
		this._moduleControllers = [];

		// binds
		this._moduleAvailableBind = this._onModuleAvailable.bind(this);
		this._moduleLoadBind = this._onModuleLoad.bind(this);
		this._moduleUnloadBind = this._onModuleUnload.bind(this);

	};

	/**
	 * Static method testing if the current element has been processed already
	 * @param {Element} element
	 * @static
	 */
	exports.hasProcessed = function (element) {
		return element.getAttribute(_options.attr.processed) === 'true';
	};

	exports.prototype = {

		/**
		 * Loads the passed ModuleControllers to the node
		 * @param {Array} moduleControllers
		 * @public
		 */
		load: function (moduleControllers) {

			// if no module controllers found, fail silently
			if (!moduleControllers || !moduleControllers.length) {
				return;
			}

			// turn into array
			this._moduleControllers = moduleControllers;

			// listen to load events on module controllers
			var i = 0;
			var l = this._moduleControllers.length;
			var mc;

			for (; i < l; i++) {
				mc = this._moduleControllers[i];
				Observer.subscribe(mc, 'available', this._moduleAvailableBind);
				Observer.subscribe(mc, 'load', this._moduleLoadBind);
			}

		},


		/**
		 * Returns the set priority for this node
		 * @public
		 */
		getPriority: function () {
			return this._priority;
		},

		/***
		 * Returns the element linked to this node
		 *
		 * @method getElement
		 * @memberof NodeController
		 * @returns {Element} element - A reference to the element wrapped by this NodeController
		 * @public
		 */
		getElement: function () {
			return this._element;
		},

		/***
		 * Returns true if all [ModuleControllers](#modulecontroller) are active
		 *
		 * @method areAllModulesActive
		 * @memberof NodeController
		 * @returns {Boolean} state - All modules loaded state
		 * @public
		 */
		areAllModulesActive: function () {
			return this.getActiveModules().length === this._moduleControllers.length;
		},

		/***
		 * Returns an array containing all active [ModuleControllers](#modulecontroller)
		 *
		 * @method getActiveModules
		 * @memberof NodeController
		 * @returns {Array} modules - An Array of active ModuleControllers
		 * @public
		 */
		getActiveModules: function () {
			return this._moduleControllers.filter(_filterIsActiveModule);
		},

		/***
		 * Returns the first [ModuleController](#modulecontroller) matching the given path
		 *
		 * @method getModule
		 * @memberof NodeController
		 * @param {String=} path - The module id to search for.
		 * @returns {(ModuleController|null)} module - A [ModuleController](#modulecontroller) or null if none found
		 * @public
		 */
		getModule: function (path) {
			return this._getModules(path, true);
		},

		/**
		 * Called when a module becomes available for load
		 * @param moduleController
		 * @private
		 */
		_onModuleAvailable: function (moduleController) {

			// propagate events from the module controller to the node so people can subscribe to events on the node
			Observer.inform(moduleController, this);

			// update loading attribute with currently loading module controllers list
			this._updateAttribute(_options.attr.loading, this._moduleControllers.filter(_filterIsAvailableModule));
		},

		/**
		 * Called when module has loaded
		 * @param moduleController
		 * @private
		 */
		_onModuleLoad: function (moduleController) {

			// listen to unload event
			Observer.unsubscribe(moduleController, 'load', this._moduleLoadBind);
			Observer.subscribe(moduleController, 'unload', this._moduleUnloadBind);

			// update loading attribute with currently loading module controllers list
			this._updateAttribute(_options.attr.loading, this._moduleControllers.filter(_filterIsAvailableModule));

			// update initialized attribute with currently active module controllers list
			this._updateAttribute(_options.attr.initialized, this.getActiveModules());
		},

		/**
		 * Called when module has unloaded
		 * @param moduleController
		 * @private
		 */
		_onModuleUnload: function (moduleController) {

			// stop listening to unload
			Observer.subscribe(moduleController, 'load', this._moduleLoadBind);
			Observer.unsubscribe(moduleController, 'unload', this._moduleUnloadBind);

			// conceal events from module controller
			Observer.conceal(moduleController, this);

			// update initialized attribute with now active module controllers list
			this._updateAttribute(_options.attr.initialized, this.getActiveModules());

		},

		/**
		 * Updates the given attribute with paths of the supplied controllers
		 * @private
		 */
		_updateAttribute: function (attr, controllers) {

			var modules = controllers.map(_mapModuleToPath);
			if (modules.length) {
				this._element.setAttribute(attr, modules.join(','));
			}
			else {
				this._element.removeAttribute(attr);
			}

		}

	};

	return exports;

}());


/**
 * Static Module Agent, will always load the module
 * @type {Object}
 */
var StaticModuleAgent = {

	/**
	 * Initialize, resolved immediately
	 * @returns {Promise}
	 */
	init: function (ready) {
		ready();
	},

	/**
	 * Is activation currently allowed, will always return true for static module agent
	 * @returns {boolean}
	 */
	allowsActivation: function () {
		return true;
	},

	/**
	 * Clean up
	 * As we have not attached any event listeners there's nothing to clean
	 */
	destroy: function () {
	}

};


var ModuleRegistry = {

	_options: {},
	_redirects: {},
	_enabled: {},

	/**
	 * Register a module
	 * @param {String} path - path to module
	 * @param {Object} options - configuration to setup for module
	 * @param {String} alias - alias name for module
	 * @param {Boolean} enabled - true/false if the module is enabled, null if -don't care-
	 * @static
	 */
	registerModule: function (path, options, alias, enabled) {

		// remember options for absolute path
		this._options[path] = options;

		// remember if module is supported
		this._enabled[path] = enabled;

		// setup redirect from alias
		if (alias) {
			this._redirects[alias] = path;
		}

		// pass configuration to loader
		_options.loader.config(path, options);
	},

	/**
	 * Returns if the given module is enabled
	 * @param {String} path - path to module
	 * @static
	 */
	isModuleEnabled: function (path) {
		return this._enabled[path] !== false;
	},

	/**
	 * Returns the actual path if the path turns out to be a redirect
	 * @param path
	 * @returns {*}
	 */
	getRedirect: function (path) {
		return this._redirects[path] || path;
	},

	/**
	 * Get a registered module by path
	 * @param {String} path - path to module
	 * @return {Object} - module specification object
	 * @static
	 */
	getModule: function (path) {

		// @ifdef DEV
		// if no id supplied throw error
		if (!path) {
			throw new Error('ModuleRegistry.getModule(path): "path" is a required parameter.');
		}
		// @endif
		return this._options[path];

	}

};
/***
 * The ModuleController loads and unloads the contained Module based on the conditions received. It propagates events from the contained Module so you can safely subscribe to them.
 *
 * @exports ModuleController
 * @class
 * @constructor
 * @param {String} path - reference to module
 * @param {Element} element - reference to element
 * @param {(Object|String)=} options - options for this ModuleController
 * @param {Object=} agent - module activation agent
 */
var ModuleController = function ModuleController(path, element, options, agent) {

	// @ifdef DEV
	// if no path supplied, throw error
	if (!path || !element) {
		throw new Error('ModuleController(path,element,options,agent): "path" and "element" are required parameters.');
	}
	// @endif
	// path to module
	this._path = ModuleRegistry.getRedirect(path);
	this._alias = path;

	// reference to element
	this._element = element;

	// options for module controller
	this._options = options;

	// set loader
	this._agent = agent || StaticModuleAgent;

	// module definition reference
	this._Module = null;

	// module instance reference
	this._module = null;

	// default init state
	this._initialized = false;

	// agent binds
	this._onAgentStateChangeBind = this._onAgentStateChange.bind(this);

	// wait for init to complete
	var self = this;
	this._agent.init(function () {
		self._initialize();
	});

};

ModuleController.prototype = {

	/**
	 * returns true if the module controller has initialized
	 * @returns {Boolean}
	 */
	hasInitialized: function () {
		return this._initialized;
	},

	/**
	 * Returns the element this module is attached to
	 * @returns {Element}
	 */
	getElement: function () {
		return this._element;
	},

	/***
	 * Returns the module path
	 *
	 * @method getModulePath
	 * @memberof ModuleController
	 * @returns {String}
	 * @public
	 */
	getModulePath: function () {
		return this._path;
	},

	/***
	 * Returns true if the module is currently waiting for load
	 *
	 * @method isModuleAvailable
	 * @memberof ModuleController
	 * @returns {Boolean}
	 * @public
	 */
	isModuleAvailable: function () {
		return this._agent.allowsActivation() && !this._module;
	},

	/***
	 * Returns true if module is currently active and loaded
	 *
	 * @method isModuleActive
	 * @memberof ModuleController
	 * @returns {Boolean}
	 * @public
	 */
	isModuleActive: function () {
		return this._module !== null;
	},

	/***
	 * Checks if it wraps a module with the supplied path
	 *
	 * @method wrapsModuleWithPath
	 * @memberof ModuleController
	 * @param {String} path - Path of module to test for.
	 * @return {Boolean}
	 * @public
	 */
	wrapsModuleWithPath: function (path) {
		return this._path === path || this._alias === path;
	},

	/**
	 * Called to initialize the module
	 * @private
	 * @fires init
	 */
	_initialize: function () {

		// now in initialized state
		this._initialized = true;

		// listen to behavior changes
		Observer.subscribe(this._agent, 'change', this._onAgentStateChangeBind);

		// let others know we have initialized
		Observer.publishAsync(this, 'init', this);

		// if activation is allowed, we are directly available
		if (this._agent.allowsActivation()) {
			this._onBecameAvailable();
		}

	},

	/**
	 * Called when the module became available, this is when it's suitable for load
	 * @private
	 * @fires available
	 */
	_onBecameAvailable: function () {

		// we are now available
		Observer.publishAsync(this, 'available', this);

		// let's load the module
		this._load();

	},

	/**
	 * Called when the agent state changes
	 * @private
	 */
	_onAgentStateChange: function () {

		// check if module is available
		var shouldLoadModule = this._agent.allowsActivation();

		// determine what action to take basted on availability of module
		if (this._module && !shouldLoadModule) {
			this._unload();
		}
		else if (!this._module && shouldLoadModule) {
			this._onBecameAvailable();
		}

	},

	/**
	 * Load the module contained in this ModuleController
	 * @public
	 */
	_load: function () {

		// if module available no need to require it
		if (this._Module) {
			this._onLoad();
			return;
		}

		// load module, and remember reference
		var self = this;

		// @todo check if this is enough for now
		var Module = require('../'+this._path);

		// @ifdef DEV
		// if module does not export a module quit here
		if (!Module) {
			throw new Error('ModuleController: A module needs to export an object.');
		}

		// set reference to Module
		self._Module = Module;

		// module is now ready to be loaded
		self._onLoad();

	},

	_applyOverrides: function (options, overrides) {

		// test if object is string
		if (typeof overrides === 'string') {

			// test if overrides is JSON string (is first char a '{'
			if (overrides.charCodeAt(0) == 123) {

				// @ifdef DEV
				try {
					// @endif
					overrides = JSON.parse(overrides);
					// @ifdef DEV
				}
				catch (e) {
					throw new Error('ModuleController.load(): "options" is not a valid JSON string.');
				}
				// @endif
			}
			else {

				// no JSON object, must be options string
				var i = 0;
				var opts = overrides.split(', ');
				var l = opts.length;

				for (; i < l; i++) {
					this._overrideObjectWithUri(options, opts[i]);
				}

				return options;
			}

		}

		// directly merge objects
		return mergeObjects(options, overrides);
	},


	/**
	 * Parses options for given url and module also
	 * @param {String} url - url to module
	 * @param {Object} Module - Module definition
	 * @param {(Object|String)} overrides - page level options to override default options with
	 * @returns {Object}
	 * @private
	 */
	_parseOptions: function (url, Module, overrides) {

		var stack = [];
		var pageOptions = {};
		var moduleOptions = {};
		var options;
		var i;

		do {

			// get settings
			options = ModuleRegistry.getModule(url);

			// create a stack of options
			stack.push({
				'page': options,
				'module': Module.options
			});

			// fetch super path, if this module has a super module load that modules options aswell
			url = Module.__superUrl;

			// jshint -W084
		} while (Module = Module.__super);

		// reverse loop over stack and merge all entries to create the final options objects
		i = stack.length;
		while (i--) {
			pageOptions = mergeObjects(pageOptions, stack[i].page);
			moduleOptions = mergeObjects(moduleOptions, stack[i].module);
		}

		// merge page and module options
		options = mergeObjects(moduleOptions, pageOptions);

		// apply overrides
		if (overrides) {
			options = this._applyOverrides(options, overrides);
		}

		return options;
	},

	/**
	 * Method called when module loaded
	 * @fires load
	 * @private
	 */
	_onLoad: function () {

		// if activation is no longer allowed, stop here
		if (!this._agent.allowsActivation()) {
			return;
		}

		// parse and merge options for this module
		var options = this._parseOptions(this._path, this._Module, this._options);

		// set reference
		if (typeof this._Module === 'function') {

			// is of function type so try to create instance
			this._module = new this._Module(this._element, options);
		}
		else {

			// is of other type, expect load method to be defined
			this._module = this._Module.load ? this._Module.load(this._element, options) : null;

			// if module not defined we are probably dealing with a static class
			if (!this._module) {
				this._module = this._Module;
			}
		}

		// @ifdef DEV
		// if no module defined throw error
		if (!this._module) {
			throw new Error('ModuleController.load(): could not initialize module, missing constructor or "load" method.');
		}
		// @endif
		// watch for events on target
		// this way it is possible to listen for events on the controller which will always be there
		Observer.inform(this._module, this);

		// publish load event
		Observer.publishAsync(this, 'load', this);
	},

	/**
	 * Unloads the wrapped module
	 * @fires unload
	 * @return {Boolean}
	 */
	_unload: function () {

		// if no module, module has already been unloaded or was never loaded
		if (!this._module) {
			return false;
		}

		// stop watching target
		Observer.conceal(this._module, this);

		// unload module if possible
		if (this._module.unload) {
			this._module.unload();
		}

		// reset reference to instance
		this._module = null;

		// publish unload event
		Observer.publish(this, 'unload', this);

		return true;
	},

	/**
	 * Cleans up the module and module controller and all bound events
	 * @public
	 */
	destroy: function () {

		// unbind events
		Observer.unsubscribe(this._agent, 'change', this._onAgentStateChangeBind);

		// unload module
		this._unload();

		// call destroy agent
		this._agent.destroy();

		// agent binds
		this._onAgentStateChangeBind = null;
	},

	/***
	 * Executes a methods on the wrapped module.
	 *
	 * @method execute
	 * @memberof ModuleController
	 * @param {String} method - Method name.
	 * @param {Array=} params - Array containing the method parameters.
	 * @return {Object} response - containing return of executed method and a status code
	 * @public
	 */
	execute: function (method, params) {

		// if module not loaded
		if (!this._module) {
			return {
				'status': 404,
				'response': null
			};
		}

		// get function reference
		var F = this._module[method];

		// @ifdef DEV
		if (!F) {
			throw new Error('ModuleController.execute(method,params): function specified in "method" not found on module.');
		}
		// @endif
		// if no params supplied set to empty array,
		// ie8 falls to it's knees when it receives an undefined parameter object in the apply method
		params = params || [];

		// once loaded call method and pass parameters
		return {
			'status': 200,
			'response': F.apply(this._module, params)
		};

	}

};


var _moduleLoader = new ModuleLoader();
