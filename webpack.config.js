function buildConfig(env) {
    const target = process.argv[3].substring('--target='.length);
    return require('./config/' + target + '/' + env + '.js')(env)
}

module.exports = buildConfig;
