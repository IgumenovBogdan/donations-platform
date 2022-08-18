import React, {useContext} from 'react';
import {observer} from "mobx-react-lite";
import {Button, Link} from "@mui/material";
import {Context} from "../../../index";
import {authorizationRoutes} from "../../../routes";
import {NavLink} from "react-router-dom";

const NavbarRightButtons = () => {

    const {auth} = useContext(Context);

    if(auth.isAuth) {
        return (
            <Button variant="text" onClick={() => auth.logout()}>Logout</Button>
        )
    }

    return (
        <>
            {authorizationRoutes.map((page) => (
                <Link
                    key={page.key}
                    component={NavLink}
                    to={page.path}
                    color="black"
                    underline="none"
                    variant="button"
                    sx={{ fontSize: "large", marginLeft: "2rem" }}
                >
                    {page.title}
                </Link>
            ))}
        </>
    );
};

export default observer(NavbarRightButtons);