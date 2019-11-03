import axios from 'axios'
import storage from "../storage";

const service = axios.create({
    timeout: 5000
});

service.interceptors.request.use(
    config => {
        // do something before request is sent
        const token = storage.get('token');
        console.log(token)
        if (token) {
            config.headers['Accept'] = 'application/json';
            config.headers['Authorization'] = 'Bearer ' + token;
        }
        return config
    },
    error => {
        // do something with request error
        console.log(error) // for debug
        return Promise.reject(error)
    }
);

export default service
