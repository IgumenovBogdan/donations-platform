import React, {FC, useState} from 'react';
import {Box, TextField} from "@mui/material";
import {IContributor} from "../../models/IContributor";

interface ContributorProps {
    initialState: IContributor,
    updateData: (params: any) => any
}

const ContributorRegistrationForm: FC<ContributorProps> =
    ({initialState, updateData}) => {

        const [form, setForm] = useState(initialState);

        const onChangeHandler = (e: React.ChangeEvent<HTMLInputElement>) => {
            setForm({...form, [e.target.name] : e.target.value})
            updateData(form)
        }

    return (
        <Box
            sx={{
                display: 'flex',
                flexDirection: 'column',
                alignItems: 'center',
            }}
        >
            <TextField
                onChange={onChangeHandler}
                margin="normal"
                required
                fullWidth
                value={form.email}
                id="email_contributor"
                label="Email Address"
                name="email"
                autoComplete="email"
                autoFocus
            />
            <TextField
                onChange={onChangeHandler}
                margin="normal"
                required
                fullWidth
                value={form.password}
                name="password"
                label="Password"
                type="password"
                id="password_contributor"
                autoComplete="current-password"
            />
            <TextField
                onChange={onChangeHandler}
                margin="normal"
                required
                fullWidth
                value={form.first_name}
                name="first_name"
                label="First name"
                id="first_name"
            />
            <TextField
                onChange={onChangeHandler}
                margin="normal"
                required
                fullWidth
                value={form.middle_name}
                name="middle_name"
                label="Middle name"
                id="middle_name"
            />
            <TextField
                onChange={onChangeHandler}
                margin="normal"
                required
                fullWidth
                value={form.last_name}
                name="last_name"
                label="Last name"
                id="last_name"
            />
        </Box>
    );
};

export default ContributorRegistrationForm;