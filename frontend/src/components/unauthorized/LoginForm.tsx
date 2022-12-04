import React, {FC, useContext, useState} from 'react';
import {Context} from "../../index";
import {observer} from "mobx-react-lite";
import {Avatar, Box, Button, TextField, Typography} from "@mui/material";
import {useNavigate} from "react-router-dom";
import ExitToAppIcon from '@mui/icons-material/ExitToApp';
import useAlert from "../../hooks/useAlert";

const LoginForm: FC = () => {
    const [email, setEmail] = useState<string>('');
    const [password, setPassword] = useState<string>('');
    const {auth} = useContext(Context);

    const navigate = useNavigate();

    const { setAlert } = useAlert();

    const handleLogin = (e: React.FormEvent<HTMLFormElement>) => {
        auth.login(email, password).then(() => {
            if(auth.error) {
                setAlert(auth.error, 'error');
                auth.setError('');
            } else {
                navigate('/')
                setAlert('Login success!', 'success');
            }
        });
        e.preventDefault();
    }

    return (
        <Box sx={{
            flexGrow: 1,
            backgroundColor: 'whitesmoke',
            display: 'flex',
            justifyContent: 'center',
            alignItems: 'center'
        }}>
            <Box
                sx={{
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center',
                    mr: 2, ml: 2, mb: 5, mt: 5
                }}
            >
                <Avatar sx={{ m: 1, bgcolor: 'primary.light' }}>
                    <ExitToAppIcon />
                </Avatar>
                <Typography component="h1" variant="h5">
                    Sign In
                </Typography>
                <Box component="form" onSubmit={handleLogin} noValidate sx={{ mt: 1 }}>
                    <TextField
                        onChange={e => setEmail(e.target.value)}
                        margin="normal"
                        required
                        fullWidth
                        value={email}
                        id="email"
                        label="Email Address"
                        name="email"
                        autoComplete="email"
                        autoFocus
                        inputProps={{
                            style: { backgroundColor: 'white' },
                        }}
                    />
                    <TextField
                        onChange={e => setPassword(e.target.value)}
                        margin="normal"
                        required
                        fullWidth
                        value={password}
                        name="password"
                        label="Password"
                        type="password"
                        id="password"
                        autoComplete="current-password"
                        inputProps={{
                            style: { backgroundColor: 'white' },
                        }}
                    />
                    <Button
                        type="submit"
                        fullWidth
                        variant="contained"
                        sx={{ mt: 3, mb: 2 }}
                    >
                        Sign In
                    </Button>
                </Box>
            </Box>
        </Box>
    );
};

export default observer(LoginForm);