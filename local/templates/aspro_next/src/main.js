import Vue from 'vue'

Vue.config.productionTip = false;

const files = require.context("./", true, /\.vue$/i);
files.keys().map(key =>
  Vue.component(
    key
      .split("/")
      .pop()
      .split(".")[0],
    files(key).default
  )
);

window.onload = () => {
  new Vue({}).$mount('#app-configurator');
}
