import Vue from 'vue';
import Router from 'vue-router';
import Layout from '../views/layout/Layout'
Vue.use(Router);

export const baseRouters = [
    {
        path: '/login',
        name: 'Login',
        hidden: true,
        component: () => import('../views/login/Index'),
    },
    {
        path: '/redirect',
        component: Layout,
        hidden: true,
        children: [
            {
                hidden: true,
                path: '/redirect/:path*',
                component: () => import('../components/redirect/Index')
            }
        ]
    },
    {
        path: '/error',
        name: 'Error',
        component: Layout,
        hidden: true,
        redirect: '/error/404',
        children: [
            {
                path: '404',
                hidden: true,
                meta: {title: '404'},
                component: () => import('../views/error/404'),
                name: '404',
            },
        ]
    },
    // {
    //     path: '/',
    //     name: 'Home',
    //     component: Layout,
    //     redirect: '/dashboard',
    //     children: [
    //         {
    //             path: '/dashboard',
    //             meta: {title: '首页', affix: true},
    //             icon: 'dashboard',
    //             name: 'Dashboard',
    //             component: () => import('../views/dashboard/Index')
    //         },
    //     ]
    // },
];


// 解决路由重写
const routerPush = Router.prototype.push;
Router.prototype.push = function push(location) {
    return routerPush.call(this, location).catch(error=> error)
};

export default new Router({
    linkActiveClass: 'open',
    linkExactActiveClass: 'active',
    scrollBehavior: () => ({ y: 0 }),
    routes: baseRouters
});

