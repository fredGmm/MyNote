// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import * as api from './store/api'
import 'lib-flexible'
import FastClick from 'fastclick'
window.FastClick = FastClick
import Swiper from 'swiper'
import 'swiper/dist/css/swiper.min.css';
window.Swiper = Swiper

//Vue.use(Swiper)

/*import filters from './utils/filter'
Object.keys(filters).forEach((k) => Vue.filter(k, filters[k]))*/

var app=new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App },
})


