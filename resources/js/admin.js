/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

import Vue from 'vue';
import Routes from 'vue-router';
import BootstrapVue from 'bootstrap-vue'

Vue.use(Routes);
Vue.use(BootstrapVue)

import App from './components/admin/App'
import Hello from './components/admin/Hello'
import Home from './components/admin/Home'
import Login from './components/admin/Login'

const router = new Routes({
    mode: 'history',
    routes: [
        {
            path: '/admin/',
            name: 'home',
            component: Home
        },
        {
            path: '/admin/hello',
            name: 'hello',
            component: Hello,
        },
        {
            path: '/admin/login',
            name: 'login',
            component: Login,
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});