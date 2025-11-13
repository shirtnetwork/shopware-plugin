const { join, resolve } = require('path');
module.exports = () => {
  return {
    resolve: {
      modules: [
        `${params.basePath}/Resources/app/administration/node_modules`,
      ]
    }
  };
}