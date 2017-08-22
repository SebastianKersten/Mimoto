function buildConfig(env) {
    var target;

    for (var i = 0; i < process.argv.length; i++) {
        if (process.argv[i].indexOf('--target=') !== -1) {
            target = process.argv[i].substring('--target='.length)
        }
    }

    return require('./config/' + target + '/' + env + '.js')(env)
}

module.exports = buildConfig;
