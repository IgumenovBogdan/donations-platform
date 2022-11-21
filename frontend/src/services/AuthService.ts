import {AxiosResponse} from 'axios';
import {AuthResponse} from "../models/response/AuthResponse";
import $api from "../http";
import {IUser} from "../models/IUser";

interface UserResponse {
    user: IUser
}

export default class AuthService {
    static async login(email: string, password: string): Promise<AxiosResponse<AuthResponse>> {
        return $api.post<AuthResponse>('/login', {email, password})
    }

    static async user(): Promise<AxiosResponse<UserResponse>> {
        return $api.get<UserResponse>('/user')
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