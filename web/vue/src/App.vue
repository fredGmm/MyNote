<template>
  <div id="app" >
    <div class='header'>
      <div class='wrapper'>
          <div class='header-top'>
            <div class='top-menu left'>
              <span>您好，欢迎访问本站!</span>
              <a href='javascript:;'><i></i>登录</a>
            </div>
          <div class='top-menu right'>
            <div>
                <router-link :to="{path:'index'}">苹果</router-link>
                <router-link :to="{path:'index'}">香蕉</router-link>
                <router-link :to="{path:'index'}">猕猴桃</router-link>
                <router-link :to="{path:'index'}">葡萄</router-link>
                <router-link :to="{path:'index'}"><i></i>水果购入</router-link>
            </div> 
          </div>
        </div>
        <div class='header-bottom'>
            <div class='img-c left'>
                <router-link :to="{path:'index'}">
                    <img src="./assets/images/juzi_logo2.jpg" alt="桔子吃饭"> 
                </router-link>
            </div>
            <div class='header-menu right'>
                <ul class='menu'>
                    <li><a href="javascript:;">首页</a></li>
                    <li class='menu-item-has-children' @click="menushow()">
                        <a href="javascript:;">博客</a>
                        <ul class='sub-menu' :class="{'show':mshow}">
                           <li><a href="javascript:;">纪录片</a></li>
                           <li><a href="javascript:;">动画短片</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:;">水果</a></li>
                    <li><a href="javascript:;">蔬菜</a></li>
                    <li><a href="javascript:;">肉类</a></li>
                    <li><a href="javascript:;">爬虫趣事</a></li>
                    <li><a href="javascript:;">关于</a></li>
                </ul>
            </div>
        </div>
      </div>
    </div>
    <section class="app-main">
      <router-view></router-view>
    </section>
  </div>
</template>

<script>
export default {
  name: 'app',
  components:{
  },
  data() {
    return {
        mshow:false,
    }
  },
  created:function(){

  },
  events:{

  },
  methods:{
      menushow(){
          var self = this;
          self.mshow = !self.mshow;
      }
  }
}
</script>

<style>

@import './assets/css/reset.css';
@import './assets/css/base.css';
@import './assets/css/header.css';


element.style {
}

body {
    background-color: #f8f8f8;
    background-repeat: repeat;
    background-size: inherit;
    background-attachment: fixed;
    background-position: center center;
    background-image: url(https://yfdxs.com/wp-content/themes/lensnews/images/body.png);
}
body {
    font: 12px Arial,"微软雅黑";
    overflow-x: hidden;
    overflow-y: scroll;
    line-height: 24px;
    color: #666;
}

</style>
