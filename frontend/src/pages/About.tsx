import React, {FC, ReactElement} from 'react';
import {Box, Container, Typography} from "@mui/material";

const About: FC = (): ReactElement => {
    return (
        <Box sx={{
            flexGrow: 1,
            backgroundColor: 'whitesmoke',
            display: 'flex',
            justifyContent: 'center'
        }}>
            <Container maxWidth="sm">
                <Typography variant="h3">About</Typography>
            </Container>
        </Box>
    );
};

export default About;