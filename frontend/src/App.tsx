import React, {FC, useContext, useEffect} from 'react';
import {Context} from "./index";
import {observer} from "mobx-react-lite";
import {CssBaseline, Box, createTheme, ThemeProvider} from "@mui/material";
import {navbarRoutes as appRoutes, privateRoutes, publicRoutes} from "./routes";
import {authorizationRoutes} from "./routes";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Navbar from "./components/main/Navbar/Navbar";
import Footer from "./components/main/Footer";
import AlertPopup from "./components/ui/AlertPopup";

const App: FC = () => {

    const {auth} = useContext(Context);

    let routes = appRoutes;

    routes = routes.concat(publicRoutes)

    if (!auth.isAuth) {
        routes = appRoutes.concat(authorizationRoutes);
    }

    if (auth.isAuth) {
        routes = appRoutes.concat(privateRoutes);
    }

    useEffect(() => {
        if(localStorage.getItem('token')) {
            auth.checkAuth()
        }
    }, [])

    const theme = createTheme({
        palette: {
            primary: {
                light: "#6746c3",
                main: "#311b92",
                dark: "#000063",
                contrastText: "#FFF",
            },
            secondary: {
                main: "#fb8c00",
                light: "#ffbd45",
                dark: "#c25e00",
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
                    <AlertPopup />
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
