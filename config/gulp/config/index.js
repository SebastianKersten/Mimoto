var config = {};

config.proxy = 'http://mimoto.aimless';
config.dest = 'web/static';
config.src = './';

config.projectSrc = 'src/userinterface/MimotoCMS';
config.templates = config.projectSrc + '/**/*.twig';

module.exports = config;
