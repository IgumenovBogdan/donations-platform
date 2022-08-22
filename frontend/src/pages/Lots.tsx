import React, {FC, ReactElement} from 'react';
import {
    Box,
    Container, Typography,
} from "@mui/material";
import {observer} from "mobx-react-lite";
import LotsList from "../components/unauthorized/LotsList";

const Lots: FC = (): ReactElement => {

    return (
        <Box sx={{
            flexGrow: 1,
            backgroundColor: 'whitesmoke',
            display: 'flex',
            justifyContent: 'center'
        }}>
            <Container sx={{mt: 3, mb: 3}} maxWidth="md">
                <Typography variant="h3" sx={{mb: 3}}>Lots</Typography>
                <LotsList />
            </Container>
        </Box>
    );
};

export default observer(Lots);