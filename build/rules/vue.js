const autoprefixer = require('autoprefixer')

const config = require('../app.config')

/**
 * Internal application Vue files. Supports `.vue` component format.
 * Rule is configured for `<style lang="sass/scss">` styles section.
 */
module.exports = {
  test: /\.vue$/,
  loader: 'vue-loader',
  options: {

    loaders: {
      //scss: 'vue-style-loader!css-loader!sass-loader',
      scss: [
        {
          loader: 'vue-style-loader',
        },
        {
          loader: 'css-loader'
        },
        {
          loader: 'sass-loader',
          options: {
            sourceMap: true,
            data: '@import "./resources/assets/sass/partials/_variables.scss";'
          }
        },
      ],
      sass: [
        {
          loader: 'vue-style-loader',
        },
        {
          loader: 'css-loader'
        },
        {
          loader: 'sass-loader?indentedSyntax',
          options: {
            sourceMap: true,
            data: '@import "./resources/assets/sass/partials/_variables.scss";'
          }
        },
      ],
    },
    postcss: [autoprefixer(config.settings.autoprefixer)],
    autoprefixer: true,
  }
}
