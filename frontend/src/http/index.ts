import axios from 'axios';

export const API_URL = 'http://localhost:85/api'

const $api = axios.create({
    withCredentials: false,
    baseURL: API_URL
})

$api.interceptors.request.use((config) => {

    //need check for public api-endpoints (lots and organization index && show methods)

    if(localStorage.getItem('token')) {
        config.headers!.authotization = `Bearer ${localStorage.getItem('token')}`
    }
    return config;
})

export default $api