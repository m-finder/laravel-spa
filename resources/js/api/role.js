import request from './request';

export function getData(query) {
    return request({
        url: '/admin-api/roles/list',
        method: 'get',
        params: query
    })
}

export function deleteData(id){
    return request({
        url: '/admin-api/roles/delete',
        method: 'delete',
        params: {id: id}
    })
}
