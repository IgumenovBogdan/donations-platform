import React, {FC, useState} from 'react';
import {useLocation} from "react-router-dom";
import {Box, Card, Container, Input, InputAdornment, InputLabel, Paper, TextField, Typography} from "@mui/material";
import {styled} from "@material-ui/styles";
import {AttachMoney} from "@mui/icons-material";

const SupportLot: FC = () => {

    const amountValues = [25, 50, 75, 100];

    const lotId = useLocation().pathname.split('/').pop();

    const [amount, setAmount] = useState('');

    const handleChange = () => (event: React.ChangeEvent<HTMLInputElement>) => {
        setAmount(event.target.value);
    };

    return (
        <Box sx={{
            flexGrow: 1,
            backgroundColor: 'whitesmoke',
            display: 'flex',
            justifyContent: 'center'
        }}>
            <Container sx={{mt: 3, mb: 3}} maxWidth="sm">
                <Typography variant="h3" sx={{mb: 3}}>Donate</Typography>
                <Card sx={{p: 3}}>
                    <Typography variant='h6' sx={{m: 2}}>
                        Donated for
                    </Typography>
                    <Card sx={{p: 3}}>
                        <Typography variant='h6'>
                            <span style={{color: "#6746c3"}}>"100 бронежилетов"</span> charity lot
                        </Typography>
                        <Typography variant='h6'>
                            Opened by <span style={{color: "#fb8c00"}}>CharrityUA</span>
                        </Typography>
                    </Card>
                    {/*<Typography variant='h6' sx={{m: 2}}>*/}
                    {/*    Select Amount*/}
                    {/*</Typography>*/}
                    {/*<Box*/}
                    {/*    sx={{*/}
                    {/*        display: 'flex',*/}
                    {/*        justifyContent: 'space-between',*/}
                    {/*        flexWrap: 'wrap',*/}
                    {/*        '& > :not(style)': {*/}
                    {/*            m: 1,*/}
                    {/*            width: 128,*/}
                    {/*            height: 128,*/}
                    {/*        },*/}
                    {/*    }}*/}
                    {/*>*/}
                    {/*    {amountValues.map((item) => (*/}
                    {/*        <Paper elevation={3}*/}
                    {/*               sx={{*/}
                    {/*                   width: "100px",*/}
                    {/*                   height: "60px",*/}
                    {/*                   textAlign: "center"*/}
                    {/*               }}*/}
                    {/*        >*/}
                    {/*            ${item}*/}
                    {/*        </Paper>*/}
                    {/*    ))}*/}
                    {/*</Box>*/}
                    <Box sx={{
                        display: 'flex',
                        justifyContent: 'center',
                        mt: 3
                    }}>
                        <TextField
                            id="input-with-icon-textfield"
                            label="Enter Price Manually"
                            InputProps={{
                                startAdornment: (
                                    <InputAdornment position="start">
                                        <AttachMoney />
                                    </InputAdornment>
                                ),
                            }}
                            variant="standard"
                        />
                    </Box>
                </Card>
            </Container>
        </Box>
    );
};

export default SupportLot;