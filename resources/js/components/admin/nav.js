export default {
    items: [
        {
            name: '首页',
            url: '/dashboard',
            icon: 'dashboard',
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
            name: 'Hello Word',
            url: '/hello',
            icon: 'smile'
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
