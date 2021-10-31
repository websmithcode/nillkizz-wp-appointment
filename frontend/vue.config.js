const webpack = require("webpack");
module.exports = {
  // css: {
  //   extract: false,
  // },
  assetsDir: 'wp-content/plugins/nillkizz-appointment/public/app/',
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

  pluginOptions: {
    quasar: {
      importStrategy: "kebab",
      rtlSupport: false,
    },
  },

  transpileDependencies: ["quasar"],
};
