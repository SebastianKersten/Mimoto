var config = {};

config.proxy = 'http://mimoto.aimless';
config.dest = '../web/static';
config.src = './';

config.projectSrc = '../src/userinterface/templates';
config.templates = config.projectSrc + '/**';

module.exports = config;
