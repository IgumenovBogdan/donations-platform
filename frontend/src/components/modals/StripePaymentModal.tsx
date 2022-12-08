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
import Input from '@mui/material/Input'
import FormControl from '@mui/material/FormControl'
import InputLabel from '@mui/material/InputLabel'
import {useContext} from "react";
import {Context} from "../../index";
import useAlert from "../../hooks/useAlert";
import CreditCardIcon from '@mui/icons-material/CreditCard';
import { IMaskInput } from 'react-imask';

interface CustomProps {
    onChange: (event: { target: { name: string; value: string } }) => void;
    name: string;
}

const TextMaskCustom = React.forwardRef<HTMLElement, CustomProps>(
    function TextMaskCustom(props, ref) {
        const { onChange, ...other } = props;
        return (
            <IMaskInput
                {...other}
                mask="0000 0000 0000 0000"
                definitions={{
                    '#': /[1-9]/,
                }}
                inputRef={ref as any}
                onAccept={(value: any) => onChange({ target: { name: props.name, value } })}
                overwrite
            />
        );
    },
);

export default function StripePaymentModal() {

    const { setAlert } = useAlert();

    const [open, setOpen] = React.useState(false);

    const handleClickOpen = () => {
        setOpen(true);
    };

    const handleClose = () => {
        setOpen(false);
    };

    return (
        <div>
            <Button type="submit"
                    fullWidth
                    variant="contained"
                    onClick={handleClickOpen}
                    sx={{ mt: 3 }}>
                Pay & Confirm
            </Button>
            <Dialog open={open} onClose={handleClose}>
                <DialogTitle>Payment with Stripe</DialogTitle>
                <DialogContent sx={{p: 3}}>
                    <TextField
                        id="input-with-icon-textfield"
                        label="Card number"
                        InputProps={{
                            startAdornment: (
                                <InputAdornment position="start">
                                    <CreditCardIcon />
                                </InputAdornment>
                            ),
                        }}
                        variant="standard"
                    />
                    <FormControl variant="standard">
                        <InputLabel htmlFor="formatted-text-mask-input">react-imask</InputLabel>
                        <Input
                            name="textmask"
                            id="formatted-text-mask-input"
                            inputComponent={TextMaskCustom as any}
                        />
                    </FormControl>
                </DialogContent>
                <DialogActions>
                    <Button onClick={handleClose}>Cancel</Button>
                    <Button onClick={handleClose}>Create</Button>
                </DialogActions>
            </Dialog>
        </div>
    );
}