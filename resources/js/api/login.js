import axios from 'axios/index';

export default {
    login(user) {
        return axios.post('/admin-api/login', user);
    }
};
