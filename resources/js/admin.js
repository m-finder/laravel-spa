/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue'
import NProgress from 'nprogress' // progress bar
import 'nprogress/nprogress.css' // progress bar style
import storage from "./storage";
import store from './components/admin/store';
import SvgVue from 'svg-vue';
import Alert from 'vue-izitoast';

NProgress.configure({showSpinner: false});
Vue.use(BootstrapVue);
Vue.use(SvgVue);
Vue.use(Alert);

import 'izitoast/dist/css/iziToast.min.css';
import App from './components/admin/App'
import getPageTitle from './components/admin/utils/get-page-title'
import router, {asyncRouter} from './components/admin/router/routers'

router.beforeEach(async (to, from, next) => {
    document.title = getPageTitle(to.meta.title);
    NProgress.start();
    if (storage.get('user-info')) {
        if (to.path === '/login') {
            next('/')
        } else {
            if (store.getters.addRouters.length == 0) {
                store.dispatch('GenerateRoutes', {asyncRouter}).then(() => {
                    // 404只能放在异步路由，否则造成刷新404
                    asyncRouter.push(            {
                        path: '*',
                        redirect: '/error'
                    });
                    // 添加动态路由
                    router.addRoutes(asyncRouter);
                    next({...to, replace: true});
                })
            } else{
                next()
            }
            // to.path === '/login' ? next('/') : next();
            NProgress.done()
        }
    } else {
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
