var config = {};

config.proxy = 'http://mimoto.aimless';
config.dest = 'web/static';
config.src = './';

config.projectSrc = 'src/userinterface/components';
config.templates = config.projectSrc + '/**';

module.exports = config;
