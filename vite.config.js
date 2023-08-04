export default {
  build: {
    rollupOptions: {
      input: {
        theme: 'resources/css/theme.css',
      },
      output: {
        assetFileNames: `css/[name].[ext]`,
      },
    },
  },
};
