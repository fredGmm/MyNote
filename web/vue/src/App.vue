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
                <router-link :to="{path:'index'}">地图</router-link>
                <router-link :to="{path:'index'}">标签</router-link>
                <router-link :to="{path:'index'}">链接</router-link>
                <router-link :to="{path:'index'}">留言</router-link>
                <router-link :to="{path:'index'}"><i></i>主题购买</router-link>
            </div> 
          </div>
        </div>
        <div class='header-bottom'>
            <div class='img-c left'>
                <router-link :to="{path:'index'}">
                    <img src="https://yfdxs.com/wp-content/themes/lensnews/images/logo.jpg" alt="远方的雪山"> 
                </router-link>
            </div>
            <div class='header-menu right'>
                <ul class='menu'>
                    <li><a href="javascript:;">首页</a></li>
                    <li class='menu-item-has-children'>
                        <a href="javascript:;">博客</a>
                        <ul class='sub-menu'>
                           <li><a href="javascript:;">纪录片</a></li>
                           <li><a href="javascript:;">动画短片</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:;">画廊</a></li>
                    <li><a href="javascript:;">视频</a></li>
                    <li><a href="javascript:;">商城</a></li>
                    <li><a href="javascript:;">原创主题</a></li>
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
        
    }
  },
  created:function(){

  },
  events:{

  },
  methods:{

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
