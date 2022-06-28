import Vue from 'vue';
import ApiClient from "./service/ApiClient";
import VueMask from 'v-mask'
Vue.use(VueMask);

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

const apiClient = new ApiClient();

window.onload = () => {
  new Vue({
    provide: {apiClient},
  }).$mount('#app-configurator');
}
