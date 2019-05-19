import Vue from 'vue';
import App from './App';

import axios from 'axios';
import Router from 'vue-router';
// 子页面
import Index from './components/Index';
import Start from "./components/Start";
import Preview from "./components/Preview";

// 框架配置
Vue.config.productionTip = false;
// 插件加载

Vue.prototype.$axios = axios.create({
    baseURL: "http://127.0.0.1:9191/index.php/",
});

Vue.use(Router);
let router = new Router({
    mode: "history",
    routes: [
        {path: "/", component: Index},
        {path: "/start", component: Start},
        {path: "/preview", component: Preview},
    ]
});
// 初始化
new Vue({
    render: h => h(App),
    router
}).$mount('#app');