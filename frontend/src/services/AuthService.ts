import $api from "../http";
import {AxiosResponse} from 'axios';
import {AuthResponse} from "../models/response/AuthResponse";

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
        return $api.post<AuthResponse>('/registerOrganization',
            {email, password, name, description, phone})
    }

    static async logout(): Promise<void> {
        return $api.post('/logout')
    }
}