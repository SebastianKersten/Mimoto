var config = require('./');

module.exports = {

  proxy: config.proxy,
  xip: true,
  open: false,
  notify: true,

  ghostMode: {
    clicks: false,
    forms: false,
    scroll: false
  }

};
