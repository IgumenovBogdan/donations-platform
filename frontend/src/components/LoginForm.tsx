import React, {FC, useContext, useState} from 'react';
import {Context} from "../index";

const LoginForm: FC = () => {
    const [email, setEmail] = useState<string>('');
    const [password, setPassword] = useState<string>('');
    const {auth} = useContext(Context);
    return (
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
            <button onClick={() => auth.login(email, password)}>Login</button>
        </div>
    );
};

export default LoginForm;