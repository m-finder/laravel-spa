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
NProgress.configure({ showSpinner: false });
Vue.use(Routes);
Vue.use(BootstrapVue);

import App from './components/admin/App'
import Layout from './components/admin/layout/Layout'
import Hello from './components/admin/Hello'
import Home from './components/admin/Home'
import Login from './components/admin/login/Login'


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
                    meta: { title: 'Home'}
                }
            ]
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
    if(storage.get('token')){
        to.path === '/login' ? next('/') : next();
        NProgress.done()
    }else{
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
    components: { App },
    router,
});
