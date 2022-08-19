import Lots from "./pages/Lots";
import About from "./pages/About";

import {FC} from "react";
import RegistrationForm from "./components/unauthorized/RegistrationForm";
import LoginForm from "./components/unauthorized/LoginForm";

interface Route {
    key: string,
    title: string,
    path: string,
    enabled: boolean,
    component: FC<{}>
}

export const navbarRoutes: Array<Route> = [
    {
        key: 'home-route',
        title: 'Lots',
        path: '/',
        enabled: true,
        component: Lots
    },
    {
        key: 'about-route',
        title: 'Organizations',
        path: '/about',
        enabled: true,
        component: About
    }
]

export const authorizationRoutes: Array<Route> = [
    {
        key: 'login-route',
        title: 'Login',
        path: '/login',
        enabled: true,
        component: LoginForm
    },
    {
        key: 'registration-route',
        title: 'Registration',
        path: '/registration',
        enabled: true,
        component: RegistrationForm
    }
]