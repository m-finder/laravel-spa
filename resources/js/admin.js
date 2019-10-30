/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

import Vue from 'vue';
import Routes from 'vue-router';
import BootstrapVue from 'bootstrap-vue'
import NProgress from 'nprogress' // progress bar
import 'nprogress/nprogress.css' // progress bar style
import storage from "./storage";
import store from './store'
import SvgVue from 'svg-vue';
NProgress.configure({showSpinner: false});
Vue.use(Routes);
Vue.use(BootstrapVue);
Vue.use(SvgVue);

import routes from './components/admin/routes'
import App from './components/admin/App'


const router = new Routes({
    // linkActiveClass: 'open active',
    scrollBehavior: () => ({ y: 0 }),
    routes: routes.routes()
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
