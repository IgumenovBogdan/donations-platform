import React, {FC, useContext, useState} from 'react';
import {Context} from "../../index";
import {observer} from "mobx-react-lite";
import {Box} from "@mui/material";
import {useNavigate} from "react-router-dom";

const LoginForm: FC = () => {
    const [email, setEmail] = useState<string>('');
    const [password, setPassword] = useState<string>('');
    const {auth} = useContext(Context);

    const navigate = useNavigate();

    const handleLogin = (email: string, password: string) => {
        auth.login(email, password).then(() => {
            navigate('/')
        })
    }

    return (
        <Box sx={{
            flexGrow: 1,
            backgroundColor: 'whitesmoke',
            display: 'flex',
            justifyContent: 'center',
            alignItems: 'center'
        }}>
            <div>
                <input
                    onChange={e => setEmail(e.target.value)}
                    value={email}
                    type="text"
                    placeholder="email"
                />
                <input
                    onChange={e => setPassword(e.target.value)}
                    value={password}
                    type="password"
                    placeholder="password"
                />
                <button onClick={() => handleLogin(email, password)}>Login</button>
            </div>
        </Box>
    );
};

export default observer(LoginForm);