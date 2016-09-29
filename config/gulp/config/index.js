var config = {};

config.proxy = 'http://mimoto.aimless';
config.dest = 'web/static';
config.src = './';

config.projectSrc = 'src/userinterface/components/Mimoto.CMS';
config.templates = config.projectSrc + '/**';

module.exports = config;
