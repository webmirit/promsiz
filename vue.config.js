const { defineConfig } = require('@vue/cli-service');

module.exports = defineConfig({
  transpileDependencies: true,
  runtimeCompiler: true,
  pages: {
    main: {
      entry: "local/templates/aspro_next/src/main.js",
      template: "local/templates/aspro_next/src/main.html",
      inject: false
    }
  },
  outputDir: "local/templates/aspro_next/build",
  publicPath: "/local/templates/aspro_next/build",
  filenameHashing: false,
  css: {
    extract: true
  },
})
