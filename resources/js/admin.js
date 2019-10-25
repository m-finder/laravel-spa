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

NProgress.configure({showSpinner: false});
Vue.use(Routes);
Vue.use(BootstrapVue);

import App from './components/admin/App'
import Layout from './components/admin/layout/Layout'
import Hello from './components/admin/Hello'
import Home from './components/admin/Home'
import Login from './components/admin/login/Index'
import Icons from './components/admin/icons/Index'

import '../icons'

const router = new Routes({
    routes: [
        {
            path: '/',
            name: 'root',
            component: Layout,
            redirect: 'home',
            children: [
                {
                    path: 'home',
                    component: Home,
                    name: 'home',
                    meta: {title: 'Home'}
                }
            ]
        },
        {
            path: '/hello',
            component: Layout,
            redirect: '/hello/index',
            children: [
                {
                    path: 'index',
                    component: Hello,
                    name: 'hello',
                    meta: {title: 'hello'}
                }
            ]
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/icons',
            component: Layout,
            redirect: '/icons/index',
            children: [
                {
                    path: 'index',
                    component: Icons,
                    name: 'icons',
                    meta: {title: 'Icons'}
                }
            ]
        },
    ],
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
