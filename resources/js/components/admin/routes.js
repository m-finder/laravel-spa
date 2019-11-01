import Layout from './layout/Layout'
import Hello from './hello/Index'
import Dashboard from './dashboard/Index'
import Login from './login/Index'
import Icon from './icons/Index'
import Redirect from './redirect/Index'
import Error_404 from './error/404'

export default {
    routers: function () {
        return [
            {
                path: '/',
                name: 'Home',
                component: Layout,
                redirect: '/dashboard',
                children: [
                    {
                        path: 'dashboard',
                        name: 'Dashboard',
                        component: Dashboard,
                    },
                    {
                        name: 'Hello World',
                        path: 'hello',
                        component: Hello,

                    },
                    {
                        path: 'base',
                        name: 'Base',
                        redirect: '/base/icons',
                        component: {
                            render (c) { return c('router-view') }
                        },
                        children: [
                            {
                                path: 'icons',
                                name: 'icons',
                                component: Icon,
                            }
                        ]
                    },
                ]
            },
            {
                path: '/login',
                name: 'Login',
                component: Login,
            },
            {
                path: '/redirect',
                component: Layout,
                hidden: true,
                children: [
                    {
                        path: '/redirect/:path*',
                        component: Redirect
                    }
                ]
            },
            {
                path: '/error',
                name: 'Error',
                component: Layout,
                redirect: '/error/404',
                children: [
                    {
                        path: '404',
                        component: Error_404,
                        name: '404',
                    }
                ]
            },
            {
                path: '*',    // 此处需特别注意至于最底部
                redirect: '/error'
            }
        ]
    }
}
