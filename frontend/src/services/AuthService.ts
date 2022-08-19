import axios, {AxiosResponse} from 'axios';
import {AuthResponse} from "../models/response/AuthResponse";
import $api from "../http";

export default class AuthService {
    static async login(email: string, password: string): Promise<AxiosResponse<AuthResponse>> {
        return $api.post<AuthResponse>('/login', {email, password})
    }

    static async registerOrganization(
        email: string,
        password: string,
        name: string,
        description: string,
        phone: string
    ): Promise<AxiosResponse<AuthResponse>> {
        return $api.post<AuthResponse>('/register-organization',
            {email, password, name, description, phone})
    }

    static async registerContributor(
        email: string,
        password: string,
        first_name: string,
        middle_name: string,
        last_name: string
    ): Promise<AxiosResponse<AuthResponse>> {
        return $api.post<AuthResponse>('/register-contributor',
            {email, password, first_name, middle_name, last_name})
    }

    static async logout(): Promise<void> {
        return $api.post('/logout')
    }
}