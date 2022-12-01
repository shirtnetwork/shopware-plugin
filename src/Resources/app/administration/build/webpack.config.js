const { join, resolve } = require('path');
module.exports = () => {
  return {
    resolve: {
      alias: {
        '@socket.io-client': resolve(
          join(__dirname, '..', 'node_modules', 'socket.io-client')
        )
      }
    }
  };
}