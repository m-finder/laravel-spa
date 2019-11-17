export default {
    items: [
        {
            name: '首页',
            url: '/dashboard',
            icon: 'dashboard',
        },
        {
            name: '权限管理',
            icon: 'security',
            url: '/auth',
            children: [
                {
                    name: '角色列表',
                    url: '/role/list',
                    icon: 'role'
                },
                {
                    name: '用户列表',
                    url: '/admin/list',
                    icon: 'user'
                },
                {
                    name: '权限列表',
                    url: '/permission/list',
                    icon: 'security'
                },
                {
                    name: '菜单列表',
                    url: '/menu/list',
                    icon: 'nav-list'
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
                    icon: 'icon'
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
