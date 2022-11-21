import React, {FC, ReactElement} from 'react';

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
    Typography
} from "@mui/material";

import {makeStyles} from "@material-ui/styles";
import {ILastWeekTransactions} from "../../../models/ILastWeekTransactions";
import {KeyboardArrowUp, KeyboardArrowDown} from "@mui/icons-material";

const useRowStyles = makeStyles({
    root: {
        '& > *': {
            borderBottom: 'unset',
        },
    },
});

interface RowProps {
    row: ILastWeekTransactions
}

const Row: FC<RowProps> = ({row}) => {
    const [open, setOpen] = React.useState(false);
    const classes = useRowStyles();

    return (
        <React.Fragment>
            <TableRow className={classes.root}>
                <TableCell component="th" scope="row">
                    <IconButton aria-label="expand row" size="small" onClick={() => setOpen(!open)}>
                        {open ? <KeyboardArrowUp /> : <KeyboardArrowDown />}
                    </IconButton>
                    {row.user}
                </TableCell>
            </TableRow>
            <TableRow>
                <TableCell style={{ paddingBottom: 0, paddingTop: 0 }} colSpan={6}>
                    <Collapse in={open} timeout="auto" unmountOnExit>
                        <Box margin={1}>
                            <Typography variant="h6" gutterBottom component="div">
                                Transactions
                            </Typography>
                            <Table size="small" aria-label="purchases">
                                <TableHead>
                                    <TableRow>
                                        <TableCell>Date</TableCell>
                                        <TableCell>Sent ($)</TableCell>
                                    </TableRow>
                                </TableHead>
                                <TableBody>
                                    {row.transactions.map((transactionRow) => (
                                        <TableRow key={transactionRow.payed_at}>
                                            <TableCell component="th" scope="row">
                                                {transactionRow.payed_at}
                                            </TableCell>
                                            <TableCell>{transactionRow.sent}</TableCell>
                                        </TableRow>
                                    ))}
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
    lastWeekTransactions: ILastWeekTransactions[]
}

const LastWeekTransactionsTable: FC<TableProps> = ({lastWeekTransactions}): ReactElement => {

    return (
        <>
            <Typography variant="h5" sx={{mb: 3}}>Last week contributors transactions</Typography>
            <TableContainer component={Paper} sx={{mb: 3}}>
                <Table aria-label="collapsible table">
                    <TableHead>
                        <TableRow>
                            <TableCell><b>Contributor</b></TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {lastWeekTransactions.map((row) => (
                            <Row key={row.user} row={row} />
                        ))}
                    </TableBody>
                </Table>
            </TableContainer>
        </>
    );
}

export default LastWeekTransactionsTable;