module.exports = {
  plugins: [
    // Plugin kecil untuk menghapus at-rule `@property` saat build
    // (menghindari peringatan dari optimizer CSS seperti esbuild)
    function removePropertyAtRule() {
      return {
        postcssPlugin: 'remove-property-at-rule',
        AtRule: {
          property(rule) {
            // hapus rule @property sepenuhnya
            rule.remove();
          }
        }
      };
    }
  ]
};

module.exports.postcss = true;
