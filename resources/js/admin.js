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
NProgress.configure({ showSpinner: false });
Vue.use(Routes);
Vue.use(BootstrapVue);

import App from './components/admin/App'
import Hello from './components/admin/Hello'
import Home from './components/admin/Home'
import Login from './components/admin/Login'

const router = new Routes({
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/hello',
            name: 'hello',
            component: Hello,
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
    ],
});

router.beforeEach(async(to, from, next) => {
    NProgress.start();
    next()
});

router.afterEach(() => {
    NProgress.done()
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
