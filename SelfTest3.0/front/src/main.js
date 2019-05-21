import Vue from 'vue'
import App from './App.vue'
import Router from 'vue-router';

Vue.config.productionTip = false;

Vue.use(Router);

let router = new Router({
    routes: [
        {path: '/', component: App},
    ]
});

new Vue({
    render: h => h(App),
    router
}).$mount('#app');
