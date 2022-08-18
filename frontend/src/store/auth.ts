import {IUser} from "../models/IUser";
import {makeAutoObservable} from "mobx";
import AuthService from "../services/AuthService";

export default class Auth {

    user = {} as IUser;
    isAuth = false;
    isLoading = false;

    constructor() {
        makeAutoObservable(this);
    }

    setAuth(bool: boolean) {
        this.isAuth = bool;
    }

    setUser(user: IUser) {
        this.user = user;
    }

    setLoading(bool: boolean) {
        this.isLoading = bool;
    }

    async login(email: string, password: string) {
        try {
            const response = await AuthService.login(email, password);
            localStorage.setItem('token', response.data.token);
            this.setAuth(true);
            this.setUser(response.data.user);
        } catch (e: any) {
            console.log(e.response?.data?.message)
        }
    }

    async logout() {
        try {
            const response = await AuthService.logout();
            localStorage.removeItem('token');
            this.setAuth(false);
            this.setUser({} as IUser);
        } catch (e: any) {
            console.log(e.response?.data?.message)
        }
    }

    async checkAuth() {
        this.setLoading(true);
        try {
            this.setAuth(true)
        } catch (e: any) {
            console.log(e.response?.data?.message)
        } finally {
            this.setLoading(false)
        }
    }

    async registerOrganization(
        email: string,
        password: string,
        name: string,
        description: string,
        phone: string
    ) {
        try {
            const response = await AuthService.registerOrganization(email, password, name, description, phone);
            localStorage.setItem('token', response.data.token);
            this.setAuth(true);
            this.setUser(response.data.user);
        } catch (e: any) {
            console.log(e.response?.data?.message)
        }
    }

}