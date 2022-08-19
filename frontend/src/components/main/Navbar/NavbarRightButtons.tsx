import React, {useContext} from 'react';
import {observer} from "mobx-react-lite";
import {Button} from "@mui/material";
import {Context} from "../../../index";
import {useNavigate} from "react-router-dom";
import AccountCircleIcon from '@mui/icons-material/AccountCircle';

const NavbarRightButtons = () => {

    const {auth} = useContext(Context);
    const navigate = useNavigate();

    if(auth.isAuth) {
        return (
            <>
                <Button variant="text" startIcon={<AccountCircleIcon />}>
                    Account
                </Button>
                <Button variant="text" onClick={() => auth.logout()}>Logout</Button>
            </>
        )
    }

    const navigateLogin = () => {
        navigate('/login')
    }

    const navigateSignUp = () => {
        navigate('/registration')
    }

    return (
        <>
            <Button
                onClick={navigateSignUp}
                variant="contained"
                sx={{
                    mr: 5,
                    borderRadius: 12
                }}
            >
                Sign Up
            </Button>
            <Button
                onClick={navigateLogin}
                variant="text"
            >
                Login
            </Button>
        </>
    );
};

export default observer(NavbarRightButtons);