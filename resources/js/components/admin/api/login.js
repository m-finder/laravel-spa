import axios from 'axios/index';

export function login(user) {
    return axios.post('/admin-api/login', user);
}

export function sendMail(email) {
    return axios.post('/admin-api/send/mail/reset/password', {email: email});
}

