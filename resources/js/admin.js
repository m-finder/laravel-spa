/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

import Vue from 'vue';
import Router from 'vue-router';
import BootstrapVue from 'bootstrap-vue'
import NProgress from 'nprogress' // progress bar
import 'nprogress/nprogress.css' // progress bar style
import storage from "./storage";
import store from './components/admin/store'
import SvgVue from 'svg-vue';

NProgress.configure({showSpinner: false});
Vue.use(Router);
Vue.use(BootstrapVue);
Vue.use(SvgVue);

import routers from './components/admin/routes'
import App from './components/admin/App'

// 解决路由重写
const routerPush = Router.prototype.push;
Router.prototype.push = function push(location) {
    return routerPush.call(this, location).catch(error=> error)
};

const router = new Router({
    linkActiveClass: 'open',
    linkExactActiveClass: 'active',
    scrollBehavior: () => ({ y: 0 }),
    routes: routers.routers()
});


router.beforeEach(async (to, from, next) => {
    NProgress.start();
    if (storage.get('user-info')) {
        to.path === '/login' ? next('/') : next();
        NProgress.done()
    } else {
        console.log('login')
        to.path === '/login' ? next() : next(`/login?redirect=${to.path}`);
        NProgress.done();
    }
});

router.afterEach(() => {
    NProgress.done()
});

const app = new Vue({
    el: '#app',
    store,
    components: {App},
    router,
});
