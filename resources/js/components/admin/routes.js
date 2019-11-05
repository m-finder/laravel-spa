import Layout from './views/layout/Layout'
import Admin from './views/admins/Index'
import Role from './views/roles/Index'
import Permission from './views/permissions/Index'
import RolePermission from './views/roles-permissions/Index'
import Dashboard from './views/dashboard/Index'
import Login from './views/login/Index'
import Icon from './views/icons/Index'
import Redirect from './components/redirect/Index'
import Error_404 from './views/error/404'

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
                        name: '首页',
                        component: Dashboard,
                    },
                    {
                        name: '角色管理',
                        path: 'role',
                        redirect: '/role/list',
                        component: {
                            render (c) { return c('router-view') }
                        },
                        children: [
                            {
                                name: '角色列表',
                                path: 'list',
                                component: Role,
                            },
                            {
                                name: '权限分配',
                                path: 'role-permission',
                                component: RolePermission,
                            }
                        ]
                    },
                    {
                        name: '用户管理',
                        path: 'admin',
                        redirect: '/admin/list',
                        component: {
                            render (c) { return c('router-view') }
                        },
                        children: [
                            {
                                name: '用户列表',
                                path: 'list',
                                component: Admin,
                            }
                        ]
                    },
                    {
                        name: '权限管理',
                        path: 'permission',
                        redirect: '/permission/list',
                        component: {
                            render (c) { return c('router-view') }
                        },
                        children: [
                            {
                                name: '权限列表',
                                path: 'list',
                                component: Permission,
                            }
                        ]
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
