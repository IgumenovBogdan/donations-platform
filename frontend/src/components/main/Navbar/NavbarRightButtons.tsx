import React, {useContext} from 'react';
import {observer} from "mobx-react-lite";
import {Button, IconButton} from "@mui/material";
import {Context} from "../../../index";
import {useNavigate} from "react-router-dom";
import AccountCircleIcon from '@mui/icons-material/AccountCircle';
import {Logout} from "@mui/icons-material";
import ActionButton from "../../ui/ActionButton";

const NavbarRightButtons = () => {

    const {auth} = useContext(Context);
    const navigate = useNavigate();

    const navigateAccount = () => {
        navigate('/account')
    }

    const handleLogout = () => {
        auth.logout().then(() => {
            if(!auth.error) {
                navigate('/')
            }
        });
    }

    if(auth.isAuth) {
        return (
            <>
                <Button
                    onClick={navigateAccount}
                    variant="text"
                    startIcon={<AccountCircleIcon />}
                    sx={{color: "#ffbd45"}}
                >
                    Account
                </Button>
                <IconButton
                    aria-label="logout"
                    onClick={handleLogout}
                    sx={{color: "#ffbd45"}}
                >
                    <Logout />
                </IconButton>
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
            <ActionButton
                text={'Sign Up'}
                action={navigateSignUp}
                mr={5}
            />
            <Button
                onClick={navigateLogin}
                variant="text"
                sx={{
                    color: "#ffbd45"
                }}
            >
                Login
            </Button>
        </>
    );
};

export default observer(NavbarRightButtons);