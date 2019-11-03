import request from './request';

export function getList(query) {
    return request({
        url: '/admin-api/admins/list',
        method: 'get',
        params: query
    })
}

export function deleteData(id){
    return request({
        url: '/admin-api/admins/delete',
        method: 'delete',
        params: {id: id}
    })
}
