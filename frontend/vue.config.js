const sourceMaps = true;

module.exports = {
  css: {
    sourceMap: sourceMaps
    //   extract: false,
  },

  outputDir: '../nillkizz-appointment/public/app',
  publicPath: process.env.NODE_ENV === 'production'
    ? '/wp-content/plugins/nillkizz-appointment/public/app/'
    : '/',

  runtimeCompiler: true,
  productionSourceMap: sourceMaps,

  pluginOptions: {
    quasar: {
      importStrategy: "kebab",
      rtlSupport: false,
    },
  },

  transpileDependencies: ["quasar"],
};
