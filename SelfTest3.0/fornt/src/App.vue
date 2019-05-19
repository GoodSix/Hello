<style type="text/css">
    @import "./assets/css/global.css";
    @import "./assets/css/animate.css";
</style>
<style scoped>
    .nav {
        height: 9vh;
        line-height: 9vh;
        background: #4e8fff;
        color: white;
    }

    .nav > div:first-of-type {
        width: 17vw;
        height: inherit;
        display: inline-block;
        text-align: center;
        background: #71cdf4;
    }

    .menu {
        height: 91vh;
        overflow: hidden auto;
        background-image: url("./assets/img/menu_bg.jpg");
        background-size: 100%;
    }

    .menu > a, .menu > div {
        display: block;
        height: 10vh;
        text-align: center;
        line-height: 10vh;
        margin: 1vh 3vw 0px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        color: white;
    }

    .menu > a:nth-of-type(odd) {
        background: #71cdf4;
    }

    .menu > a:nth-of-type(even) {
        background: #4e8fff;
    }

    .menu > div:last-of-type {
        height: 5vh;
        color: grey;
        font-size: 0.5rem;
        background: transparent;
        line-height: initial;
    }
</style>

<template>
    <div>
        <div class="nav">
            <div @click="menu_toggle">ST</div>
            叫个什么名字好呢
        </div>
        <router-view v-if="menu"></router-view>
        <div v-else class="menu" @click="menu_toggle" enter-active-class="fadeInDown" leave-active-class="fadeOutUp">
            <router-link to="/">主页</router-link>
            <router-link to="/preview">预览内容</router-link>
            <router-link to="/start">开始练习</router-link>
            <div>-- 即使是我，也是有底线的(●'◡'●) --</div>
        </div>
    </div>
</template>
<script>

    export default {
        name: "App",
        data() {
            return {
                menu: true,
            }
        },
        methods: {
            menu_toggle() {
                this.menu = !this.menu;
            }
        }
    }
</script>