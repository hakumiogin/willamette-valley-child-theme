const config = require('../app.config')

/**
 * Internal application font files. Rule test regrex additionaly
 * matches fonts with version string at the end of filenames.
 */
module.exports = {
  test: /\.(?<ext>eot|ttf|woff|woff2|svg|otf)(?<x>\?\S*)?$/,
  include: config.paths.fonts,
  loader: 'file-loader',
  options: {
    publicPath: config.paths.relative,
    name: config.outputs.font.filename,
  }

}
