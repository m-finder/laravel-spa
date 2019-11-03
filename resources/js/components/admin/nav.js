export default {
    items: [
        {
            name: '首页',
            url: '/dashboard',
            icon: 'dashboard',
        },
        {
            name: '角色管理',
            url: '/role',
            icon: 'role',
            children: [
                {
                    name: '角色列表',
                    url: '/role/list',
                    icon: 'list'
                }, {
                    name: '权限分配',
                    url: '/role/role-permission',
                    icon: 'security'
                },
            ]
        },
        {
            name: '用户管理',
            url: '/admin',
            icon: 'user',
            children: [
                {
                    name: '用户列表',
                    url: '/admin/list',
                    icon: 'list'
                },
            ]
        },
        {
            name: '权限管理',
            url: '/permission',
            icon: 'credits',
            children: [
                {
                    name: '权限列表',
                    url: '/permission/list',
                    icon: 'list'
                },
            ]
        },
        {
            name: 'Base',
            url: '/base',
            children: [
                {
                    name: 'Icons',
                    url: '/base/icons',
                    icon: 'smile'
                },
                {
                    name: 'Test',
                    url: '/base/test',
                    icon: 'smile',
                    children: [
                        {
                            name: 'Test2',
                            url: '/base/test/test2',
                            icon: 'smile',
                        }
                    ]
                },
            ]
        },
    ]
}
