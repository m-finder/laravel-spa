export default {
  items: [
    {
      name: 'Dashboard',
      url: '/dashboard',
      icon: 'dashboard',
      badge: {
        variant: 'primary',
        text: 'NEW'
      }
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
          },
      ]
    },
  ]
}
