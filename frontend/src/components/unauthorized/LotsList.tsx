import React, {FC, useContext, useEffect, useState} from 'react';
import {
    Accordion,
    AccordionDetails,
    AccordionSummary,
    Box, Button,
    FormControl, InputLabel,
    LinearProgress, MenuItem, Select, SelectChangeEvent,
    TextField,
    Typography
} from "@mui/material";
import ExpandMoreIcon from "@mui/icons-material/ExpandMore";
import {Context} from "../../index";
import {observer} from "mobx-react-lite";
import ProgressBar from "../ui/ProgressBar";
import ActionButton from "../ui/ActionButton";
import {useNavigate} from "react-router-dom";
import {Info} from "@mui/icons-material";
import useDebounce from "../../hooks/useDebounce";

const LotsList: FC = () => {

    const {lots} = useContext(Context);
    const navigate = useNavigate();

    const [take, setTake] = useState(1);
    const [expanded, setExpanded] = React.useState<string | false>(false);
    const [sortBy, setSortBy] = useState('');
    const [searchTerm, setSearchTerm] = useState('');

    const debouncedSearchTerm = useDebounce(searchTerm, 750);

    useEffect(() => {
        lots.getLots(take, sortBy, searchTerm)
    }, []);

    useEffect(() => {
        lots.getLots(take, sortBy, debouncedSearchTerm)
    }, [debouncedSearchTerm])

    const handleChange =
        (panel: string) => (event: React.SyntheticEvent, isExpanded: boolean) => {
            setExpanded(isExpanded ? panel : false);
        };

    const handleSortChange = (e: SelectChangeEvent) => {
        setSortBy(e.target.value as string)
        lots.getLots(take, sortBy, searchTerm)
    }

    const handleSeeMoreClick = () => {
        setTake(take + 1)
        lots.getLots(take + 1, sortBy, debouncedSearchTerm)
    }

    const navigateLot = (id: string) => {
        navigate('/lot/' + id)
    }

    if (lots.isLoading) {
        return <LinearProgress color="primary"/>
    }

    return (

        lots.lots &&

        <>
            <Box sx={{
                display: 'flex',
                justifyContent: 'space-between',
                mb: 3
            }}>
                <TextField
                    value={searchTerm}
                    onChange={(e) => setSearchTerm(e.target.value)}
                    id="outlined-basic"
                    label="Search by organization..."
                    variant="outlined"
                    sx={{
                        width: "50%",
                        borderRadius: 12,
                        '& fieldset': {
                            paddingLeft: (theme) => theme.spacing(2.5),
                            borderRadius: '30px',
                            backgroundColor: 'white'
                        },
                    }}

                />
                <FormControl
                    variant="standard"
                    sx={{
                        width: "25%",
                        maxWidth: "100px"
                }}>
                    <InputLabel id="demo-simple-select-label">Sort by</InputLabel>
                    <Select
                        labelId="demo-simple-select-label"
                        id="demo-simple-select"
                        value={sortBy}
                        label="Sort by"
                        onChange={handleSortChange}
                    >
                        <MenuItem value={'asc'}>Newest first</MenuItem>
                        <MenuItem value={'desc'}>Latest first</MenuItem>
                    </Select>
                </FormControl>
            </Box>
            <Accordion disabled>
                <AccordionSummary
                    expandIcon={<Info />}
                    aria-controls="panel3a-content"
                    id="panel3a-header"
                >
                    <Typography sx={{ width: '33%', flexShrink: 0 }}>Organization:</Typography>
                    <Typography sx={{ width: '50%' }}>Name:</Typography>
                    <Typography sx={{ width: '15%', display: "flex", justifyContent: "end" }}>Total:</Typography>
                </AccordionSummary>
            </Accordion>
            {lots.lots.map((lot) => (
                <Accordion
                    expanded={expanded === 'panel' + lot.id}
                    onChange={handleChange('panel' + lot.id)}>
                    <AccordionSummary
                        expandIcon={<ExpandMoreIcon />}
                        aria-controls="panel1bh-content"
                        id="panel1bh-header"
                    >
                        <Typography sx={{ width: '33%', flexShrink: 0 }}>{lot.organization}</Typography>
                        <Typography sx={{ width: '50%', color: 'text.secondary' }}>{lot.name}</Typography>
                        <Typography sx={{ width: '15%', display: "flex", justifyContent: "end" }}>{lot.total_collected_in_percent}%</Typography>
                    </AccordionSummary>
                    <AccordionDetails>
                        <div style={{display: "flex", flexDirection: "column"}}>
                            <div>
                                <Typography>{lot.description}</Typography>
                            </div>
                            <div>
                                <Typography mt={2}>Total collected: {lot.total_collected}/{lot.price} ($)</Typography>
                            </div>
                        </div>
                        <ProgressBar value={parseInt(lot.total_collected_in_percent)}/>
                        <div style={{display: "flex", justifyContent: "end"}}>
                            <ActionButton
                                text={'Support'}
                                action={() => navigateLot(lot.id)}
                            />
                        </div>
                    </AccordionDetails>
                </Accordion>
            ))}
            <Box sx={{
                display: 'flex',
                justifyContent: 'center',
                mt: 3
            }}>
                <Button
                    endIcon={<ExpandMoreIcon />}
                    sx={{color: "#6746c3"}}
                    onClick={() => handleSeeMoreClick()}
                >See more
                </Button>
            </Box>
        </>
    );
};

export default observer(LotsList);