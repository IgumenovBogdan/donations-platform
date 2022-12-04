import * as React from 'react';
import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';
import Dialog from '@mui/material/Dialog';
import DialogActions from '@mui/material/DialogActions';
import DialogContent from '@mui/material/DialogContent';
import DialogContentText from '@mui/material/DialogContentText';
import DialogTitle from '@mui/material/DialogTitle';
import OutlinedInput from '@mui/material/OutlinedInput'
import InputAdornment from '@mui/material/InputAdornment'
import FormControl from '@mui/material/FormControl'
import InputLabel from '@mui/material/InputLabel'
import {useContext} from "react";
import {Context} from "../../index";
import useAlert from "../../hooks/useAlert";

export default function CreateLotModal() {

    const {organizationAccount} = useContext(Context);

    const { setAlert } = useAlert();

    const [lot, setLot] = React.useState({
        'name': '',
        'description': '',
        'price': ''
    });

    const [open, setOpen] = React.useState(false);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setLot({...lot, [e.target.name]: e.target.value});
    }

    const handleSubmit = () => {
        organizationAccount.createLot({...lot}).then(() => {
           if (organizationAccount.error) {
               setAlert(organizationAccount.error, 'error');
               organizationAccount.setError('');
           } else {
               handleClose();
               setAlert('Create success!', 'success');
           }
        });
    }

    const handleClickOpen = () => {
        setOpen(true);
    };

    const handleClose = () => {
        setOpen(false);
    };

    return (
        <div>
            <Button variant="contained" onClick={handleClickOpen}>
                Create
            </Button>
            <Dialog open={open} onClose={handleClose}>
                <DialogTitle>Create a charity lot</DialogTitle>
                <DialogContent>
                    <DialogContentText>
                        Specify the purpose and amount for the fees. If possible, do not change the amount so that your contributors can track the correct collection statistics.
                    </DialogContentText>
                    <TextField
                        autoFocus
                        id="outlined-name"
                        margin="normal"
                        fullWidth
                        label="Name"
                        name="name"
                        onChange={handleChange}
                    />
                    <TextField
                        id="outlined-multiline-static"
                        margin="normal"
                        fullWidth
                        label="Description"
                        name="description"
                        onChange={handleChange}
                        multiline
                        rows={4}
                    />
                    <FormControl fullWidth>
                        <InputLabel htmlFor="outlined-adornment">Amount</InputLabel>
                        <OutlinedInput
                            id="outlined-adornment-amount"
                            onChange={handleChange}
                            startAdornment={<InputAdornment position="start">$</InputAdornment>}
                            name="price"
                            label="Amount"
                        />
                    </FormControl>
                </DialogContent>
                <DialogActions>
                    <Button onClick={handleClose}>Cancel</Button>
                    <Button onClick={handleSubmit}>Create</Button>
                </DialogActions>
            </Dialog>
        </div>
    );
}