const config = require("../app.config");

/**
 * Internal application javascript files.
 * Supports ES6 by compiling scripts with Babel.
 */
module.exports = {
  test: /\.js$/,
  include: [config.paths.javascript, config.paths.views],
  loader: [
    {
      loader: "babel-loader",
      query: {
        presets: ['@babel/preset-env', '@babel/preset-react']
      },
    }, "eslint-loader"
  ],
};