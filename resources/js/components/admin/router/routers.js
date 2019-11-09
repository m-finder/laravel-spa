import Layout from '../views/layout/Layout'
import Admin from '../views/admins/Index'
import Role from '../views/roles/Index'
import RoleEdit from '../views/roles/Edit'
import RoleCreate from '../views/roles/Create'

import Permission from '../views/permissions/Index'
import RolePermission from '../views/roles-permissions/Index'
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
                        meta: { title: '首页'},
                        name: 'Dashboard',
                    },
                ]
            },
            {
                name: 'Role',
                meta: { title: '角色管理'},
                path: '/role',
                redirect: '/role/list',
                component: Layout,
                children: [
                    {
                        name: 'RoleList',
                        meta: { title: '角色列表'},
                        path: 'list',
                        component: Role,
                    },
                    {
                        name: 'RoleEdit',
                        meta: { title: '角色编辑'},
                        path: 'edit/:id',
                        component: RoleEdit,
                    },
                    {
                        name: 'RoleCreate',
                        meta: { title: '添加角色'},
                        path: 'create',
                        component: RoleCreate,
                    },
                    {
                        name: 'RolePermission',
                        meta: { title: '权限分配'},
                        path: 'role-permission',
                        component: RolePermission,
                    }
                ]
            },
            {
                name: 'Admin',
                meta: { title: '用户管理'},
                path: '/admin',
                redirect: '/admin/list',
                component: Layout,
                children: [
                    {
                        name: 'AdminList',
                        meta: { title: '用户列表'},
                        path: 'list',
                        component: Admin,
                    }
                ]
            },
            {
                name: 'Permission',
                meta: { title: '权限管理'},
                path: '/permission',
                redirect: '/permission/list',
                component: Layout,
                children: [
                    {
                        name: 'PermissionList',
                        meta: { title: '权限列表'},
                        path: 'list',
                        component: Permission,
                    }
                ]
            },
            {
                path: '/base',
                name: 'Base',
                meta: { title: 'Base'},
                redirect: '/base/icons',
                component: Layout,
                children: [
                    {
                        path: 'icons',
                        name: 'Icons',
                        meta: { title: 'Icons'},
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
