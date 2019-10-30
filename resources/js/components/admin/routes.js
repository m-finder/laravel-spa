import Layout from './layout/Layout'
import Hello from './hello/Index'
import Dashboard from './dashboard/Index'
import Login from './login/Index'
import Icon from './icons/Index'
import Error_404 from './error/404'

export default {
    routes: function () {
        return [
            {
                path: '/',
                name: 'Home',
                component: Layout,
                redirect: '/dashboard',
                children: [
                    {
                        path: '/dashboard',
                        name: 'dashboard',
                        component: Dashboard,
                    },
                    {
                        name: 'hello',
                        path: '/hello',
                        component: Hello,

                    },
                ]
            },
            {
                path: '/login',
                name: 'login',
                component: Login,
            },
            {
                path: '/base',
                name: 'Base',
                redirect: '/icons',
                component: Layout,
                children: [
                    {
                        path: '/icons',
                        name: 'icons',
                        component: Icon,
                    }
                ]
            },
            {
                path: '/error',
                name: 'Error',
                component: Layout,
                redirect: '/404',
                children: [
                    {
                        path: '/404',
                        component: Error_404,
                        name: '404',
                    }
                ]
            },
            // {
            //     path: '*',    // 此处需特别注意至于最底部
            //     redirect: '/error'
            // }
        ]
    }
}
