import Layout from '../views/layout/Layout'

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
                        meta: {title: '首页', affix: true},
                        name: 'Dashboard',
                        component: () => import('../views/dashboard/Index')
                    },
                ]
            },
            {
                name: 'Auth',
                meta: {title: '权限管理'},
                path: '/auth',
                redirect: '/auth/roles',
                component: Layout,
                children: [
                    {
                        name: 'RoleList',
                        meta: {title: '角色列表', noCache: false},
                        path: 'roles',
                        component: () => import('../views/roles/Index'),
                    },
                    {
                        name: 'AdminList',
                        meta: {title: '用户列表', noCache: false},
                        path: 'admins',
                        component: () => import('../views/admins/Index'),
                    },
                    {
                        name: 'MenuList',
                        meta: {title: '权限管理'},
                        path: 'menus',
                        component: () => import('../views/menus/Index')
                    },
                ]
            },
            {
                path: '/base',
                name: 'Base',
                meta: {title: 'Base'},
                redirect: '/base/icons',
                component: Layout,
                children: [
                    {
                        path: 'icons',
                        name: 'Icons',
                        meta: {title: 'Icons'},
                        component: () => import('../components/redirect/Index'),
                    }
                ]
            },

            {
                path: '/login',
                name: 'Login',
                component: () => import('../views/login/Index'),
            },
            {
                path: '/redirect',
                component: Layout,
                hidden: true,
                children: [
                    {
                        path: '/redirect/:path*',
                        component: () => import('../components/redirect/Index')
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
                        component: () => import('../views/error/404'),
                        name: '404',
                        title: '404',
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
