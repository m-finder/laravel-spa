import axios from 'axios/index';
import storage from 'laravel-spa/resources/js/storage'

export default {
    login(user) {
        return axios.post('/api/login', user);
    },
    find(id) {
        return axios.get(`/api/users/${id}`);
    },
    update(id, data) {
        return axios.put(`/api/users/${id}`, data);
    },
};