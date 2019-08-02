/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

import Vue from 'vue';
import Vuetify from 'vuetify';
import Routes from 'vue-router';

Vue.use(Vuetify);
Vue.use(Routes);

import App from './components/App'
import Hello from './components/Hello'
import Home from './components/Home'

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
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});