import axios from 'axios';

const baseDomain = 'http://localhost:85/api';

const baseURL = `${baseDomain}`;
const $api = axios.create({
    baseURL
});
$api.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token');
        if (token) {
            if (config.headers) {
                config.headers['Authorization'] = `Bearer ${token}`;
            }
        }

        return config;
    },

    (error) => {
        return Promise.reject(error);
    }
);

export default $api;