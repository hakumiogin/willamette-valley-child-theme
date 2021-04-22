
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
  test: /\.css$/,
  use: [
    {
      loader: MiniCssExtractPlugin.loader,
      options: {
        // publicPath: '/public/path/to/',
      },
    },
    'css-loader'
  ]
}
