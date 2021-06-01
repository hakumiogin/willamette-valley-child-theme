const config               = require("../app.config");

const isdev                = require("isdev");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

/**
 * Internal application SASS files.
 */
function prependData(){
  return [
    '@import "'+config.paths.sass+'/partials/_variables.scss";',
    '@import "'+config.paths.sass+'/partials/_mixins.scss";'
  ].join('')
}

module.exports = {
  test: /\.(?<x>sa|sc|c)ss$/,
  include: [config.paths.sass, config.paths.javascript],
  use: [
    // "vue-style-loader",
    {
      loader: MiniCssExtractPlugin.loader,
      // options: {
      //   hmr: isdev,
      // },
    },
    {
      loader: "css-loader?url=false",
      options: {
        sourceMap: isdev,
        importLoaders: 1 
      }
    },
    {
      loader: "postcss-loader",
      options: {
        sourceMap: isdev,
        plugins: () => {
          if(isdev){
            const autoprefixer = require("autoprefixer");
            return [ autoprefixer( config.settings.autoprefixer ) ]
          }
          return [] 
        }
      }
    },
    {
      loader: "sass-loader?url=false",
      options: {
        sourceMap: isdev,
        data: prependData()
      }
    }
  ]
};
