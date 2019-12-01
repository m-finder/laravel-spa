import Layout from '../views/layout/Layout'

import Admin from '../views/admins/Index'
import Role from '../views/roles/Index'
import Permission from '../views/permissions/Index'
import RolePermission from '../views/roles-permissions/Index'

import Menu from '../views/menus/Index'

import Dashboard from '../views/dashboard/Index'
import Login from '../views/login/Index'
import Icon from '../views/icons/Index'
import Redirect from '../components/redirect/Index'
import Error_404 from '../views/error/404'

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
                        component: Dashboard,
                        meta: {title: '首页', affix: true},
                        name: 'Dashboard',
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
                        component: Role,
                    },
                    {
                        name: 'AdminList',
                        meta: {title: '用户列表', noCache: false},
                        path: 'admins',
                        component: Admin,
                    },
                    {
                        name: 'MenuList',
                        meta: {title: '权限管理'},
                        path: 'menus',
                        component: Menu,
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
                        component: Icon,
                    }
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
