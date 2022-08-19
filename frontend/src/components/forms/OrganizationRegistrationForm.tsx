import React, {FC, useState} from 'react';
import {Box, TextField} from "@mui/material";
import {IOrganization} from "../../models/IOrganization";

interface OrganizationProps {
    initialState: IOrganization,
    updateData: (params: any) => any
}

const OrganizationRegistrationForm: FC<OrganizationProps> =
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
                id="email_organization"
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
                id="password_organization"
                autoComplete="current-password"
            />
            <TextField
                onChange={onChangeHandler}
                margin="normal"
                required
                fullWidth
                value={form.name}
                name="name"
                label="Name"
                id="name"
            />
            <TextField
                onChange={onChangeHandler}
                margin="normal"
                required
                fullWidth
                value={form.description}
                name="description"
                label="Description"
                id="description"
            />
            <TextField
                onChange={onChangeHandler}
                margin="normal"
                required
                fullWidth
                value={form.phone}
                name="phone"
                label="Phone"
                id="phone"
            />
        </Box>
    );
};

export default OrganizationRegistrationForm;