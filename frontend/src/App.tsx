import React, {FC, useContext, useEffect} from 'react';
import {Context} from "./index";
import {observer} from "mobx-react-lite";
import {CssBaseline, Box, createTheme, ThemeProvider} from "@mui/material";
import {navbarRoutes as appRoutes} from "./routes";
import {authorizationRoutes} from "./routes";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Navbar from "./components/main/Navbar/Navbar";
import Footer from "./components/main/Footer";

const App: FC = () => {

    const {auth} = useContext(Context);

    let routes = appRoutes;

    if (!auth.isAuth) {
        routes = appRoutes.concat(authorizationRoutes);
    }

    useEffect(() => {
        if(localStorage.getItem('token')) {
            auth.checkAuth()
        }
    }, [])

    const theme = createTheme({
        palette: {
            primary: {
                light: "#63b8ff",
                main: "#0989e3",
                dark: "#005db0",
                contrastText: "#000",
            },
            secondary: {
                main: "#4db6ac",
                light: "#82e9de",
                dark: "#00867d",
                contrastText: "#000",
            },
        },
    });

    if (auth.isLoading) {
        return <div>Loading...</div>
    }

    return (
        <>
            <ThemeProvider theme={theme}>
                <CssBaseline />
                <Box
                    height="100vh"
                    display="flex"
                    flexDirection="column"
                >
                    <Router>
                        <Navbar />
                        <Routes>
                            {routes.map((route) => (
                                <Route
                                    key={route.key}
                                    path={route.path}
                                    element={<route.component />}
                                />
                            ))}
                        </Routes>
                        <Footer />
                    </Router>
                </Box>
            </ThemeProvider>
        </>
    );
};

export default observer(App);
