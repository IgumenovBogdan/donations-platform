import React, {FC, ReactElement, useContext, useEffect, useRef} from 'react';

import {
    Box,
    TableContainer,
    Table,
    TableHead,
    Paper,
    TableRow,
    TableCell,
    TableBody,
    Collapse,
    IconButton,
    Typography,
    TextField, Button
} from "@mui/material";

import {makeStyles} from "@material-ui/styles";
import {Visibility, VisibilityOff, Delete} from "@mui/icons-material";
import {ILot} from "../../../models/ILot";
import {Context} from "../../../index";
import useAlert from "../../../hooks/useAlert";
import ProgressBar from "../../ui/ProgressBar";
import CreateLotModal from "../../modals/CreateLotModal";

const useRowStyles = makeStyles({
    root: {
        '& > *': {
            borderBottom: 'unset',
        },
    },
});

interface RowProps {
    row: ILot
}

const Row: FC<RowProps> = ({row}) => {
    const [open, setOpen] = React.useState(false);
    const classes = useRowStyles();

    const [lot, setLot] = React.useState({
        'name': row.name,
        'description': row.description,
        'price': row.price
    });

    const [changed, setChanged] = React.useState(false);

    const {organizationAccount} = useContext(Context);

    const { setAlert } = useAlert();

    let storageRef = useRef(true);
    useEffect(() => {
        if (!storageRef.current) {
            setChanged(true);
        }
        return () => { storageRef.current = false; }
    }, [lot]);

    const handleUpdate = (id: string) => {
        organizationAccount.updateLot(id, {...lot}).then(() => {
            if (organizationAccount.error) {
                setAlert(organizationAccount.error, 'error');
                organizationAccount.setError('');
            } else {
                setAlert('Update success!', 'success');
            }
        });
    }

    const handleDelete = (id: string) => {
        organizationAccount.deleteLot(id).then(() => {
           if (organizationAccount.error) {
               setAlert(organizationAccount.error, 'error');
               organizationAccount.setError('');
           } else {
               setAlert('Delete success!', 'success');
           }
        });
    }

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setLot({...lot, [e.target.name]: e.target.value});
    }

    return (
        <React.Fragment>
            <TableRow className={classes.root}>
                <TableCell component="th" scope="row">
                    {row.name}
                </TableCell>
                <TableCell align={"right"}>
                    <IconButton aria-label="expand row" size="small" onClick={() => setOpen(!open)} color={'primary'}>
                        {open ? <VisibilityOff /> : <Visibility />}
                    </IconButton>
                    <IconButton aria-label="expand row" size="small" onClick={() => handleDelete(row.id)} sx={{ color: "red" }}>
                        <Delete />
                    </IconButton>
                </TableCell>
            </TableRow>
            <TableRow>
                <TableCell style={{ paddingBottom: 0, paddingTop: 0 }} colSpan={6}>
                    <Collapse in={open} timeout="auto" unmountOnExit>
                        <Box margin={1}>
                            <Box
                                sx={{
                                    display: 'flex',
                                    flexDirection: 'column',
                                    alignItems: 'center',
                                    m: 2
                                }}
                            >
                                <ProgressBar value={parseInt(row.total_collected_in_percent)}/>
                                <TextField
                                    id="outlined-name"
                                    margin="normal"
                                    fullWidth
                                    label="Name"
                                    name="name"
                                    value={lot.name}
                                    onChange={handleChange}
                                />
                                <TextField
                                    id="outlined-multiline-static"
                                    margin="normal"
                                    fullWidth
                                    label="Description"
                                    name="description"
                                    value={lot.description}
                                    onChange={handleChange}
                                    multiline
                                    rows={4}
                                />
                                <TextField
                                    id="outlined-name"
                                    margin="normal"
                                    fullWidth
                                    label="Price"
                                    name="price"
                                    value={lot.price}
                                    onChange={handleChange}
                                />
                                <Box width={1} sx={{ display: 'flex', justifyContent: 'end' }}>
                                    <Button
                                        type="submit"
                                        variant="contained"
                                        disabled={!changed}
                                        onClick={() => handleUpdate(row.id)}
                                    >
                                        Save
                                    </Button>
                                </Box>
                            </Box>
                            <Table size="small" aria-label="purchases">
                                <TableHead>
                                    <TableRow>
                                        <TableCell>Total collected($)</TableCell>
                                        <TableCell>In percents</TableCell>
                                        <TableCell>Status</TableCell>
                                    </TableRow>
                                </TableHead>
                                <TableBody>
                                    <TableRow>
                                        <TableCell component="th" scope="row">
                                            {row.total_collected + '/' + row.price}
                                        </TableCell>
                                        <TableCell>{row.total_collected_in_percent + '%'}</TableCell>
                                        <TableCell>{row.status}</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </Box>
                    </Collapse>
                </TableCell>
            </TableRow>
        </React.Fragment>
    );
}

interface TableProps {
    lots: ILot[]
}

const LotsTable: FC<TableProps> = ({lots}): ReactElement => {

    return (
        <>
            <Typography variant="h5" sx={{mb: 3}}>Your lots:</Typography>
            <TableContainer component={Paper} sx={{mb: 3}}>
                <Table aria-label="collapsible table">
                    <TableHead>
                        <TableRow>
                            <TableCell>
                                <b>Name</b>
                            </TableCell>
                            <TableCell align={"right"}>
                                <CreateLotModal />
                            </TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {lots.map((row) => (
                            <Row key={row.id} row={row} />
                        ))}
                    </TableBody>
                </Table>
            </TableContainer>
        </>
    );
}

export default LotsTable;