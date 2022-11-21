import React, {FC, ReactElement} from 'react';
import {Paper, Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Typography} from "@mui/material";
import {ILastMonthContributorDonates} from "../../../models/ILastMonthContributorDonates";

interface TableProps {
    lastMonthDonates: ILastMonthContributorDonates[]
}

const LastMonthDonatesTable: FC<TableProps> = ({lastMonthDonates}): ReactElement => {

    if (lastMonthDonates.length === 0) {
        return <Typography variant="h6" sx={{mb: 3}}>You haven't donated in the last month.</Typography>
    }

    return (
        <>
            <Typography variant="h5" sx={{mb: 3}}>Last month donates</Typography>
            <TableContainer component={Paper} sx={{mb: 3}}>
                <Table size="small" aria-label="a dense table">
                    <TableHead>
                        <TableRow>
                            <TableCell><b>Company</b></TableCell>
                            <TableCell><b>Sent ($)</b></TableCell>
                            <TableCell><b>Date</b></TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {lastMonthDonates.map((row) => (
                            <TableRow>
                                <TableCell>{row.company}</TableCell>
                                <TableCell>{row.sent}</TableCell>
                                <TableCell>{row.payed_at}</TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </TableContainer>
        </>
    );
};

export default LastMonthDonatesTable;