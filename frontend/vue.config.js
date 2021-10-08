const webpack = require('webpack');
module.exports = {
  css: {
    extract: false
  },
  filenameHashing: false,
  configureWebpack: {
    plugins: [
      new webpack.optimize.LimitChunkCountPlugin({
        maxChunks: 1,
      }),
    ],
  },
  runtimeCompiler: true,
  productionSourceMap: false,
}

