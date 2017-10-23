import Vue from 'vue'
import Router from 'vue-router'


Vue.use(Router)

const router = new Router({
  routes:[{
    path:'/index',component:require('../pages/index')
  },{
    path:'*',redirect:'/index'
  }]
});

export default router;
