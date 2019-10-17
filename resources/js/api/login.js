import axios from 'axios/index';

export default {
    login(user) {
        return axios.post('/admin-api/login', user);
    },
    find(id) {
        return axios.get(`/api/users/${id}`);
    },
    update(id, data) {
        return axios.put(`/api/users/${id}`, data);
    },
};
