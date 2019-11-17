import axios from 'axios/index';

export function login(user) {
    return axios.post('/admin-api/login', user);
}

